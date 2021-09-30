<?php

namespace App\Http\Services;

use Illuminate\Http\Services;
use Symfony\Component\HttpClient\HttpClient;

class WebScrapingService
{
    const BASE_URL = "https://www.milanuncios.com";

    private static function initCrawler($slug = '')
    {
        $client = new \Goutte\Client();
        return $client->request('GET', self::BASE_URL . $slug);
    }

    public static function getCategoriesAndSubcategories()
    {
        $crawler = self::initCrawler();
        $categories = $crawler->filter('.ma-CategoriesCategory')->each(function ($node){
            $name = $node->filter('.ma-MainCategory-mainCategoryNameLink')->first()->text();
            $subcategories = $node->filter('.ma-SharedCrosslinks-link')->each(function($nodeSubcategory){
                return [
                    "name" => $nodeSubcategory->text(),
                    "slug" => $nodeSubcategory->extract(array('href'))[0]
                ];
            });
            return compact("name", "subcategories");
        });
        return $categories;
    }

    public static function getProductsBySlug()
    {
        $slug = "/coches-de-segunda-mano";
        $crawler = self::initCrawler($slug);
        $products = $crawler->filter(".ma-AdCard")->each(function($nodeProduc){
            $name = $nodeProduc->filter('.ma-AdCard-titleLink')->first()->text();
            $description = $nodeProduc->filter('.ma-AdCardDescription-text')->first()->text();
            $price = $nodeProduc->filter('.ma-AdPrice-value')->first()->text();
            $price = trim(str_replace("€", "", $price));
            return compact("name", "description", "price");
        });
        dd($products);

    }
}
