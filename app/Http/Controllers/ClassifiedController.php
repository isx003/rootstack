<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Services\ProductService;
use App\Http\Services\WebScrapingService;

class ClassifiedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categories()
    {
        $subcategories = Subcategory::with("category")->get();
        return view("categories", compact("subcategories"));
    }

    public function products()
    {
        $categories = Category::all();
        $products = ProductService::get();
        return view("dashboard", compact("products", "categories"));
    }

    public function productsJson()
    {
        $products = ProductService::get();
        return response()->json($products);
    }

    public function crawler()
    {
        $subcategories = Subcategory::all();
        foreach($subcategories as $subcategory){
            $products = WebScrapingService::getProductsBySlug($subcategory->slug);
            foreach($products as $productData){
                $imageName = WebScrapingService::downloadImage($productData["photo"]);

                $product = new Product;
                $product->name = $productData["name"];
                $product->slug = $productData["slug"];
                $product->price = $productData["price"];
                $product->description = $productData["description"];
                $product->image = $imageName;

                $subcategory->products()->save($product);
            }
        }
    }
    
}
