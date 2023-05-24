<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function getAllBooking()
    {
        $data = Booking::all();
        return view('master.bookings.list', [
            'data' => $data
        ]);
    }
}