<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Example;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examples = Example::with('category')->latest()->get();

        return view('admin.examples.index', compact('examples'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.examples.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:examples,slug',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|string|in:draft,published',
            'is_active' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'document' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        // Generate slug if not provided
        if (! $validated['slug']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('examples', 'public');
        }

        // Handle document upload
        if ($request->hasFile('document')) {
            $validated['document'] = $request->file('document')->store('examples/documents', 'public');
        }

        Example::create($validated);

        return redirect()->route('examples.index')->with('success', 'Contoh berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Example $example)
    {
        return view('admin.examples.show', compact('example'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Example $example)
    {
        $categories = Category::all();

        return view('admin.examples.edit', compact('example', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Example $example)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:examples,slug,' . $example->id,
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|string|in:draft,published',
            'is_active' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'document' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        // Generate slug if not provided
        if (! $validated['slug']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('examples', 'public');
        }

        // Handle document upload
        if ($request->hasFile('document')) {
            $validated['document'] = $request->file('document')->store('examples/documents', 'public');
        }

        $example->update($validated);

        return redirect()->route('examples.index')->with('success', 'Contoh berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Example $example)
    {
        $example->delete();

        return redirect()->route('examples.index')->with('success', 'Contoh berhasil dihapus');
    }
}
