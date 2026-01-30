<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('category')->get();
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:items,code',
            'name' => 'required|string|max:255',
            'selling_price' => 'required|integer|min:0',
            'buying_price' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
        ]);

        Item::create($validated);

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:items,code,' . $item->id,
            'name' => 'required|string|max:255',
            'selling_price' => 'required|integer|min:0',
            'buying_price' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
        ]);

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus');
    }
}
