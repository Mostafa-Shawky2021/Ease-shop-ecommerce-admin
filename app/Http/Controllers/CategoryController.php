<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index() {
        $categoryLimit = 20;
        $category = Category::with('subCategories')
                                ->where('parent_id',NULL)
                                ->limit($categoryLimit)
                                ->get();

        return response($category);
    }
    public function categoriesProducts($category){
        $category = Category::with('products.images')
                                    ->where('cat_name',$category)
                                    ->first();
        return response($category);
      
    }   

    public function subCategories($category) {
        $category = Category::where('cat_name',$category)
                                ->first();
        if($category) {
            $subCategories = $category->subCategories;
            return response($subCategories);
        }
        return [];
    }


}
