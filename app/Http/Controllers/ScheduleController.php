<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        
            Session::flash('toast', $toastMessage);
            return redirect(route('schedules'));
        } catch (\Throwable $th) {
            $toastMessage = [
                'type' => 'error',
                'message' => 'Error occurred while adding time',
            ];
            Session::flash('toast', $toastMessage);
            return redirect(route('schedules'));
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
