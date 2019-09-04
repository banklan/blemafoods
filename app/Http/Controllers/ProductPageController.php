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
        return view('product.cat_page');
    }

    public function getFruitsVegs()
    {
        return view('product.cat_page');
    }

    public function getHerbsSpices()
    {
        return view('product.cat_page');
    }

    public function getCoffeeTea()
    {
        return view('product.cat_page');
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

    public function getToiletries()
    {
        return view('product.cat_page');
    }

    public function getHousehold()
    {
        return view('product.cat_page');
    }

    public function getGroceries()
    {
        return view('product.cat_page');
    }

    public function getKitchen()
    {
        return view('product.cat_page');
    }

    public function getSpecialOrder()
    {
        return view('product.cat_page');
    }

    public function services()
    {
        return view('services.services');
    }
}
