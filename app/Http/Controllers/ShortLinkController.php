<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortLinkRequest;
use App\Http\Requests\UpdateShortLinkRequest;
use App\Models\ShortLink;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shortLinksCount = ShortLink::withTrashed()->count();
        return view('create', ['shortLinksCount' => $shortLinksCount]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShortLinkRequest $request)
    {
        $data = [
            "url" => $request->url,
            "expires_at" => $request->expires_at,
            "max_clicks" => $request->max_clicks,
            "slug" => $request->slug
        ];

        if(is_null($request->slug)) {
            $data["slug"] = Str::random(6);
        }

        $link = ShortLink::create($data);
        return redirect()->route('shortlink.create')->with("slug", $link->slug);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShortLink $shortlink)
    {
        $shortlink->increment('clicks');

        if(!is_null($shortlink->max_clicks) && $shortlink->clicks > $shortlink->max_clicks) {
            $shortlink->delete();
            return abort(404);
        }

        if(!is_null($shortlink->expires_at) && Carbon::parse($shortlink->expires_at) < Carbon::now()->startOfDay()) {
            $shortlink->delete();
            return abort(404);
        }

        return redirect($shortlink->url, 301);
    }
}
