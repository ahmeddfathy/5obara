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
        $portfolios = Portfolio::orderBy('completion_date', 'desc')
            ->paginate(9);

        return view('portfolio.index', compact('portfolios'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Portfolio $portfolio)
    {
        // Make sure technologies is always an array, even if it's null or a JSON string
        if ($portfolio->technologies) {
            if (is_string($portfolio->technologies)) {
                $portfolio->technologies = json_decode($portfolio->technologies) ?: [];
            }
        } else {
            $portfolio->technologies = [];
        }

        return view('portfolio.show', compact('portfolio'));
    }
}
