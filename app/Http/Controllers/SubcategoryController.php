<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('modules.subcategories.index', [
            'categories' => \App\Models\Category::all()
        ]);
    }

    public function getSubcategoriesData()
    {
        return \Yajra\DataTables\Facades\DataTables::of(\App\Models\Subcategory::with('category'))
            ->addColumn('category', function($row) {
                return $row->category ? $row->category->name : '';
            })
            ->addColumn('status', function($row) {
                if ($row->status === 'active') {
                    return '<span class="badge bg-success">Activo</span>';
                } else {
                    return '<span class="badge bg-warning">Inactivo</span>';
                }
            })
            ->addColumn('acciones', function($row) {
                return '
                    <button type="button" data-id="'.$row->id.'" class="btn btn-xs btn-warning btn-editar me-1" title="Editar">
                        <i class="material-icons md-edit" style="font-size:16px;vertical-align:middle;"></i>
                    </button>
                    <button type="button" data-id="'.$row->id.'" class="btn btn-xs btn-danger btn-eliminar btn-eliminar-subcategoria" title="Eliminar">
                        <i class="material-icons md-delete" style="font-size:16px;vertical-align:middle;"></i>
                    </button>';
            })
            ->rawColumns(['acciones', 'status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        \App\Models\Subcategory::create($validated);
        return response()->json(['message' => 'Subcategoría creada correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $subcategory = \App\Models\Subcategory::with('category')->findOrFail($id);
        return response()->json($subcategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        $subcategory = \App\Models\Subcategory::findOrFail($id);
        $subcategory->update($validated);
        return response()->json(['message' => 'Subcategoría actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subcategory = \App\Models\Subcategory::findOrFail($id);
        $subcategory->delete();
        return response()->json(['message' => 'Subcategoría eliminada correctamente']);
    }
}
