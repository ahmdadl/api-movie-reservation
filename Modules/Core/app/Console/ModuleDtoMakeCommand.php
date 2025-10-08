<?php

declare(strict_types=1);

namespace Modules\Core\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\Make\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * @codeCoverageIgnore
 */
final class ModuleDtoMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    protected $argumentName = 'name';

    protected $name = 'module:make-dto';

    protected $description = 'Create a new DTO class for the specified module.';

    public function getDestinationFilePath(): string
    {
        $path = $this->laravel['modules']->getModulePath(
            $this->getModuleName(),
        );

        $filePath =
            GenerateConfigReader::read('dto')->getPath() ??
            config('modules.paths.app_folder');

        return $path.$filePath.'/'.$this->getDTOName().'.php';
    }

    public function getDefaultNamespace(): string
    {
        return config('modules.paths.generator.dto.namespace', 'Data');
    }

    protected function getTemplateContents(): string
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return new Stub($this->getStubName(), [
            'CLASS_NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClassNameWithoutNamespace(),
        ])->render();
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the DTO class.'],
            [
                'module',
                InputArgument::OPTIONAL,
                'The name of module will be used.',
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            [
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Create the class even if the DTO already exists.',
            ],
        ];
    }

    protected function getDTOName(): string
    {
        return Str::studly($this->argument('name'));
    }

    protected function getStubName(): string
    {
        return '/dto.stub';
    }

    private function getClassNameWithoutNamespace(): string
    {
        return class_basename($this->getDTOName());
    }
}
