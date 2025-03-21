<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class SlideRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'attract_title' => 'max:150',
            'attract_subhead' => 'max:150'
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'attract_title' => 'max:150',
            'attract_subhead' => 'max:150',
            'article_title' => 'max:150',
            'caption' => 'max:150',
            'interstitial_headline' => 'max:150',
            'body_copy' => 'max:500',
            'object_title' => 'max:150',
            'compare_title' => 'max:500',
            'end_credit_subhead' => 'max:150',
            'end_copy' => 'max:150',
            'end_headline' => 'max:150'
        ];
    }
}
