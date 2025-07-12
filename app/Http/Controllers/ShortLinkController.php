<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortLinkRequest;
use App\Http\Requests\UpdateShortLinkRequest;
use App\Models\ShortLink;

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
        $shortLinksCount = ShortLink::count();
        return view('create', ['shortLinksCount' => $shortLinksCount]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShortLinkRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShortLink $shortLink)
    {
        dd($shortLink);
    }
}
