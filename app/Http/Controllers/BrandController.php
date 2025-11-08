<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('modules.brands.index');
    }

    public function getBrandsData()
    {
        return \Yajra\DataTables\Facades\DataTables::of(Brand::query())
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
                    <button type="button" data-id="'.$row->id.'" class="btn btn-xs btn-danger btn-eliminar btn-eliminar-marca" title="Eliminar">
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
    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        Brand::create($validated);
        return response()->json(['message' => 'Marca creada correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return response()->json($brand);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        $brand = Brand::findOrFail($id);
        $brand->update($validated);
        return response()->json(['message' => 'Marca actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return response()->json(['message' => 'Marca eliminada correctamente']);
    }
}
