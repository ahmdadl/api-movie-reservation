<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @codeCoverageIgnore
 */
final class FilamentChartDataService
{
    /**
     * @param  array<int, string|Carbon>|null  $customRange
     * @param  array<string, array<string>>|null  $multipleDatasets
     * @return array{labels: array<string>, datasets: array<int, array{label: string, data: array<int, int|float>}>}
     */
    public function generate(
        Model|Builder $modelOrBuilder,
        string $dateColumn = 'created_at',
        ?string $period = null,
        ?array $customRange = null,
        string $aggregate = 'count',
        ?string $aggregateColumn = null,
        ?array $multipleDatasets = null,
    ): array {
        $builder =
            $modelOrBuilder instanceof Model
                ? $modelOrBuilder->newQuery()
                : clone $modelOrBuilder;

        // Determine date range
        /** @var Carbon|null $start */
        /** @var Carbon|null $end */
        $start = null;
        $end = null;

        if ($customRange) {
            $start = $this->toCarbon($customRange[0])->startOfDay();
            $end = $this->toCarbon($customRange[1])->endOfDay();
        } elseif ($period) {
            // @phpstan-ignore-next-line array-key-type
            [$start, $end] = $this->getDateRange($period);
        }

        if ($start && $end) {
            $builder->whereBetween($dateColumn, [$start, $end]);
        }

        $driver = DB::getDriverName();
        $groupFormat = $this->getGroupFormat($period, $driver);

        /** @var array<int, array{label: string, data: array<int, int|float>}> $datasets */
        $datasets = [];
        /** @var array<string> $labels */
        $labels = [];

        if ($multipleDatasets) {
            /** @var string $datasetKey */
            /** @var array<string> $values */
            foreach ($multipleDatasets as $datasetKey => $values) {
                /** @var string $value */
                foreach ($values as $value) {
                    $query = (clone $builder)->where($datasetKey, $value);

                    /** @var array<string, int|float> $data */
                    $data = $this->aggregateByDate(
                        query: $query,
                        dateColumn: $dateColumn,
                        groupFormat: $groupFormat,
                        aggregate: $aggregate,
                        aggregateColumn: $aggregateColumn,
                        driver: $driver,
                        start: $start,
                        end: $end,
                        period: $period,
                    );

                    $labels = $labels ?: array_keys($data);
                    $datasets[] = [
                        'label' => ucfirst($value),
                        'data' => array_values($data),
                    ];
                }
            }
        } else {
            /** @var array<string, int|float> $data */
            $data = $this->aggregateByDate(
                query: $builder,
                dateColumn: $dateColumn,
                groupFormat: $groupFormat,
                aggregate: $aggregate,
                aggregateColumn: $aggregateColumn,
                driver: $driver,
                start: $start,
                end: $end,
                period: $period,
            );

            $labels = array_keys($data);
            $datasets[] = [
                'label' => ucfirst($aggregate).
                    ($aggregateColumn ? " of $aggregateColumn" : ''),
                'data' => array_values($data),
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    /**
     * @return array<string, int|float>
     */
    private function aggregateByDate(
        Builder $query,
        string $dateColumn,
        string $groupFormat,
        string $aggregate,
        ?string $aggregateColumn,
        string $driver,
        ?Carbon $start,
        ?Carbon $end,
        ?string $period,
    ): array {
        $aggColumn = $aggregateColumn ?? '*';

        if ($driver === 'pgsql') {
            $formattedDate = "to_char($dateColumn, '{$groupFormat}')";
        } else {
            $formattedDate = "DATE_FORMAT($dateColumn, '{$groupFormat}')";
        }

        /** @var Collection<string, int|float> $pluckResult */
        $pluckResult = $query
            ->selectRaw(
                "$formattedDate as label, {$this->aggregateExpression(
                    $aggregate,
                    $aggColumn,
                )} as total",
            )
            ->groupBy('label')
            ->orderBy('label')
            ->pluck('total', 'label');

        $rawData = $pluckResult->toArray();

        return $this->fillMissingDates($rawData, $start, $end, $period);
    }

    private function aggregateExpression(
        string $aggregate,
        string $column,
    ): string {
        return match ($aggregate) {
            'sum' => "SUM($column)",
            'avg' => "AVG($column)",
            'min' => "MIN($column)",
            'max' => "MAX($column)",
            default => "COUNT($column)",
        };
    }

    /**
     * @param  array<string, int|float>  $data
     * @return array<string, int|float>
     */
    private function fillMissingDates(
        array $data,
        ?Carbon $start,
        ?Carbon $end,
        ?string $period,
    ): array {
        if (! $start || ! $end) {
            return $data;
        }

        /** @var array<string, int|float> $labels */
        $labels = [];
        $current = $start->copy();

        while ($current <= $end) {
            $label = match ($period) {
                'day' => $current->format('H:i'),
                'week', 'month' => $current->format('Y-m-d'),
                'year' => $current->format('Y-m'),
                default => $current->format('Y-m-d'),
            };

            $labels[$label] = $data[$label] ?? 0;

            $current->add(
                match ($period) {
                    'day' => 'hour',
                    'week', 'month' => 'day',
                    'year' => 'month',
                    default => 'day',
                },
                1,
            );
        }

        return $labels;
    }

    private function toCarbon(string|Carbon $date): Carbon
    {
        return $date instanceof Carbon ? $date : Carbon::parse($date);
    }

    /**
     * @return array{0: Carbon|null, 1: Carbon|null}
     */
    private function getDateRange(string $period): array
    {
        $now = Carbon::now();

        return match ($period) {
            'day' => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            'week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'month' => [
                $now->copy()->startOfMonth(),
                $now->copy()->endOfMonth(),
            ],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            default => [null, null],
        };
    }

    private function getGroupFormat(?string $period, string $driver): string
    {
        if ($driver === 'pgsql') {
            return match ($period) {
                'day' => 'HH24:MI',
                'week', 'month' => 'YYYY-MM-DD',
                'year' => 'YYYY-MM',
                default => 'YYYY-MM-DD',
            };
        }

        return match ($period) {
            'day' => '%H:%i',
            'week', 'month' => '%Y-%m-%d',
            'year' => '%Y-%m',
            default => '%Y-%m-%d',
        };
    }
}
