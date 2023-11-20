<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getAllAdmin()
    {
        $data = User::latest()->paginate(5);
        return view('master.admin.list', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('master.admin.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        
        $validatedData['level'] = 'employee';

        if ($request->file('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/profiles'), $imageName);
            $validatedData['image'] = $imageName;
        } else {
            $validatedData['image'] = null;
        }
        User::create($validatedData);

        return redirect('/master/admin')->with('success', 'New admin has been added!');
    }

    public function show(User $user)
    {
        return $user;
    }

    public function edit(User $user)
    {
        return view('master.admin.edit', [
            'admin' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|email|unique:users,email';
        }

        if ($request->password != null){
            $rules['password'] = 'required|max:255';
        }

        $validatedData = $request->validate($rules);

        if ($request->level) {
            $validatedData['level'] = $request->level;
        }

        if ($request->hasFile('image')) {
            if($request->image_old){
                $imagePath = public_path('images/profiles/' . $request->image_old);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $imageNewName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/profiles'), $imageNewName);
            $validatedData['image'] = $imageNewName;
        }
        
        if ($request->password) {
            $validatedData['password'] = Hash::make($request->password);
        }

        User::where('user_id', $user->id)->update($validatedData);

        return redirect('/master/admin')->with('success', 'Update admin success!');
    }

    public function destroy(User $user)
    {
        // Storage::delete($user->image);
        User::destroy($user->id);
        return redirect('/master/admin')->with('success', 'User has been deleted!');
    }
}
