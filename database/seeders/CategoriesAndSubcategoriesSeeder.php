<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Http\Services\WebScrapingService;

class CategoriesAndSubcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = WebScrapingService::getCategoriesAndSubcategories();
        foreach($categories as $category){
            $categoryDB = new Category;
            $categoryDB->name = $category["name"];
            $categoryDB->save();
            $categoryDB->subcategories()->createMany($category["subcategories"]);
        }
    }
}
