<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'name',
        'admin_display_name',
        'description',
        'short_code',
        'reference_range',
        'unit',
        'conventional_reference_range',
        'conventional_unit',
        'specimen_type_id',
        'price',
        'enabled',
        'entry_datetime',
    ];
}
