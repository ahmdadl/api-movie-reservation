<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @codeCoverageIgnore
 */
final class ModelStatisticsService
{
    private Builder $query;

    /** @var string The Eloquent aggregation method (count, sum, avg, etc.). */
    private string $aggregationMethod = 'count';

    /** @var string The column to aggregate. */
    private string $aggregationColumn = '*';

    /** @var string The column used for date filtering. */
    private string $dateColumn = 'created_at';

    public function __construct(
        Model|Builder $modelOrBuilder,
        string $dateColumn = 'created_at',
    ) {
        $this->dateColumn = $dateColumn;
        $this->query =
            $modelOrBuilder instanceof Model
                ? $modelOrBuilder->query()
                : $modelOrBuilder;
    }

    // Set custom aggregation (count, sum, avg, etc.)
    public function aggregateBy(string $method, string $column = '*'): self
    {
        $this->aggregationMethod = $method;
        $this->aggregationColumn = $column;

        return $this;
    }

    // Add custom filters to the query
    /**
     * @param  callable(Builder): void  $callback
     */
    public function filter(callable $callback): self
    {
        // call_user_func is unnecessary when using $callback(...)
        $callback($this->query);

        return $this;
    }

    // Today vs Yesterday
    /**
     * @return array{current: int|float, previous: int|float, difference: int|float, percentage: float, trend: 'up'|'down', is_positive: bool}
     */
    public function getDailyTrend(): array
    {
        /** @var int|float $today */
        $today = $this->getAggregateForDate(today());
        /** @var int|float $yesterday */
        $yesterday = $this->getAggregateForDate(today()->subDay());

        return $this->calculateTrend($today, $yesterday);
    }

    // This Week vs Last Week
    /**
     * @return array{current: int|float, previous: int|float, difference: int|float, percentage: float, trend: 'up'|'down', is_positive: bool}
     */
    public function getWeeklyTrend(): array
    {
        /** @var int|float $currentWeek */
        $currentWeek = $this->getAggregateForDateRange(
            today()->startOfWeek(),
            today()->endOfWeek(),
        );

        /** @var int|float $lastWeek */
        $lastWeek = $this->getAggregateForDateRange(
            today()->subWeek()->startOfWeek(),
            today()->subWeek()->endOfWeek(),
        );

        return $this->calculateTrend($currentWeek, $lastWeek);
    }

    // This Month vs Last Month
    /**
     * @return array{current: int|float, previous: int|float, difference: int|float, percentage: float, trend: 'up'|'down', is_positive: bool}
     */
    public function getMonthlyTrend(): array
    {
        /** @var int|float $currentMonth */
        $currentMonth = $this->getAggregateForDateRange(
            today()->startOfMonth(),
            today()->endOfMonth(),
        );

        /** @var int|float $lastMonth */
        $lastMonth = $this->getAggregateForDateRange(
            today()->subMonth()->startOfMonth(),
            today()->subMonth()->endOfMonth(),
        );

        return $this->calculateTrend($currentMonth, $lastMonth);
    }

    // This Year vs Last Year
    /**
     * @return array{current: int|float, previous: int|float, difference: int|float, percentage: float, trend: 'up'|'down', is_positive: bool}
     */
    public function getYearlyTrend(): array
    {
        /** @var int|float $currentYear */
        $currentYear = $this->getAggregateForDateRange(
            today()->startOfYear(),
            today()->endOfYear(),
        );

        /** @var int|float $lastYear */
        $lastYear = $this->getAggregateForDateRange(
            today()->subYear()->startOfYear(),
            today()->subYear()->endOfYear(),
        );

        return $this->calculateTrend($currentYear, $lastYear);
    }

    // Historical Data for Charts
    /**
     * @param  'week'|'month'|'year'  $period
     * @return array<int, int|float>
     */
    public function getHistoricalData(string $period = 'week'): array
    {
        return match ($period) {
            'month' => $this->getMonthlyHistoricalData(),
            'year' => $this->getYearlyHistoricalData(),
            default => $this->getWeeklyHistoricalData(),
        };
    }

