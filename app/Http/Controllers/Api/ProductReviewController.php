<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Hydro\HydroProduct;
use App\Review;
use App\Utils\Api\ApiHelper;
use App\Utils\Api\ApiResponse;
use Auth;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    //
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $review = new Review();
            $review->hydro_product_id = $request->hydro_product_id;
            $review->reviewer_id = $user->id;
            $review->rating = $request->rating;
            $review->reviewer_name = $user->name;
            $review->comment = $request->review;
            $review->is_approved = 0;
            $review->save();
            $data = Review::with('user')->where('hydro_product_id','=',$request->hydro_product_id)->approved()->get();
            return successResponse(__('generic.review_submitted'),$data);
        } catch (\Exception $ex) {
            return errorResponse(__('generic.error'), $ex->getMessage());
        }
    }
}
