<?php

use Illuminate\Database\Seeder;
use App\Dish;
use App\Restaurant;
class DishSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    //One to Many  Restaurant to Dishes
    factory(Dish::class, 30) -> make()
    -> each(function($dish)
    {
      $restaurant = Restaurant::inRandomOrder() -> first();
      $dish-> restaurant() -> associate($restaurant);
      $dish -> save();
    });
  }
}
