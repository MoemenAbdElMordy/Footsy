<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $products = Product::latest()->paginate(15);

        return view('pages.admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('pages.admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:men,women,kids',
            'brand' => 'required|string|max:255',
            'colors' => 'required|string',
            'sizes' => 'required|string',
            'images' => 'nullable|string',
            'images_upload' => 'nullable|array',
            'images_upload.*' => 'image|max:5120',
            'stock' => 'required|integer|min:0',
            'featured' => 'nullable|boolean',
        ]);

        $colors = collect(explode(',', $validated['colors']))
            ->map(fn ($v) => trim($v))
            ->filter()
            ->values()
            ->all();

        $sizes = collect(explode(',', $validated['sizes']))
            ->map(fn ($v) => trim($v))
            ->filter()
            ->map(function ($v) {
                return is_numeric($v) ? (float) $v : $v;
            })
            ->values()
            ->all();

        $imagesFromUrls = [];
        if (!empty($validated['images'])) {
            $imagesFromUrls = collect(explode(',', $validated['images']))
                ->map(fn ($v) => trim($v))
                ->filter()
                ->values()
                ->all();
        }

        $uploadedImages = [];
        foreach ($request->file('images_upload', []) as $file) {
            $path = $file->store('products', 'public');
            $uploadedImages[] = Storage::url($path);
        }

        $images = array_values(array_filter(array_merge($uploadedImages, $imagesFromUrls)));

        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'category' => $validated['category'],
            'brand' => $validated['brand'],
            'colors' => $colors,
            'sizes' => $sizes,
            'images' => $images,
            'stock' => $validated['stock'],
            'featured' => (bool) ($validated['featured'] ?? false),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created');
    }

    public function edit(Product $product)
    {
        return view('pages.admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:men,women,kids',
            'brand' => 'required|string|max:255',
            'colors' => 'required|string',
            'sizes' => 'required|string',
            'images' => 'nullable|string',
            'images_upload' => 'nullable|array',
            'images_upload.*' => 'image|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'string',
            'stock' => 'required|integer|min:0',
            'featured' => 'nullable|boolean',
        ]);

        $colors = collect(explode(',', $validated['colors']))
            ->map(fn ($v) => trim($v))
            ->filter()
            ->values()
            ->all();

        $sizes = collect(explode(',', $validated['sizes']))
            ->map(fn ($v) => trim($v))
            ->filter()
            ->map(function ($v) {
                return is_numeric($v) ? (float) $v : $v;
            })
            ->values()
            ->all();

        $imagesFromUrls = [];
        if (!empty($validated['images'])) {
            $imagesFromUrls = collect(explode(',', $validated['images']))
                ->map(fn ($v) => trim($v))
                ->filter()
                ->values()
                ->all();
        }

        $uploadedImages = [];
        foreach ($request->file('images_upload', []) as $file) {
            $path = $file->store('products', 'public');
            $uploadedImages[] = Storage::url($path);
        }

        $existingImages = $product->images ?? [];

        $removeImages = $validated['remove_images'] ?? [];
        if (!empty($removeImages)) {
            $existingImages = array_values(array_filter($existingImages, function ($img) use ($removeImages) {
                return !in_array($img, $removeImages, true);
            }));

            foreach ($removeImages as $img) {
                if (is_string($img) && str_starts_with($img, '/storage/')) {
                    $relative = ltrim(str_replace('/storage/', '', $img), '/');
                    if ($relative !== '') {
                        Storage::disk('public')->delete($relative);
                    }
                }
            }
        }

        $images = array_values(array_filter(array_merge($existingImages, $uploadedImages, $imagesFromUrls)));

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'category' => $validated['category'],
            'brand' => $validated['brand'],
            'colors' => $colors,
            'sizes' => $sizes,
            'images' => $images,
            'stock' => $validated['stock'],
            'featured' => (bool) ($validated['featured'] ?? false),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted');
    }
}
