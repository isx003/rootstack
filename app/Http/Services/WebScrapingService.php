<?php

namespace App\Http\Services;

use Illuminate\Support\Str;
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
        $products = $crawler->filter(".ma-AdCard")->each(function($nodeProduct){
            $name = $nodeProduct->filter('.ma-AdCard-titleLink')->first()->text();
            $slug = $nodeProduct->filter('.ma-AdCard-titleLink')->first()->extract(array('href'))[0];
            $description = $nodeProduct->filter('.ma-AdCardDescription-text')->first()->text();

            $price = $nodeProduct->filter('.ma-AdPrice-value')->first()->text();
            $price = trim(str_replace("€", "", $price));

            $photo = $nodeProduct->filter('.ma-AdCard-photo')->first()->extract(array('src'))[0];
            return compact("name", "description", "price", "photo", "slug");
        });
        return $products;
    }

    public static function generateImageName()
    {
        return Str::random(40)  . ".jpg";
    }

    public static function downloadImage($url)
    {
        $imageName = WebScrapingService::generateImageName();
        $imgPath = public_path("img/{$imageName}");
        file_put_contents($imgPath, file_get_contents($url));
        return $imageName;
    }
}
