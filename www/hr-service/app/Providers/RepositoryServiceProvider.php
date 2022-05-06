<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Repositories
        $repositoriesDirectory = app_path() . '/Hr/Repositories';
        $repositoryFiles = \File::Files($repositoriesDirectory);
        $repositoryFileNames = [];
        $excludeRepo = ['BaseRepository'];

        foreach ($repositoryFiles as $file) {
            $name = pathinfo($file)['filename'];
            if (!in_array($name, $excludeRepo)) {
                $repositoryFileNames[] = $name;
            }
        }

        foreach ($repositoryFileNames as $repositoryFileName) {
            $contract = 'App\Hr\Repositories\Contracts\\' . $repositoryFileName . 'Interface';
            $repository = 'App\Hr\Repositories\\' . $repositoryFileName;
            $this->app->singleton($contract, $repository);
        }

        // Services
        $servicesDirectory = app_path() . '/Hr/Services';
        $serviceFiles = \File::Files($servicesDirectory);

        $serviceFileNames = [];

        foreach ($serviceFiles as $file) {
            $name = pathinfo($file)['filename'];
            $serviceFileNames[] = $name;
        }

        foreach ($serviceFileNames as $serviceFileName) {
            $contract = 'App\Hr\Services\Contracts\\' . $serviceFileName . 'Interface';
            $service = 'App\Hr\Services\\' . $serviceFileName;
            $this->app->singleton($contract, $service);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
