<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $table = 'tables';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'table_number',
        'statust',
        'price',
        'area',
    ];

    protected $casts = [
        'table_number' => 'integer',
        'statust' => 'string',
        'price' => 'integer',
        'area' => 'integer',
    ];
}
