<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Page;
use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Prince\Prince;

class GeneratePdfs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdfs:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to go through all pages with a download option and generate downkloadable PDFs.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = '/articles/800/tiffany-to-shine-at-the-art-institute-starting-this-fall';

        // Precede path with a slash
        if (substr($path, 0, 1) !== '/')
        {
            $path = '/' . $path;
        }

        // Now, produce the PDF
        set_time_limit(0);
        $html = file_get_contents(config('aic.protocol') . '://' . config('app.url') . $path . "?print=true");

        $prince = new Prince(config('aic.prince_command'));

        $prince->convert_string_to_file($html, storage_path('app/download.pdf'));
    }
}
