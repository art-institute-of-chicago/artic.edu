<?php

namespace App\Console\Commands;

use Imagick;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

$PTIF_LAYER_MAX = 10000;

class MigrateOSCIPublicationMediaOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:osci-media-one {id : Publication ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate an OSCI publications\' IIP and 360º media from OSCI servers to S3';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pubId = $this->argument('id');
        $this->comment('Starting ' . $pubId . '...');

        # TODO: Query 360s too
        $assetsQuery = <<<EOT
        SELECT DISTINCT json_extract(layers.value,'$._image_ident') AS image_ident
        FROM figure_layers,
            json_each(figure_layers.data,'$.layers') AS layers
        WHERE json_extract(layers.value,'$._type')='iip'
                AND figure_layers.package=:pubId
        ORDER BY json_extract(layers.value,'$._height') ASC
EOT;

        $assets = DB::connection('osci_migration')->select($assetsQuery, ['pubId' => $pubId]);

        foreach ($assets as $asset) {
            // TODO: Check the asset type and handle 360 spins differently
            $key = trim($asset->image_ident, '/');
            $asset_key = preg_replace('/^\/?osci\//', '', $asset->image_ident);
            $jpg_key = preg_replace('/\.ptif$/', '.jpg', $key);

            if (!Storage::disk('osci_s3')->fileExists($asset_key)) {
                $this->info("OSCI_S3_BUCKET did not contain {$asset_key}!");
                continue;
            }

            if (Storage::disk('osci_s3')->fileExists($jpg_key)) {
                $this->info("OSCI_S3_BUCKET already contains {$jpg_key}, skipping this asset");
                continue;
            }

            $this->info("Compressing {$asset_key}");

            $content = Storage::disk('osci_s3')->get($asset_key);

            $image = new Imagick();
            $image->readImageBlob($content);

            // Iterate zoom layers to find a 10k-pixels-a-side page geometry
            while ($image->hasPreviousImage()) {
                $size = $image->getImagePage();

                if ($size['height'] > 10000 && $size['width'] > 10000) {
                    $image->nextImage();
                    break;
                }
                $image->previousImage();
            }

            $image->setImageFormat('jpeg');
            $compressed = $image->getImageBlob();

            $res = Storage::disk('osci_s3')->put($jpg_key, $compressed);

            if (!$res) {
                $this->info("There was an error uploading the compressed file to {$jpg_key}");
                continue;
            }

            echo "Uploaded {$jpg_key}\n";
        }
        $this->comment('...' . $pubId . ' done!');
    }
}
