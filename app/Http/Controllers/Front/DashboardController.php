<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Tag;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [];
        $data['ProductByCategory']=Product::with('categories')->get();
        $data['ProductByBrand']=Product::with('brand')->get();

        $data['sliders'] = Slider::get(['photo']);
        $data['categories'] = Category::parent()->select('id', 'slug')->with(['childrens' => function ($q) {
            $q->select('id', 'parent_id', 'slug');
            $q->with(['childrens' => function ($qq) {
                $qq->select('id', 'parent_id', 'slug');
            }]);
        }])->get();
        return view('front.home', $data);


    }

    public function showCategory($slug)
    {
        $data = [];
        $data['category'] = Category::where('slug', $slug)->first();

        if ($data['category'])
            $data['products'] = $data['category']->products;

        return view('front.products', $data);
    }

    public function showDeatails($slug)
    {

        $data = [];
        $data['product'] = Product::where('slug', $slug)->first();

        if ($data['product'])

            return view('front.products-details', $data);
    }
    public function showNewArrivls(){
        $data=[];

        return view('front.home',$data);
    }





















}
