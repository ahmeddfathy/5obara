<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::orderBy('completion_date', 'desc')
            ->paginate(9);

        return response()->json([
            'status' => 'success',
            'data' => $portfolios,
            'pagination' => [
                'current_page' => $portfolios->currentPage(),
                'last_page' => $portfolios->lastPage(),
                'per_page' => $portfolios->perPage(),
                'total' => $portfolios->total()
            ]
        ]);
    }

    public function show(Portfolio $portfolio)
    {
        if ($portfolio->technologies) {
            if (is_string($portfolio->technologies)) {
                $portfolio->technologies = json_decode($portfolio->technologies) ?: [];
            }
        } else {
            $portfolio->technologies = [];
        }

        return response()->json([
            'status' => 'success',
            'data' => $portfolio
        ]);
    }

    public function categories()
    {
        $categories = Portfolio::select('type')
            ->distinct()
            ->whereNotNull('type')
            ->pluck('type');

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }
}