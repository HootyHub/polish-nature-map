<?php

namespace App\Importers;

use App\Importers\GeojsonFeaturesImporter;
use App\Helpers\Facades\GeojsonFeatureFacade;
use App\DataSources\GDOSDataSource;
use GeojsonFeature;

class LandscapeParkImporter extends GeojsonFeaturesImporter
{
    const CATEGORY_NAME = "landscape_park";

    public function getFeatures(): array {
        $dataSource = new GDOSDataSource();

        $features = $dataSource->getData([ "typeName" => "GDOS:ParkiKrajobrazowe" ]);

        $features = GeojsonFeature::excludeFeaturesHasPhrase(phrase: "otulina", geojson: $features, paramName: "nazwa");
        $features = GeojsonFeature::convertToPoints($features);
        $features = GeojsonFeature::convertCrs($features, "2180", "4326");

        return $features;
    }
}
