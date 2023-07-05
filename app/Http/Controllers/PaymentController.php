<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\DetailBooking;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use App\Service\Midtrans\MidtransService;

class PaymentController extends Controller
{
    public function getAllPayment()
    {
        $data = Payment::all();
        return view('master.payments.list', [
            'data' => $data
        ]);
    }

    public function notification(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $payload = $request->getContent();
        // dd($payload);
        $notification = json_decode($payload);
        $validSignatureKey = hash("sha512",$notification->order_id . $notification->status_code . $notification->gross_amount . $serverKey);
        
        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }
        
        $this->initPaymentGateway();
        $paymentNotification = new \Midtrans\Notification();

        $booking = Booking::with('details')->where('order_code', $paymentNotification->order_id)->firstOrFail();
        
        if ($booking->details->isPaid()) {
            return response(['message' => 'The booking has been paid before'], 422);
        }

        $transaction = $paymentNotification->transaction_status;
        $type = $paymentNotification->payment_type;
        $fraud = $paymentNotification->fraud_status;

        $vaNumber = null;
        $vendorName = null;
        if (!empty($paymentNotification->va_numbers[0])) {
            $vaNumber = $paymentNotification->va_numbers[0]->va_number;
            $vendorName = $paymentNotification->va_numbers[0]->bank;
        }


        $paymentStatus = null;
        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $paymentStatus = Payment::CHALLENGE;
                }else if($fraud == 'accept'){
                    $paymentStatus = Payment::SUCCESS;
                }
            }
        } else if ($transaction == 'settlement') {
            $paymentStatus = Payment::SETTLEMENT;
        } else if ($transaction == 'pending') {
            $paymentStatus = Payment::PENDING;
        } else if ($transaction == 'deny') {
            $paymentStatus = PAYMENT::DENY;
        } else if ($transaction == 'expire') {
            $paymentStatus = PAYMENT::EXPIRE;
        } else if ($transaction == 'cancel') {
            $paymentStatus = PAYMENT::CANCEL;
        }

        $code_payment = Payment::generateCode();
        $paymentParams = [
            'order_code' => $paymentNotification->order_id,
            'number' => $code_payment,
            'amount' => $paymentNotification->gross_amount,
            'method' => 'midtrans',
            'status' => $paymentStatus,
            'token' => $paymentNotification->transaction_id,
            'payloads' => $payload,
            'payment_type' => $paymentNotification->payment_type,
            'va_number' => $vaNumber,
            'vendor_name' => $vendorName,
            'biller_code' => $paymentNotification->biller_code,
            'bill_key' => $paymentNotification->bill_key,
        ];
        
        $payment = Payment::create($paymentParams);

        if ($paymentStatus && $payment) {
            // dd(in_array($payment->status, [Payment::SUCCESS, Payment::SETTLEMENT]));
            if (in_array($payment->status, [Payment::SUCCESS, Payment::SETTLEMENT])) {
                $booking->status = Booking::COMPLETED;
                $booking->details->metode = $type;
                $booking->details->payment_status = DetailBooking::PAID;
                $booking->save();
                $booking->details->save();
            }
            if (in_array($payment->status, [Payment::DENY, Payment::EXPIRE])){
                $booking->status = Booking::CANCELLED;
                $booking->details->metode = $type;
                $booking->details->payment_status = DetailBooking::UNPAID;
                $booking->save();
                $booking->details->save();
            }
        }

        $message = 'Payment status is '. $paymentStatus;
        
        $response = [
            'code' => 200,
            'message' => $message,
        ];
        
        return response($response, 200);
    }

    public function finish(Request $request)
    {
        $code = $request->query('order_code');
        $booking = Booking::with('details')->where('order_code', $code)->firstOrFail();
        
        $toastMessage = [
            'type' => 'success',
            'message' => 'Thank you. For Complete Your Payment'
        ];
        
        Session::flash('toast', $toastMessage);
        return redirect(route('checkBooking', ['booking' => $booking->booking_id]));
    }

    public function unfinish(Request $request)
    {
        $code = $request->query('order_code');
        $booking = Booking::with('details')->where('order_code', $code)->firstOrFail();
        
        $toastMessage = [
            'type' => 'error',
            'message' => "Sorry, we couldn't process please finish your payment."
        ];
        
        Session::flash('toast', $toastMessage);
        return redirect(route('checkBooking', ['booking' => $booking->booking_id]));
    }

    public function failed(Request $request)
    {
        $code = $request->query('order_id');
        $booking = Booking::with('details')->where('order_code', $code)->firstOrFail();

        $toastMessage = [
            'type' => 'error',
            'message' => "Sorry, we couldn't process your payment"
        ];
        
        Session::flash('toast', $toastMessage);
        return redirect(route('checkBooking', ['booking' => $booking->booking_id]));
    }
}