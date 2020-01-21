<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateLinks extends Command
{

    protected $signature = 'update:links';

    protected $description = 'Remove old URLs from blocks';

    public function handle()
    {

        foreach( config('app.scrub_domains') as $url ) {
            $blocks = \A17\Twill\Models\Block::whereRaw("content::text LIKE '%" . $url . "%'");

            $blocks = $blocks->cursor();

            foreach( $blocks as $block ) {
                $content = $block->getOriginal('content');
                $content = str_replace("http:\/\/" . $url, '', $content);
                $content = str_replace("https:\/\/" . $url, '', $content);
                $content = str_replace('"' . $url, '"', $content);
                $block->content = $block->fromJson( $content ); // $casts as array
                $block->save();
                $this->info('Updated ' . $url . ' in ' . $block->blockable_type . ', #' . $block->blockable_id);
            }
        }

    }

}
