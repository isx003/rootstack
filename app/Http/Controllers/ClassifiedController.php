<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
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

    public function crawlerBySlug()
    {
        WebScrapingService::getProductsBySlug("/coches-de-segunda-mano/");
    }
}
