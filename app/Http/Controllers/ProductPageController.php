<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductPageController extends Controller
{
    public function getFoodStuff()
    {
        return view('product.foodstuff');
    }

    public function cart()
    {
        return view('pages.cart');
    }

    public function getProducts()
    {
        return view('product.products');
    }

    public function getSoupRecipes()
    {
        return view('product.soup');
    }

    public function getProteins()
    {
        return view('product.proteins');
    }

    public function getFruitsVegs()
    {
        return view('product.fruits_vegs');
    }

    public function getHerbsSpices()
    {
        return view('product.herbs_Spices');
    }

    public function getCoffeeTea()
    {
        return view('product.coffee_tea');
    }

    public function getBeveragesDrinks()
    {
        return view('product.cat_page');
    }

    public function getBreakfastCereal()
    {
        return view('product.cat_page');
    }

    public function getEggsDairy()
    {
        return view('product.cat_page');
    }
}
