<?php

use App\Models\VanityRedirect;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        VanityRedirect::where('path', 'educator-resources')->delete();
    }

    public function down(): void
    {
        VanityRedirect::create([
            'path' => 'educator-resources',
            'destination' => '/resources/educators'
        ]);
    }
};
