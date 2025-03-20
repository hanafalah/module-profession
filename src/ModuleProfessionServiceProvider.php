<?php

declare(strict_types=1);

namespace Hanafalah\ModuleProfession;

use Hanafalah\LaravelSupport\Providers\BaseServiceProvider;

class ModuleProfessionServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return $this
     */
    public function register()
    {
        $this->registerMainClass(ModuleProfession::class)
            ->registerCommandService(Providers\CommandServiceProvider::class)
            ->registers([
                '*',
                'Services' => function () {
                    $this->binds([
                        Contracts\ModuleProfession::class => new ModuleProfession,
                        Contracts\Profession::class => new Schemas\Profession,
                        Contracts\Occupation::class => new Schemas\Occupation
                    ]);
                }
            ]);
    }

    /**
     * Get the base path of the package.
     *
     * @return string
     */
    protected function dir(): string
    {
        return __DIR__ . '/';
    }

    protected function migrationPath(string $path = ''): string
    {
        return database_path($path);
    }
}
