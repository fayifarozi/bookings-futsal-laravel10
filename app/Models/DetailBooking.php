<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBooking extends Model
{
    use HasFactory;
    protected $primaryKey='detail_id';
    protected $fillable = [
        'booking_id',
        'field_id',
        'date_booked',
        'start_time',
        'duration',
        'end_time',
        'price',
        'amount',
        'payment_status',
        'payment_token',
        'payment_url'
    ];

    public const PAID = 'paid';
	public const UNPAID = 'unpaid';

    public function isPaid()
    {
        return $this->payment_status == self::PAID;
    }

    public function bookings()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function fields()
    {
        return $this->belongsTo(FutsalField::class, 'field_id', 'field_id');
    }
}
