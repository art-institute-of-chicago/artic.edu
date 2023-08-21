<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\PressRelease;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $all = PressRelease::all();

        foreach ($all as $pressRelease) {
            $pressRelease->title = StringHelpers::properTitleCase($pressRelease->title);
            $pressRelease->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
