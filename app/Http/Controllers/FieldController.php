<?php

namespace App\Http\Controllers;

use App\Models\FutsalField;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FieldController extends Controller
{
    public function getAllField()
    {
        $data = FutsalField::all();
        return view('master.fields.list', [
            'data' => $data
        ]);
    }

    public function createField()
    {
        return view('master.fields.create');
    }
    
    public function updateStatus(Request $request)
    {
        $data = FutsalField::findOrFail($request->field_id);
        
        if ($data !== null){
            $status = ($request->status === 'active') ? 'active' : 'deactive';
            $data->update([
                'status' => $status,
            ]);
    
            $toastMessage = [
                'type' => 'success',
                'message' => 'Updated Status Successfully'
            ];
            Session::flash('toast', $toastMessage);
            return redirect(route('fields'));
        } else {
            $toastMessage = [
                'type' => 'error',
                'message' => 'Updated Status Error'
            ];
            Session::flash('toast', $toastMessage);
            return redirect(route('fields'));
        }
    }

    public function store(Request $request)
    {
        // return $request->all();
        $validatedData = $request->validate([
            'field_name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,svg|max:8000',
        ]);
        
        $string = $request->field_name;
        $path = preg_replace('/[^a-zA-Z0-9]+/', '-', $string);
        $validatedData['path'] = strtolower($path);
        
        $imageName = strtolower($path).'_'.time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $validatedData['image'] = $imageName;

        FutsalField::create($validatedData);
        $toastMessage = [
            'type' => 'success',
            'message' => 'Field has been added!'
        ];
    
        Session::flash('toast', $toastMessage);
        return redirect(route('fields'));
    }

    public function editField($path){
        $data = FutsalField::getFieldByPath($path);
        return view('master.fields.edit',[
            'row' => $data
        ]);
    }

    public function updateField(Request $request){
        $validatedData = $request->validate([
            'field_name' => 'required',
            'description'=> 'required',
            'price' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $imageOld = $request->image_old;
            if($imageOld != null){
                $imagePath = public_path('images/' . $imageOld);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $imageNewName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageNewName);
            $validatedData['image'] = $imageNewName;
        } else {
            $validatedData['image'] = $request->image_old;
        }

        $string = $request->field_name;
        $path = preg_replace('/[^a-zA-Z0-9]+/', '-', $string);
        $fullPath = strtolower($path);
        $verif = FutsalField::where('path',$fullPath)->first();
        
        if($verif){
            $data = FutsalField::getFieldById($request->field_id);
            if ($data->price != $request->price || $data->image != $validatedData['image'] || $data->description != $validatedData['description']){
                $data->update([
                    'price' => $validatedData['price'],
                    'description'=> $validatedData['description'],
                    'image' => $validatedData['image']
                ]);
        
                $toastMessage = [
                    'type' => 'success',
                    'message' => 'Updated successfully'
                ];
            
                Session::flash('toast', $toastMessage);
                return redirect(route('fields'));
            } elseif ($data->field_name == $validatedData['field_name']){
                $toastMessage = [
                    'type' => 'warning',
                    'message' => 'Nothing changes'
                ];
                
                Session::flash('toast', $toastMessage);
                return redirect(route('fields'));
            } else {
                $toastMessage = [
                    'type' => 'error',
                    'message' => 'Lapangan already exist'
                ];
                
                Session::flash('toast', $toastMessage);
                return redirect(route('fields'));
            }
        }else{
            $validatedData['path'] = $fullPath;
        }
        
        $data = FutsalField::getFieldById($request->field_id);

        $data->update([
            'field_name' => $validatedData['field_name'],
            'description'=> $validatedData['description'],
            'price' => $validatedData['price'],
            'image' => $validatedData['image'],
            'path' => $validatedData['path']
        ]);

        $toastMessage = [
            'type' => 'success',
            'message' => 'Updated Futsal Field successfully'
        ];
    
        Session::flash('toast', $toastMessage);
        return redirect(route('fields'));
    }

    public function destroyField($id)
    {
        $data = FutsalField::findOrFail($id);
        $imageName = $data->image;
        $data->delete();

        if ($imageName) {
            $imagePath = public_path('images/' . $imageName);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $toastMessage = [
            'type' => 'success',
            'message' => 'Data and associated image deleted successfully'
        ];
    
        Session::flash('toast', $toastMessage);
        return response()->json(['message' => 'success']);
    }
}
