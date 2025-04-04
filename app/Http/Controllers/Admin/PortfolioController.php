<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = Portfolio::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.portfolio.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.portfolio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'client_name' => 'nullable|string',
            'completion_date' => 'nullable|date',
            'project_type' => 'required|string',
            'technologies' => 'nullable|array',
            'project_url' => 'nullable|url',
            'is_featured' => 'boolean'
        ]);

        // Generate slug from title
        $validated['slug'] = Str::slug($validated['title']);

        // Convert technologies array to JSON for storage
        if (!empty($validated['technologies'])) {
            $validated['technologies'] = json_encode($validated['technologies']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('portfolio', 'public');
        }

        Portfolio::create($validated);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portfolio $portfolio)
    {
        // Convert JSON technologies back to array for form
        if ($portfolio->technologies) {
            $portfolio->technologies = json_decode($portfolio->technologies);
        }

        return view('admin.portfolio.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'client_name' => 'nullable|string',
            'completion_date' => 'nullable|date',
            'project_type' => 'required|string',
            'technologies' => 'nullable|array',
            'project_url' => 'nullable|url',
            'is_featured' => 'boolean'
        ]);

        // Generate slug from title if title changed
        if ($portfolio->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Convert technologies array to JSON for storage
        if (!empty($validated['technologies'])) {
            $validated['technologies'] = json_encode($validated['technologies']);
        }

        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
            $validated['image'] = $request->file('image')->store('portfolio', 'public');
        }

        $portfolio->update($validated);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item deleted successfully.');
    }
}
