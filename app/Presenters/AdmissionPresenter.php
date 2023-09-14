<?php

namespace App\Presenters;

use App\Models\Admission;
use App\Models\Fee;
use App\Models\FeeAge;
use App\Models\FeeCategory;
use Illuminate\Support\Str;

class AdmissionPresenter extends BasePresenter
{
    public function feeTitles()
    {
        $titles = [];

        foreach (FeeCategory::ordered()->get() as $category) {
            $title = [
                'title' => $category->title,
                'id' => Str::slug($category->title),
                'tooltip' => $category->tooltip
            ];

            $titles[$category->id] = $title;
        }

        return $titles;
    }

    public function feePrices()
    {
        $fees = Fee::all();
        $prices = [];

        foreach (FeeCategory::ordered()->get() as $category) {
            foreach (FeeAge::ordered()->get() as $age) {
                $fee = $fees->where('fee_age_id', $age->id)->where('fee_category_id', $category->id)->first();

                if ($fee) {
                    $price = [
                        'title' => $age->title,
                        'title_en' => $age->title,
                        $category->id => $fee->price
                    ];

                    $prices[$category->id][$age->id] = $price;
                }
            }
            $prices[$category->id]['description'] = $category->description;
            $prices[$category->id]['link_label'] = $category->link_label;
            $prices[$category->id]['link_url'] = $category->link_url;
        }

        return $prices;
    }
}
