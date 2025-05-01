<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.portfolio.index', compact('portfolios'));
    }

    public function create()
    {
        return view('admin.portfolio.create');
    }

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

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;

        $count = 1;
        while (Portfolio::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        $validated['slug'] = $slug;

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

    public function edit(Portfolio $portfolio)
    {
        if ($portfolio->technologies) {
            $portfolio->technologies = json_decode($portfolio->technologies);
        }

        return view('admin.portfolio.edit', compact('portfolio'));
    }

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

        if ($portfolio->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;

            $count = 1;
            while (Portfolio::where('slug', $slug)->where('id', '!=', $portfolio->id)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $validated['slug'] = $slug;
        }

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
