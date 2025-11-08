<?php

namespace App\Http\Controllers;

use App\Models\SupplierCategory;
use Illuminate\Http\Request;

class SupplierCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('modules.supplier_categories.index');
    }

    public function getSupplierCategoriesData()
    {
        return \Yajra\DataTables\Facades\DataTables::of(SupplierCategory::query())
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
                    <button type="button" data-id="'.$row->id.'" class="btn btn-xs btn-danger btn-eliminar btn-eliminar-supplier-category" title="Eliminar">
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
            'name' => 'required|string|max:255|unique:supplier_categories,name',
            'status' => 'required|in:active,inactive',
        ]);
        SupplierCategory::create($validated);
        return response()->json(['message' => 'Categoría de proveedor creada correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplierCategory = SupplierCategory::findOrFail($id);
        return response()->json($supplierCategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupplierCategory $supplierCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:supplier_categories,name,'.$id,
            'status' => 'required|in:active,inactive',
        ]);
        $supplierCategory = SupplierCategory::findOrFail($id);
        $supplierCategory->update($validated);
        return response()->json(['message' => 'Categoría de proveedor actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplierCategory = SupplierCategory::findOrFail($id);
        $supplierCategory->delete();
        return response()->json(['message' => 'Categoría de proveedor eliminada correctamente']);
    }
}
