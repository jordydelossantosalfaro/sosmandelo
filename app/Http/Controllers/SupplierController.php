<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::with('supplierCategories')->paginate(10);
        return view('modules.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier_categories = \App\Models\SupplierCategory::where('status', 'active')->get();
        return view('modules.suppliers.form', compact('supplier_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_type' => 'required|in:DNI,RUC',
            'document_number' => 'required|unique:suppliers,document_number',
            'name' => 'required|string|max:255',
            'phone1' => 'nullable|string|max:255',
            'phone2' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'opening_time' => 'nullable',
            'closing_time' => 'nullable',
            'dias_atencion' => 'nullable|array',
            'business_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'required|in:Active,Inactive',
            'supplier_category' => 'required|array|min:1',
        ]);

        // Manejo del archivo
        $imagePath = null;
        if ($request->hasFile('file')) {
            $imagePath = $request->file('file')->store('suppliers', 'public');
        }

        // Guardar el proveedor
        $supplier = new Supplier();
        $supplier->document_type = $validated['document_type'];
        $supplier->document_number = $validated['document_number'];
        $supplier->name = $validated['name'];
        $supplier->phone1 = $validated['phone1'];
        $supplier->phone2 = $validated['phone2'];
        $supplier->whatsapp = $validated['whatsapp'];
        $supplier->email = $validated['email'];
        $supplier->opening_time = $validated['opening_time'];
        $supplier->closing_time = $validated['closing_time'];
        $supplier->working_days = isset($validated['dias_atencion']) ? json_encode($validated['dias_atencion']) : null;
        $supplier->business_name = $validated['business_name'];
        $supplier->address = $validated['address'];
        $supplier->latitude = $validated['latitude'];
        $supplier->longitude = $validated['longitude'];
        $supplier->image = $imagePath;
        $supplier->status = strtolower($validated['status']);
        $supplier->save();

        // Relacionar categorías
        $supplier->supplierCategories()->sync($validated['supplier_category']);

        return redirect()->route('suppliers.index')->with('success', 'Proveedor registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $supplier_categories = \App\Models\SupplierCategory::where('status', 'active')->get();
        $selected_categories = $supplier->supplierCategories->pluck('id')->toArray();
        return view('modules.suppliers.form', compact('supplier', 'supplier_categories', 'selected_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'document_type' => 'required|in:DNI,RUC',
            'name' => 'required|string|max:255',
            'phone1' => 'nullable|string|max:255',
            'phone2' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'opening_time' => 'nullable',
            'closing_time' => 'nullable',
            'dias_atencion' => 'nullable|array',
            'business_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'required|in:Active,Inactive',
            'supplier_category' => 'required|array|min:1',
        ]);

        // Manejo del archivo
        if ($request->hasFile('file')) {
            $imagePath = $request->file('file')->store('suppliers', 'public');
            $supplier->image = $imagePath;
        }

        // Actualizar datos
        $supplier->document_type = $validated['document_type'];
        // $supplier->document_number no se actualiza para mantener la unicidad
        $supplier->name = $validated['name'];
        $supplier->phone1 = $validated['phone1'];
        $supplier->phone2 = $validated['phone2'];
        $supplier->whatsapp = $validated['whatsapp'];
        $supplier->email = $validated['email'];
        $supplier->opening_time = $validated['opening_time'];
        $supplier->closing_time = $validated['closing_time'];
        $supplier->working_days = isset($validated['dias_atencion']) ? json_encode($validated['dias_atencion']) : null;
        $supplier->business_name = $validated['business_name'];
        $supplier->address = $validated['address'];
        $supplier->latitude = $validated['latitude'];
        $supplier->longitude = $validated['longitude'];
        $supplier->status = strtolower($validated['status']);
        $supplier->save();

        // Relacionar categorías
        $supplier->supplierCategories()->sync($validated['supplier_category']);

        return redirect()->route('suppliers.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            // Eliminar relaciones con categorías
            $supplier->supplierCategories()->detach();
            // Eliminar archivo de imagen si existe
            if ($supplier->image) {
                Storage::disk('public')->delete($supplier->image);
            }
            $supplier->delete();
            return redirect()->route('suppliers.index')->with('success', 'Proveedor eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')->with('error', 'Error al eliminar el proveedor: ' . $e->getMessage());
        }
    }
}
