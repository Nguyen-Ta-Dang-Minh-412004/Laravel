<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff'; 
    protected $primaryKey = 'id'; 

    public $incrementing = true; 

    protected $keyType = 'int';
    public $timestamps = false; 
    protected $fillable = [
        'name',
        'time_working',
        'position',
        'gender',
        'address',
    ];

    public function positionInfo()
    {
        return $this->belongsTo(Position::class, 'position');
    }
}
