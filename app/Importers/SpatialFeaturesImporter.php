<?php

namespace App\Importers;

use App\Events\SpatialFeatureImporterRunEvent;
use App\Models\Category;
use App\Models\SpatialFeature;

abstract class SpatialFeaturesImporter {

    protected string $categoryName;

    protected function __construct(string $categoryName) {
        $this->categoryName = $categoryName;
    }

    public function getCategoryName(): string {
        return $this->categoryName;
    }

    public function run(): void{
        $category = Category::firstOrCreate(['name' => $this->getCategoryName()]);

        $features = $this->getFeatures();
        // todo
    }

    abstract public function getFeatures(): array;
}
