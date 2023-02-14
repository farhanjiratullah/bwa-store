<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Admin\ProductGalleryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Http\Requests\Admin\ProductRequest;

use App\Product;
use App\ProductGallery;

class DashboardProductController extends Controller
{
    public function index() {
        $products = Product::with(['galleries', 'category'])->where('users_id', Auth::user()->id)->get();

        return view('pages.dashboard-products', [
            'products' => $products
        ]);
    }

    public function create() {
        $categories = Category::all();

        return view('pages.dashboard-products-create', [
            'categories' => $categories
        ]);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $product = Product::create($data);

        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photo')->store('assets/product', 'public')
        ];

        ProductGallery::create($gallery);

        return redirect()->route('dashboard-product');
    }

    public function details($id) {
        $product = Product::with(['galleries', 'user', 'category'])->findOrFail($id);
        $categories = Category::all();

        return view('pages.dashboard-products-details', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $item = Product::findOrFail($id);

        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('dashboard-product');
    }

    public function uploadGallery(ProductGalleryRequest $request) {
        $data = $request->all();
        $data['photos'] = $request->file('photos')->store('assets/product', 'public');

        ProductGallery::create($data);

        return redirect()->route('dashboard-product-details', $request->products_id);
    }

    public function deleteGallery($id) {
        $item = ProductGallery::findOrFail($id);
        // dd($item->count());

        // if( $item->count() > 1 ) {
            $item->delete();
            return redirect()->route('dashboard-product-details', $item->products_id);
        // }

        // return redirect()->route('dashboard-product-details', $item->products_id)->session()->flash('failed', 'Photo cannot be deleted because photo atleast need 1 photo');
    }
}
