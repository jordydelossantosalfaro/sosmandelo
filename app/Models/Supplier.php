<?php

namespace App\Models;

use App\Models\SupplierCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_category_id',
        'document_type',
        'document_number',
        'name',
        'phone1',
        'phone2',
        'whatsapp',
        'email',
        'opening_time',
        'closing_time',
        'working_days',
        'business_name',
        'address',
        'latitude',
        'longitude',
        'image',
        'status',
    ];

    public function supplierCategories()
    {
        return $this->belongsToMany(SupplierCategory::class, 'supplier_category_suppliers');
    }
}
