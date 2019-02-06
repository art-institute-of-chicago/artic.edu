<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMembershipBannerImageRole extends Migration
{
    public function up()
    {
        $this->changeRole('membership_banner_image');
    }

    public function down()
    {
        $this->changeRole('image');
    }

    private function changeRole($role)
    {
        \A17\Twill\Models\Block::where('type', 'membership_banner')->get()
            ->pluck('medias')->collapse()->filter()
            ->pluck('pivot')->filter()
            ->map(function($item) use ($role) {
                $item->role = $role;
                $item->save();
            });
    }
}
