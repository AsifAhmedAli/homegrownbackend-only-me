<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hydro_categoriesmodel;
use App\FeaturedCategoriesmodel;


class FeaturedCategories extends Controller
{
    function featuredCategory(){
        $ids = [];
        // $featured = FeaturedCategoriesmodel::all()->join(hydro_categoriesmodel::all());
        $featured = FeaturedCategoriesmodel::all();
        foreach($featured as $key){
            array_push($ids,$key->hydro_category_id);
        }
        // foreach($ids as $id){
            $asfd = hydro_categoriesmodel::whereIn('id', $ids)->get();
        // }

        // echo $featured[0]->hydro_category_id;
// $productCategory = Category::where('id', $product->category_id)->pluck('name')->first();
    // ->select('hydro_categories.name');
        return $asfd;
        // foreach($featured as $key){
        //     // $category_details = hydro_categoriesmodel::where('id',$key->hydro_category_id);
        //     echo $key->hydro_category_id;
        //     // echo hydro_categoriesmodel::all()->where('id',$key->hydro_category_id);

        // }
        // $lkn = $category_details->toArray();
        // $i = 0;
        // foreach($category_details as $key){
        //     $new = $key[$i];
        //     $i++;
        // }
        // return $lkn;
;

    }
}
