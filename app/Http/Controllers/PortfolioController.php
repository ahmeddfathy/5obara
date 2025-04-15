<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;


class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = Portfolio::orderBy('created_at', 'desc')
            ->paginate(9);

        return view('portfolio.index', compact('portfolios'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Portfolio $portfolio)
    {
        return view('portfolio.show', compact('portfolio'));
    }
}
