<?php

namespace App\Http\Services;

use Illuminate\Http\Services;
use Symfony\Component\HttpClient\HttpClient;

class WebScrapingService
{
    const BASE_URL = "https://www.milanuncios.com";

    private static function initCrawler($slug = '')
    {
        $client = new \Goutte\Client(HttpClient::create(['timeout' => 5]));
        return $client->request('GET', self::BASE_URL . $slug);
    }

    public static function getCategoriesAndSubcategories()
    {
        $crawler = self::initCrawler();
        $categories = $crawler->filter('.ma-CategoriesCategory')->each(function ($node){
            $name = $node->filter('.ma-MainCategory-mainCategoryNameLink')->each(function($nodeName){
                return $nodeName->text();
            });
            $subcategories = $node->filter('.ma-SharedCrosslinks-link')->each(function($nodeSubcategory){
                $href = $nodeSubcategory->extract(array('href'))[0];
                return [
                    "name" => $nodeSubcategory->text(),
                    "slug" => $href
                ];
            });
            return [
                "name" => $name[0],
                "subcategories" => $subcategories
            ];
        });
        return $categories;
    }
}
