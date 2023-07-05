<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $primaryKey = 'booking_id';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'tanggal',
        'status',
        'order_code',
        'amount'
    ];

    public const CODE = 'AUX';
    public const PROCESS = 'process';
	public const COMPLETED = 'completed';
	public const CANCELLED = 'cancelled';

    public static function getIdLatest(){
        return self::select('booking_id')->latest()->first();
    }

    public static function generateCode()
    {
        $dateCode = self::CODE . '/' . date('Ymd') . '/';

        $lastOrder = self::select('order_code')
            ->where('order_code', 'like', $dateCode . '%')
            ->first();
        if (isset($lastOrder)) {
            $lastOrderNumber = str_replace($dateCode, '', $lastOrder->order_code);
            $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
            $orderCode = $dateCode . $nextOrderNumber;
        } else {
            $orderCode = $dateCode . '00001';
        }

        if ($orderCode == $lastOrder || $orderCode == null) {
            return self::generateCode();
        }
        return $orderCode;
    }


    public function details()
    {
        return $this->hasOne(DetailBooking::class, 'booking_id', 'booking_id');
    }

}
