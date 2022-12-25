<?php

namespace App\Http\Controllers\Api;
use App\Faq;
use App\FaqCategory;
use App\Http\Controllers\Controller;
use App\Utils\Api\ApiHelper;
use App\Utils\Api\ApiResponse;
use Illuminate\Http\Request;


class FaqController extends Controller
{
  public function faqs($projectType)
  {
    $faqCategories = FaqCategory::active()->get();
    if (!$faqCategories->isEmpty()) {
      $firstOpenCategory            = $faqCategories[0]->id;
      $response['faqs']             = Faq::whereCategoryId($firstOpenCategory)->ofType($projectType)->active()->oldest()->get();
      $response['openCategorySlug'] = $faqCategories[0]->slug;
      $response['faqCategories']    = $faqCategories;
      return ApiResponse::success($response);
    } else {
      return ApiResponse::errorResponse('No FAQ category found', 400);
    }

  }

  public function gxFAqs()
  {
    $response['faqs'] = ApiHelper::gxFaqs();
    return response()->json($response);
  }

  public function getFaqsByCategory($slug, $projectType)
  {
    $category                  = FaqCategory::whereSlug($slug)->active()->first();
    $response['faqCategories'] = FaqCategory::active()->get();
    if (isset($category) && !empty($category)) {
      $response['faqs'] = Faq::whereCategoryId($category->id)->ofType($projectType)->active()->get();
    } else {
      $response['faqs'] = [];
    }

    return ApiResponse::success($response);

  }

  public function search(Request  $request)
  {
    $searchTerm = trim($request->searchTerm);
    $categorySlug = $request->categorySlug;
    $projectType = $request->projectType;
    $selectedCategory          = FaqCategory::whereSlug($categorySlug)->first();
    $response['faqs']          = Faq::where('question', 'LIKE', "%{$searchTerm}%")->orWhere('answer', 'LIKE', "%{$searchTerm}%")->whereCategoryId($selectedCategory->id)->ofType($projectType)->active()->get();
    $response['faqCategories'] = FaqCategory::active()->get();
    return ApiResponse::success($response);

  }
}
