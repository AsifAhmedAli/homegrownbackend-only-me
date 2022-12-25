<?php

  namespace App\Http\Controllers\Api;

  use App\AboutUs;
  use App\Distribution;
  use App\Faq;
  use App\Feature;
  use App\Gx\GxPricing;
  use App\GxHowItWork;
  use App\HomePage;
  use App\HowItWork;
  use App\Http\Controllers\Controller;
  use App\Hydro\HydroCategory;
  use App\Hydro\HydroProduct;
  use App\Kit;
  use App\Models\FeaturedCategory;
  use App\Models\GX\GXHomePage;
  use App\Models\KitSlider;
  use App\Models\Testimonial;
  use App\Models\Video;
  use App\OfferFeature;
  use App\Page;
  use App\PaypalPlan;
  use App\Pipes\PageRelationPipe;
  use App\Pipes\PageScopePipe;
  use App\Review;
  use App\Team;
  use App\Utils\Api\ApiHelper;
  use App\Utils\Api\ApiResponse;
  use App\Utils\Constants\Constant;
  use Illuminate\Http\Request;
  use Illuminate\Pipeline\Pipeline;

  class PageController extends Controller
  {
    private $commonScopePipe       = [
      PageScopePipe::class,
    ];
    private $activeAndRelationship = [
      PageScopePipe::class,
      PageRelationPipe::class
    ];

    public function getGXFeaturePage()
    {
      $data['feature'] = Feature::with([
        'sections' => function ($q) {
        $q->active();
        },
        'icons' => function ($query) {
        $query->active();
      }
      ])->active()->find(1);
      if ($data['feature']) {
         $data['message'] = 'GX Feature Page Content';
         return ApiResponse::success($data);
      } else {
        return errorResponse('Page Not Found.', null, 404);
      }
    }
    private function getAllActiveKits() {
      return Kit::take(3)->active()->where('size', '5x5')->get();
    }

    private function getAllActiveKitSliders() {
      return KitSlider::active()->oldest('order')->get();
    }

    private function getAllActiveTestimonials() {
      return Testimonial::active()->get();
    }

    private function getAllActiveVideos() {
      return Video::active()->get();
    }

    public function getGXHomePageContent()
    {
      $data['homepage'] = GXHomePage::active()->find(1);
      $data['teams']    = Team::take(3)->ofProject(Constant::SHOW_ON_HGP_PROJECT)->active()->get();
      $data['kits']    = $this->getAllActiveKits();
      if ($data['homepage']) {
        return successResponse('GX Home Page Content', $data);
      } else {
        return errorResponse('Page Not Found.', null, 404);
      }
    }
    public function getHomePageContent()
    {
      $data['homepage'] = HomePage::active()->find(1);
      $data['kits']    = $this->getAllActiveKits();
      $data['kit_sliders']    = $this->getAllActiveKitSliders();
        $data['testimonials']    = $this->getAllActiveTestimonials();
        $data['videos']    = $this->getAllActiveVideos();
      if (!$data['homepage']) {
        return errorResponse('Page Not Found.', null, 404);
      }
      $data['teams'] = Team::active()->ofProject(Constant::SHOW_ON_HGP_PROJECT)->get();
      $data['reviews'] = Review::approved()->get();
      $data['featureCategories'] = FeaturedCategory::with('hydro_category')->take(5)->latest()->get();
      $data['featureProducts'] = HydroProduct::withCount([
        'isFavorite' => function ($q) {
          $q->whereUserId(\Auth::guard('api')->id());
        }
      ])->with('price')->with('image:product_recid,url')->take(3)->featured()->latest()->get();

      $data['sliderProducts'] = HydroProduct::withCount([
        'isFavorite' => function ($q) {
          $q->whereUserId(\Auth::guard('api')->id());
        }
      ])->with('price')->with('image:product_recid,url')->take(3)->bannerProduct()->latest()->get();
      return successResponse('Home Page Content', $data);
    }

    public function show($slug)
    {
      if (!empty($slug)) {
        $page = Page::whereSlug($slug);
        $page = app(Pipeline::class)
          ->send($page)
          ->through($this->commonScopePipe)
          ->thenReturn();

        $page = $page->first();
        if ($page) {
          return successResponse('Page Detail', $page);
        } else {
          return errorResponse('Page Not Found.', null, 404);
        }
      }
      return errorResponse('Page Not Found.', null, 404);
    }

    public function aboutUs()
    {
      $page = AboutUs::active()->first();
      if ($page) {
        $response['page'] = $page;
        $response['offers'] = OfferFeature::active()->take(3)->get();
        $response['teams'] = Team::take(3)->get();
        $response['distributions'] = Distribution::select('title', 'phone', 'image', 'address', 'is_active')->active()->latest()->get();
        return successResponse('About Us Page', $response);
      } else {
        return errorResponse('About Us Page Not Found.', null, 404);
      }
    }
    public function searchHowItWordFaqs(Request $request)
    {
      $searchTerm = trim($request->searchTerm);
      $response['faqs']          = Faq::where('question', 'LIKE', "%{$searchTerm}%")->orWhere('answer', 'LIKE', "%{$searchTerm}%")->ofType(Faq::HGP)->howItWork()->active()->get();

      return ApiResponse::success($response);

    }
    public function howItWork()
    {
      if (ApiHelper::isHGP()) {
        $query            = HowItWork::active();
        $response['faqs'] = Faq::select('id', 'slug', 'question', 'answer', 'is_active')->ofType(Faq::HGP)->active()->howItWork()->get();
      } else {
        $query = GxHowItWork::active();
      }
      $page = $query->first();
      if ($page) {
        $response['how_it_work'] = $page;
        return ApiResponse::success($response);
      } else {
        return errorResponse('Page Not Found. ', null, 404);
      }
    }

    public function getGxPricingPage() {
      $response['page'] = GxPricing::with('included')->first();
      $response['faqs'] = ApiHelper::gxFaqs();
      $response['plans'] = PaypalPlan::active()->latest('id')->get();

      return response()->json($response);
    }

  }
