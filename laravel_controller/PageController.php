<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Page;
use Spatie\Fractalistic\Fractal;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('web-api-auth');
    }

    /**
     *Get a page's detaails
     *
     * @param  string  $id
     * @return Response
     */
    public function getPageById($id)
    {
        $page = Page::find($id);
        if ($page) {

            return response()->json([
                'success' => true,
                'data' => $page,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'data' => [],
        ], 404);
    }

    /**
     * Get details for all pages.
     *
     *
     * @return Response
     */
    public function getAllPages()
    {
        $pages = Page::all();
        if ($pages) {
            return response()
                ->json([
                    "success" => true,
                    "data" => Fractal::create()
                        ->collection($pages, new \App\Transformers\PageTransformer())
                        ->serializeWith(\Spatie\Fractalistic\ArraySerializer::class)
                        ->toArray()
                    ], 200);
        }
        return response()->json([
            'success' => false,
            'data' => [],
        ], 404);
    }
}
