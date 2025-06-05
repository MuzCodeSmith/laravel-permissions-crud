<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware():array
    {
        return [
            new Middleware('permission:view users',only:['index']),
            new Middleware('permission:edit users',only:['edit']),
            // new Middleware('permission:create users',only:['create']),
            // new Middleware('permission:delete users',only:['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('user.list',[
            'users'=>$users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name','ASC')->get();
        return view('user.create',[
            'roles'=>$roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|min:5|same:confirm_password',
            'confirm_password'=>'required',
        ]);

        if($validator->passes()){
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->email)
            ]);

            if($request->roles){
                $user->assignRole($request->roles);
            }else{
                $user->assignRole([]);
            }

            return redirect()->route('users.index')->with('success','User Created Successfully');
        }else{
            return redirect()->route('users.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
     
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $hasRoles = $user->roles->pluck('name');
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('user.edit', [
            'user' => $user,
            'roles' => $roles,
            'hasRoles' => $hasRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' =>'required|min:3',
            'email' => 'required|email|unique:users,email,'.$id .',id',
        ]);

        if($validator->passes()){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            if($request->roles){
                $user->syncRoles($request->roles);
            }else{
                $user->syncRoles([]);
            }
            return redirect()->route('users.index')->with('success','User Details Updated Successfully!');
        }else{
            return redirect()->route('users.edit',$id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
