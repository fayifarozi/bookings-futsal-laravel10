<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FutsalField extends Model
{
    use HasFactory;
    protected $primaryKey = 'field_id';
    protected $fillable = [
        'field_name',
        'price',
        'path',
        'image',
        'status'
    ];

    public static function getFieldById($id)
    {
        return self::findOrFail($id);
    }

    public static function getFieldByPath($path)
    {
        return self::where('path',$path)->first();
    }

    public static function getFieldActive()
    {
        return self::where('status', 'active')->get();
    }

    public function details()
    {
        return $this->hasMany(DetailBooking::class, 'field_id', 'field_id');
    }
}
