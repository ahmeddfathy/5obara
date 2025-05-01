<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;


class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::orderBy('created_at', 'desc')
            ->paginate(9);

        return view('portfolio.index', compact('portfolios'));
    }

    public function show(Portfolio $portfolio)
    {
        $relatedProjects = Portfolio::where('project_type', $portfolio->project_type)
            ->where('id', '!=', $portfolio->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('portfolio.show', compact('portfolio', 'relatedProjects'));
    }
}