    /**
     * @return array<int, int|float>
     */
    private function getWeeklyHistoricalData(): array
    {
        return Cache::remember(
            $this->getCacheKey('weekly_history'),
            now()->addHours(6),
            function (): array {
                // Added return type
                $data = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = today()->subDays($i);
                    /** @var int|float $aggregate */
                    $aggregate = $this->getAggregateForDate($date);
                    $data[] = $aggregate;
                }

                return $data;
            },
        );
    }

    /**
     * @return array<int, int|float>
     */
    private function getMonthlyHistoricalData(): array
    {
        return Cache::remember(
            $this->getCacheKey('monthly_history'),
            now()->addHours(6),
            function (): array {
                // Added return type
                $data = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = today()->subMonths($i);
                    /** @var int|float $aggregate */
                    $aggregate = $this->getAggregateForDateRange(
                        $date->copy()->startOfMonth(),
                        $date->copy()->endOfMonth(),
                    );
                    $data[] = $aggregate;
                }

                return $data;
            },
        );
    }

    /**
     * @return array<int, int|float>
     */
    private function getYearlyHistoricalData(): array
    {
        return Cache::remember(
            $this->getCacheKey('yearly_history'),
            now()->addHours(6),
            function (): array {
                // Added return type
                $data = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = today()->subYears($i);
                    /** @var int|float $aggregate */
                    $aggregate = $this->getAggregateForDateRange(
                        $date->copy()->startOfYear(),
                        $date->copy()->endOfYear(),
                    );
                    $data[] = $aggregate;
                }

                return $data;
            },
        );
    }

    // Helper Methods
    /**
     * The return type of aggregation methods like count, sum, avg can be int or float.
     */
    private function getAggregateForDate(Carbon $date): int|float
    {
        return Cache::remember(
            $this->getCacheKey('date_'.$date->format('Y-m-d')),
            now()->addHours(6),
            fn (): int|float => $this->buildQuery() // Added return type
                ->whereDate($this->dateColumn, $date)
                ->{$this->aggregationMethod}($this->aggregationColumn) ?? 0, // Added null coalescence
        );
    }

    private function getAggregateForDateRange(
        Carbon $startDate,
        Carbon $endDate,
    ): int|float {
        // Added return type
        return Cache::remember(
            $this->getCacheKey(
                'range_'.
                    $startDate->format('Y-m-d').
                    '_'.
                    $endDate->format('Y-m-d'),
            ),
            now()->addHours(6),
            fn (): int|float => $this->buildQuery() // Added return type
                ->whereBetween($this->dateColumn, [$startDate, $endDate])
                ->{$this->aggregationMethod}($this->aggregationColumn) ?? 0, // Added null coalescence
        );
    }

    private function buildQuery(): Builder
    {
        return clone $this->query;
    }

    /**
     * @return array{current: int|float, previous: int|float, difference: int|float, percentage: float, trend: 'up'|'down', is_positive: bool}
     */
    private function calculateTrend(
        int|float $current,
        int|float $previous,
    ): array {
        $difference = $current - $previous;

        $percentageChange =
            $previous > 0
                ? round(($difference / $previous) * 100, 2)
                : ($current > 0
                    ? 100.0 // Ensure this is a float for consistency
                    : 0.0); // Ensure this is a float for consistency

        return [
            'current' => $current,
            'previous' => $previous,
            'difference' => $difference,
            'percentage' => $percentageChange,
            'trend' => $percentageChange >= 0 ? 'up' : 'down',
            'is_positive' => $percentageChange >= 0,
        ];
    }

    private function getCacheKey(string $type): string
    {
        $modelName = class_basename($this->query->getModel());
        $aggregation = "{$this->aggregationMethod}_{$this->aggregationColumn}";

        return "stats_{$modelName}_{$aggregation}_{$type}_".
            today()->format('Y-m-d');
    }
}
