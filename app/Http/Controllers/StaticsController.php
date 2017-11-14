<?php

namespace App\Http\Controllers;

use A17\CmsToolkit\Http\Controllers\Front\Controller as Controller;
use App\Presenters\StaticObjectPresenter;
use Faker\Generator as Faker;

class StaticsController extends Controller {
  protected $faker;

  function __construct(Faker $faker) {
      $this->faker = $faker;

      parent::__construct();
  }

  public function index($slug = "") {
      if ( !empty($slug) && method_exists($this, $function = str_replace('-','_',$slug))) {
          return $this->{$function}();
      }

      return view(($slug != "") ? "statics/{$slug}" : "statics/index");
  }

  public function home() {
    return view('statics/home', [
      'listingFeatured' => new StaticObjectPresenter([
        'title' => 'Testing listing featured',
        'date'  => $this->faker->date('d/m/Y'),
        'type'  => 'Now Open',
        'dateFormatted' => 'September 19, 2015 - January 3, 2016',
      ])
    ]);
  }

  // --------------------------------------------------------------------------------------------
  // SOME FAKER EXAMPLES
  // --------------------------------------------------------------------------------------------

  // $this->faker->uuid
  // $this->faker->name
  // $this->faker->uuid
  // $this->faker->country
  // $this->faker->firstName
  // $this->faker->lastName
  // $this->faker->date
  // $this->faker->boolean
  // $this->faker->randomDigit
  // $this->faker->sentence
  // $this->faker->company
  // $this->faker->city
  // $this->faker->year
  // $this->faker->numberBetween
  // $this->faker->isbn13
  // $this->faker->randomElement

}
