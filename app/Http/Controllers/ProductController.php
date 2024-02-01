<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        $name = Request::get('search');

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) use($name) {
            $query->where(function ($query) use ($value, $name) {
                Collection::wrap($value)->each(function ($value) use ($query, $name) {
                    $query->where('name', 'LIKE', "%{$name}%");
                });
            });
        });

        return Inertia::render('Products/List', [
            'filters' => Request::all('search'),
            'products' =>  QueryBuilder::for(Product::class)
                ->filter(Request::only('search'))
                ->orderBy('name')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($product) => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'stock' => $product->stock,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(ProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')->with('message', 'Product Created Successfully');
    }

    public function edit($productId)
    {
        $product = Product::findOrFail($productId);

        return Inertia::render('Products/Edit', [
            'product' => $product
        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        $request->validated();
        $product = Product::findOrFail($id);
        $product->update($request->all());
        
        return redirect()->route('products.index')->with('message', 'Product edited successfully');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Product  $product
    * @return \Illuminate\Http\Response
    */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('message', 'Product Deleted Successfully');
    }
}
