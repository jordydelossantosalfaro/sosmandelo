<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('modules.categories.index');
    }

    public function getCategoriesData()
    {
        return DataTables::of(Category::query())
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
                    <button type="button" data-id="'.$row->id.'" class="btn btn-xs btn-danger btn-eliminar btn-eliminar-categoria" title="Eliminar">
                        <i class="material-icons md-delete" style="font-size:16px;vertical-align:middle;"></i>
                    </button>
                ';
            })
            ->rawColumns(['acciones', 'status'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        Category::create($validated);
        return response()->json(['message' => 'Categoría creada correctamente']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        $category = Category::findOrFail($id);
        $category->update($validated);
        return response()->json(['message' => 'Categoría actualizada correctamente']);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Categoría eliminada correctamente']);
    }
}
