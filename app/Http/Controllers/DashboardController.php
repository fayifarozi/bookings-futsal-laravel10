<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Payment;
class DashboardController extends Controller
{
    public function getInfoBooking(){
        return view('master.index');
    }

    public function getFilterByMounts(){
        // $currentDate = Carbon::now();
        // $oneYearAgo = $currentDate->subYear();

        $data = Booking::where('status', Booking::COMPLETED)
            // ->whereBetween('created_at', [$oneYearAgo, $currentDate])
            ->get()
            ->groupBy( function($data){
                return Carbon::parse($data->created_at)->format('M');
            });

        $labels = [];
        $quantity = [];
    
        foreach ($data as $mount => $values) {
            $labels[] = $mount;
            $quantity[] = $values->count();
        }
    
        return response()->json(['labels' => $labels, 'quantity' => $quantity]);
    }
}
