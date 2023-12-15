<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
        $category = Request::get('category');
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) use($name, $category) {
            $query->where(function ($query) use ($value, $name, $category) {
                Collection::wrap($value)->each(function ($value) use ($query, $name, $category) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$name}%")
                        ->orWhere('category', 'LIKE', "%{$category}%");
                });
            });
        });

        return Inertia::render('Products/List', [
            'filters' => Request::all('search', 'category'),
            'products' =>  QueryBuilder::for(Product::class)
                ->filter(Request::only('search', 'category'))
                ->orderBy('name')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($product) => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'category' => ucfirst($product->category),
                ]),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
