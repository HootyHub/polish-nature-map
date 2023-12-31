<?php

namespace App\Jobs;

use App\Helpers\WikipediaSearchHelper;
use App\Models\SpatialFeature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePlacesDescriptionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $wikipediaSearch = new WikipediaSearchHelper();

        $spatialFeatures = SpatialFeature::whereNull('description')->get();

        foreach ($spatialFeatures as $spatialFeature) {
            $data = $wikipediaSearch->query($spatialFeature->name);

            if ($data !== null) {
                $description = $data['extract'];
                $sourceLink = $data['fullurl'];

                $spatialFeature->description = $description;
                $spatialFeature->description_source = $sourceLink;

                $spatialFeature->save();
            }
        }
    }
}
