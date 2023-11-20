<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\FutsalField;
use App\Models\Hour;
use App\Models\Payment;

use Midtrans\Snap;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SebastianBergmann\LinesOfCode\Counter;
use Symfony\Component\Console\Logger\ConsoleLogger;

class BookingController extends Controller
{
    public function getAllBooking(){
        $data = Booking::all();
        return view('master.bookings.list', [
            'data' => $data
        ]);
    }

    public function bookingField(){
        $futsalFields = FutsalField::getFieldActive();
        return view('formBooking/fieldForm',[
           'futsalFields' => $futsalFields,
        ]);
    }

    public function bookingFieldEX(){
        $futsalFields = FutsalField::getFieldActive();
        $times = Hour::getOpenTime();

        return view('formBooking/form',[
           'futsalFields' => $futsalFields,
           'times' => $times,

        ]);
    }
    
    public function bookingTime($path)
    {
        $futsalFields = FutsalField::where('path', $path)->firstOrFail();
        $field_id = $futsalFields->field_id;
        $times = Hour::getOpenTime();
        return view('formBooking/timeForm', [
            'times' => $times,
            'futsalFields' => $futsalFields
        ]);
    }

    public function timeRequest(Request $request)
    {
        // dd($request);
        $date = $request['tanggal'];
        $field = $request['lapangan'];
        $availableBooked = [];

        if ($date) {
            $timeBooked = DetailBooking::where('date_booked', $date)
                ->where('field_id', $field)
                ->select('start_time', 'end_time')
                ->get();

            //ambil waktu yang tersedia pada hari itu
            $timeOpen = Hour::getOpenTime();

            if ($timeBooked->isNotEmpty()) {
                //ambil range waktu antara start_time dan end_time (08:00:00,09:00:00,dst)
                //masukkan ke array waktu2 yang telah ter-booked
                $arrayBooked = [];
                foreach ($timeBooked as $time) {
                    $start_time = Carbon::parse($time->start_time);
                    $end_time = Carbon::parse($time->end_time);

                    while ($start_time < $end_time) {
                        $arrayBooked[] = $start_time->format('H:i:s');
                        $start_time->addHour();
                    }
                }
                //membandingkan arrayBooked dengan timeOpen jika tidak sama dengan yang dibooked masukan data timeOpen ke avalible booked 
                $availableBooked = array_values(array_diff($timeOpen, $arrayBooked));
            } else {
                $availableBooked = $timeOpen;
            }
            return response()->json(['data' => $availableBooked]);
        }
    }

    public function detailBooking(Booking $booking)
    {
        return view('formBooking.checkout', [
            'booking' => $booking
        ]);
    }

    public function detailBookingMaster(Booking $booking)
    {
        return view('master.bookings.detail', [
            'booking' => $booking
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $bookingData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required',
            'captcha' => 'required|captcha'
        ]);
        $times = $request['time'];
        $pricePerHour = $request['fieldPrice'];
        $start_first = Carbon::parse($times[0]);
        $end_time = Carbon::parse($times[sizeof($times)-1])->addHour();
        
        // $intervals = [];
        // foreach ($times as $time) {
        //     $start_time = Carbon::parse($time);
        //     $end_time = Carbon::parse($time);
        //     while ($start_time <= $end_time) {
        //         $intervals[] = $start_time->format('H:i:s');
        //         $start_time->addHour();
        //     }
        // }

        $countTime = count($times);
        $amount = count($times) * $pricePerHour;
    
        $bookingData['tanggal'] = Carbon::now('Asia/Phnom_Penh')->format('Y-m-d');
        $bookingData['status'] = Booking::PROCESS;
        $bookingData['amount'] = $amount;
        $bookingData['order_code'] = Booking::generateCode();
        
        $booking = Booking::create($bookingData);
        
        // $bookingId = Booking::getIdLatest();
        
        $detailParm = [
            'booking_id' => $booking->booking_id,
            'field_id' => $request['field_id'],
            'date_booked' => $request['tanggal'],
            'start_time' => $start_first->format('H:i:s'),
            'duration' => $countTime,
            'end_time' => $end_time->format('H:i:s'),
            'price' => $pricePerHour,
            'amount' => $amount
        ];

        // dd($booking, $detailParm);
        $detailBooking = DetailBooking::create($detailParm);

        self::_generatePaymentToken($booking, $detailBooking);

        if ($booking) {
            $toastMessage = [
                'type' => 'success',
                'message' => 'Thank you. Your booking has been received!'
            ];
            Session::flash('toast', $toastMessage);
            return redirect(route('checkBooking', ['booking' => $booking->booking_id]));
		}
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    private function _generatePaymentToken($booking, $detailBooking)
	{
        $this->initPaymentGateway();
		$customerDetails = [
            'name' => $booking->name,
            'email' => $booking->email,
			'phone' => $booking->phone,
		];

		$params = [
            'enable_payments' => Payment::PAYMENT_CHANNELS,
			'transaction_details' => [
                'order_id' => $booking->order_code,
				'gross_amount' => $booking->amount,
			],            
            
			'customer_details' => $customerDetails,
			'expiry' => [
                'start_time' => date('Y-m-d H:i:s T'),
				'unit' => Payment::EXPIRY_UNIT,
				'duration' => Payment::EXPIRY_DURATION,
			],
		];
        
		$snap = Snap::createTransaction($params);

		if ($snap->token) {
            $detailBooking->payment_status = DetailBooking::UNPAID;
            $detailBooking->payment_token = $snap->token;
			$detailBooking->payment_url = $snap->redirect_url;
			$detailBooking->save();
		}
	}

}

