<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_item';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'table_id',
        'item_id',
        'quantity',
        'total_price',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }
}
