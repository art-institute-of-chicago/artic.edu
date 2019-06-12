<?php

namespace App\Console\Commands;

use App\Models\DigitalLabel;

use Illuminate\Console\Command;
use DB;

class UpdateContentBundles extends Command
{

    protected $signature = 'update:content-bundles {datahub_id?}';
    protected $description = 'Update digital label content and assets';

    public function handle()
    {
        $datahubId = $this->argument('datahub_id');

        // Construct endpoints for content bundle and asset library
        function endpoint($type, $datahubId) {
            if ($type === "asset") {
                return "http://digitallabels.artic.edu/comp/resources/public/experience/" . $datahubId . "/library";
            } elseif ($type === "content") {
                return "http://digitallabels.artic.edu/comp/resources/public/experience/" . $datahubId . "/content/published";
            }
        }

        // Check for datahub_id command param
        if(isset($datahubId)) {
            // Update a single digital label content bundle
            $record = DB::table('digital_labels')->where('datahub_id', $datahubId);
            $assetResponse = file_get_contents(endpoint("asset", $datahubId));
            $contentResponse = file_get_contents(endpoint("content", $datahubId));

            $record->update([
                'asset_library' => $assetResponse,
                'content_bundle' => $contentResponse
            ]);
        } else {
            // Update all digital label content bundles
            $digitalLabels = DB::table('digital_labels')->select('*')->get();
    
            foreach ($digitalLabels as $digitalLabel) {
                $record = DB::table('digital_labels')->where('datahub_id', $digitalLabel->datahub_id);
                $assetResponse = file_get_contents(endpoint("asset", $digitalLabel->datahub_id));
                $contentResponse = file_get_contents(endpoint("content", $digitalLabel->datahub_id));
    
                $record->update([
                    'asset_library' => $assetResponse,
                    'content_bundle' => $contentResponse
                ]);
            };
        }
    }
}


