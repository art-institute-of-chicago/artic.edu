<?php

use App\Models\Experience;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ExperienceImage;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('experience_images', function (Blueprint $table) {
            $table->text('image_credits')->nullable()->after('inline_credits');
        });

        $experienceImages = ExperienceImage::all();

        foreach ($experienceImages as $instance) {
            $artist = $instance?->artist;
            $title = $instance?->credit_title;
            $date = $instance?->credit_date;
            $medium = $instance?->medium;
            $dimensions = $instance?->dimensions;
            $creditLine = $instance?->credit_line;
            $referenceNumber = $instance?->main_reference_number;
            $type = $instance?->credits_input;

            $imageCredit = '';

            $parts = [];

            if ($artist) {
                $parts[] = "<p>{$artist}</p>";
            }
            if ($title) {
                $parts[] = "<p>{$title}</p>";
            }
            if ($date) {
                $parts[] = "<p>{$date}</p>";
            }
            if ($medium) {
                $parts[] = "<p>{$medium}</p>";
            }
            if ($dimensions) {
                $parts[] = "<p>{$dimensions}</p>";
            }
            if ($referenceNumber) {
                $parts[] = "<p>{$referenceNumber}</p>";
            }

            $imageCredit = !empty($parts) ? implode('', $parts) : null;

            $instance->update(['image_credits' => $imageCredit]);
        }
    }

    public function down(): void
    {
        Schema::table('experience_images', function (Blueprint $table) {
            $table->dropColumn('image_credits');
        });
    }
};
