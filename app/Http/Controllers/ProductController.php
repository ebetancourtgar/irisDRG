<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Product::class);

        $categories = Category::orderBy('name')->get();

        $products = Product::with(['brand', 'category'])
        ->filter($request->only(['category', 'search'])) 
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Product::class);
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('products.create', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Gate::authorize('create', Product::class);
        Product::create($request->validated());
        return redirect()->route('products.index')->with('success', 'Nuevo Producto Agregado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        Gate::authorize('view', $product);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        Gate::authorize('update', $product);
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('products.edit', compact('product', 'brands', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        Gate::authorize('update', $product);
        $product->update($request->validated());
        return redirect()->route('products.index')->with('success', 'Producto Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Gate::authorize('delete', $product);
        Product::destroy($product->id);
        return redirect()->route('products.index')->with('success', 'Producto Eliminado.');
    }
}
