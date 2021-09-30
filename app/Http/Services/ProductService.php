<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Services;

class ProductService
{
    public static function get()
    {
        $where = [];
        if( !empty(request("category")) && is_numeric(request("category"))){
            $category = Category::find(request("category"));
            if( !empty($category) ){
                $where[] = ["subcategories.category_id", "=", $category->id];
            }
        }

        if( !empty(request("title")) ){
            $title = trim(filter_var ( request("title"), FILTER_SANITIZE_STRING));
            $where[] = ["products.name", "like", "%" .  $title . "%"];
        }

        if( !empty(request("description")) ){
            $description = trim(filter_var ( request("description"), FILTER_SANITIZE_STRING));
            $where[] = ["products.description", "like", "%" .  $description . "%"];
        }

        return Product::select("products.name", "products.description", "products.image", "products.price", "products.slug")
            ->join('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
            ->where($where)
            ->orderBy("products.id", "DESC")
            ->get();
    }
}
