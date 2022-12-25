<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Tag;
use App\Page;
use App\Utils\Constants\Constant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $response['page'] = Page::whereSlug(Constant::BLOG_LISTING_PAGE_SLUG)->provider(request('provider', Constant::HGP))->active()->first();
        $query = Blog::select('id', 'name', 'short_description', 'slug', 'thumbnail_image', 'published_at')->provider(request('provider', Constant::HGP))->activeAndPublish()->latest('published_at');
        if ($request->has('tag')) {
            $tag = Tag::select('id')->whereSlug($request->tag)->first();
            $query = $query->where('tags_str', 'like', '%' . $tag->id . '%');
        }
        $response['blogs'] = $query->paginate(request('perPage', 9));
        return response()->json($response, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($slug)
    {
        $blog = Blog::provider(request('provider', Constant::HGP))->with([
            'sections' => function ($q) {
                $q->active();
            },
        ])->activeAndPublish()->whereSlug($slug)->first();
        $response['relatedBlog'] = Blog::provider(request('provider', Constant::HGP))->activeAndPublish()->where('slug', '!=', $slug)->take(3)->latest('published_at')->get();
        if ($blog) {
            $response['tags'] = Tag::select('name', 'slug')->whereIn('id', json_decode($blog->tags))->get();
            $response['blog'] = $blog;
            $code = 200;
        } else {
            $code = 404;
            $response['message'] = 'Blog Not Found';
        }
        return response()->json($response, $code);
    }
}
