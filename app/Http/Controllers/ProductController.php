<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('modules.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 'active')->orderBy('name', 'asc')->get();
        $brands = Brand::where('status', 'active')->orderBy('name', 'asc')->get();
        $subcategories = SubCategory::where('status', 'active')->orderBy('name', 'asc')->get();
        $suppliers = Supplier::where('status', 'active')->orderBy('name', 'asc')->get();
        $tags = Tag::orderBy('name', 'asc')->get(); // Agrega esta línea

        return view('modules.products.form', [
            'categories' => $categories,
            'brands' => $brands,
            'subcategories' => $subcategories,
            'suppliers' => $suppliers,
            'tags' => $tags, // Agrega esto al array
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'required|exists:brands,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'price' => 'required|numeric',
            'promotional_price' => 'nullable|numeric',
            'cost_price' => 'nullable|numeric',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        // Crear producto
        $product = Product::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'brand_id' => $validated['brand_id'],
            'supplier_id' => $validated['supplier_id'],
            'price' => $validated['price'],
            'promotional_price' => $validated['promotional_price'] ?? null,
            'cost_price' => $validated['cost_price'] ?? null
        ]);

        // Guardar tags
        if (!empty($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->id;
            }
            $product->tags()->sync($tagIds);
        }

        // Guardar imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'order' => $i,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['images', 'tags', 'category', 'subcategory', 'brand']);

        // Obtener productos relacionados priorizando familia del producto
        $relatedProducts = collect();

        // 1. Productos de la misma subcategoría (misma familia exacta)
        if ($product->subcategory_id) {
            $sameSubcategory = Product::where('id', '!=', $product->id)
                ->where('subcategory_id', $product->subcategory_id)
                ->with(['images', 'category', 'subcategory', 'brand'])
                ->limit(6)
                ->get();
            $relatedProducts = $relatedProducts->concat($sameSubcategory);
        }

        // 2. Si necesitamos más productos, agregar de la misma categoría pero diferente subcategoría
        if ($relatedProducts->count() < 8) {
            $sameCategory = Product::where('id', '!=', $product->id)
                ->where('category_id', $product->category_id)
                ->where('subcategory_id', '!=', $product->subcategory_id)
                ->with(['images', 'category', 'subcategory', 'brand'])
                ->limit(8 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->concat($sameCategory);
        }

        // 3. Si aún necesitamos más, agregar productos de la misma marca
        if ($relatedProducts->count() < 8) {
            $sameBrand = Product::where('id', '!=', $product->id)
                ->where('brand_id', $product->brand_id)
                ->where('category_id', '!=', $product->category_id)
                ->with(['images', 'category', 'subcategory', 'brand'])
                ->limit(8 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->concat($sameBrand);
        }

        // 4. Como último recurso, productos aleatorios
        if ($relatedProducts->count() < 8) {
            $randomProducts = Product::where('id', '!=', $product->id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->with(['images', 'category', 'subcategory', 'brand'])
                ->inRandomOrder()
                ->limit(8 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->concat($randomProducts);
        }

        // Remover duplicados y limitar a 8 productos únicos
        $relatedProducts = $relatedProducts->unique('id')->take(8);

        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->orderBy('name', 'asc')->get();
        $brands = Brand::where('status', 'active')->orderBy('name', 'asc')->get();
        $subcategories = SubCategory::where('status', 'active')->orderBy('name', 'asc')->get();
        $suppliers = Supplier::where('status', 'active')->orderBy('name', 'asc')->get();
        $tags = Tag::orderBy('name', 'asc')->get(); // Agrega esta línea

        // Cargar relaciones para mostrar imágenes y tags
        $product->load(['images', 'tags']);

        return view('modules.products.form', [
            'categories' => $categories,
            'brands' => $brands,
            'subcategories' => $subcategories,
            'suppliers' => $suppliers,
            'tags' => $tags, // Agrega esto al array
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'required|exists:brands,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'price' => 'required|numeric',
            'promotional_price' => 'nullable|numeric',
            'cost_price' => 'nullable|numeric',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        $product->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'brand_id' => $validated['brand_id'],
            'supplier_id' => $validated['supplier_id'],
            'price' => $validated['price'],
            'promotional_price' => $validated['promotional_price'] ?? null,
            'cost_price' => $validated['cost_price'] ?? null
        ]);

        // Actualizar tags
        if (isset($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->id;
            }
            $product->tags()->sync($tagIds);
        } else {
            $product->tags()->detach();
        }

        // Agregar nuevas imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'order' => $product->images()->count() + $i,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Eliminar imágenes físicas
            foreach ($product->images as $image) {
                if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }

            // Eliminar relaciones y el producto
            $product->images()->delete();
            $product->tags()->detach();
            $product->delete();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.products.index')
                ->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

    public function destroyImage($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = $product->images()->findOrFail($imageId);

        // Eliminar archivo físico
        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return response()->json(['success' => true, 'message' => 'Imagen eliminada correctamente.']);
    }

    // Mostrar el editor Summernote para la descripción
    public function editDescription(Product $product)
    {
        return view('modules.products.summernote-standalone', [
            'product' => $product
        ]);
    }

    // Guardar la descripción editada desde Summernote
    public function updateDescription(Request $request, Product $product)
    {
        $request->validate([
            'description' => 'nullable|string',
        ]);
        $product->description = $request->input('description');
        $product->save();
        return redirect()->route('products.summernote-standalone', $product->id)
            ->with('success', 'Descripción actualizada correctamente.');
    }

    /**
     * Muestra el catálogo de productos para clientes
     */
    public function catalog(Request $request)
    {
        $query = Product::with(['images', 'tags', 'category', 'subcategory', 'brand']);

        // Filtrado por categoría si se proporciona
        if ($request->has('categoria')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->categoria);
            });
        }

        // Filtrado por subcategoría si se proporciona
        if ($request->has('subcategoria')) {
            $query->where('subcategory_id', $request->subcategoria);
        }

        // Filtrado por marca si se proporciona
        if ($request->has('marca')) {
            $query->where('brand_id', $request->marca);
        }

        // Ordenar productos
        $orderBy = $request->get('orden', 'recientes');
        switch ($orderBy) {
            case 'precio_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'nombre_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'nombre_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'recientes':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);

        // Obtener todas las categorías para el carrusel
        $categories = Category::where('status', 'active')->orderBy('name', 'asc')->get();
        
        // Obtener subcategorías filtradas por la categoría seleccionada
        $subcategoriesQuery = Subcategory::where('status', 'active');
        if ($request->has('categoria')) {
            $subcategoriesQuery->where('category_id', $request->categoria);
        }
        $subcategories = $subcategoriesQuery->orderBy('name', 'asc')->get();
        
        // Obtener categoría seleccionada para mostrar información adicional
        $selectedCategory = null;
        if ($request->has('categoria')) {
            $selectedCategory = Category::find($request->categoria);
        }

        $brands = Brand::where('status', 'active')->orderBy('name', 'asc')->get();

        return view('catalog.index', compact('products', 'categories', 'subcategories', 'brands', 'selectedCategory'));
    }
}
