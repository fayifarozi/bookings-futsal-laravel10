<?php

namespace App\Http\Controllers;

use App\Models\Hour;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function getAllSchedule()
    {
        $data = Hour::all();
        return view('master.schedules.schedule', [
            'data' => $data
        ]);                
    }

    public function addScheduleOpen(Request $request)
    {
        $validatedData = $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        try {
            Hour::truncate();
            
            $start_time = Carbon::parse($request->start_time);
            $end_time = Carbon::parse($request->end_time);
            while ($start_time <= $end_time) {
                Hour::create([
                    'hours' => $start_time->format('H:i:s')
                ]);
                $start_time->addHour();
            }
            $toastMessage = [
                'type' => 'success',
                'message' => 'New Time has been added'
            ];
        
            return redirect(route('schedules'))->with('toast', $toastMessage);
        } catch (\Throwable $th) {
            $toastMessage = [
                'type' => 'error',
                'message' => 'Error occurred while adding time',
            ];
            return redirect(route('schedules'))->with('toast', $toastMessage);
        }
    }

    public function updateStatus(Request $request){
        $data = Hour::getTimeByMultiId($request->select_id);
        
        if ($data->isNotEmpty()) {
            $status = ($request->status === 'active') ? 1 : 0;
    
            foreach ($data as $record) {
                $record->update([
                    'status' => $status,
                ]);
            }
            $toastMessage = [
                'type' => 'success',
                'message' => 'Updated Time successfully'
            ];
        
            Session::flash('toast', $toastMessage);
            return response()->json(['message' => 'success']);
            
        } else {
            $toastMessage = [
                'type' => 'error',
                'message' => 'Updated Time Error'
            ];
            
            Session::flash('toast', $toastMessage);
            return response()->json(['message' => 'error']);
        }
    }
}
