<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MembershipBannerSeeder extends Seeder
{
    public function run(): void
    {
        $this->changeRole('membership_banner_image');
    }

    private function changeRole($role)
    {
        \A17\Twill\Models\Block::where('type', 'membership_banner')->get()
            ->pluck('medias')->collapse()->filter()
            ->pluck('pivot')->filter()
            ->map(function ($item) use ($role) {
                $item->role = $role;
                $item->save();
            });
    }
}
