<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    use HasFactory;
    protected $table = 'temp_hours';
    protected $fillable = [
        'hours',
        'status'
    ];

    public static function getOpenTime()
    {
        return self::where('status', 1)
            ->orderBy('hours', 'asc')
            ->pluck('hours')
            ->toArray();
    }
    
    public static function getTimeByMultiId($timeId){
        return self::whereIn('id', $timeId )->get();
    }

    public static function getRangeTime($timeStart, $timeEnd)
    {
        return self::whereBetween('hours', [$timeStart, $timeEnd])->get();
    }
}
