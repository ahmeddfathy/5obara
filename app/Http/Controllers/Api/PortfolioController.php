<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\JsonResponse
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

        return response()->json([
            'status' => 'success',
            'data' => $portfolio
        ]);
    }

    /**
     * Return categories/types of portfolio items
     *
     * @return \Illuminate\Http\JsonResponse
     */
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