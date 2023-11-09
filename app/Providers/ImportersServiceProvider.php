<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Importers\NationalParkImporter;
use App\Importers\LandscapeParkImporter;

class ImportersServiceProvider extends ServiceProvider
{
    private array $importers = [
        NationalParkImporter::class,
        LandscapeParkImporter::class,
    ];

    public function register()
    {
        $this->app->singleton('importer.registry', function ($app) {
            return collect($this->importers);
        });
    }
}
