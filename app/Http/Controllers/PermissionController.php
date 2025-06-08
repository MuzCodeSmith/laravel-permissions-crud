<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware():array
    {
        return [
            new Middleware('permission:view permissions',only:['index']),
            new Middleware('permission:edit permissions',only:['edit']),
            new Middleware('permission:create permissions',only:['create']),
            new Middleware('permission:delete permissions',only:['destroy']),
        ];
    }

    public function index()
    {
        return view('permissions.list');
    }
    
    public function data()
    {
        $permissions = Permission::select(['id', 'name', 'created_at']);
        return DataTables::of($permissions)
            ->addColumn('action', function ($permission) {
                $edit = auth()->user()->can('edit permissions') ? '<a href="' . route('permissions.edit', $permission->id) . '" class="bg-slate-600 text-sm text-white rounded-lg px-3 py-2 mr-2">Edit</a>' : '';
                $delete = auth()->user()->can('delete permissions') ? '<a href="javascript:void(0);" onclick="deletePermission(' . $permission->id . ')" class="bg-red-600 hover:bg-red-500 text-sm text-white rounded-lg px-3 py-2">Delete</a>' : '';
                return $edit . $delete;
            })
            ->editColumn('created_at', function ($permission) {
                return \Carbon\Carbon::parse($permission->created_at)->format('d M, Y');
            })
            ->rawColumns(['action']) // allow HTML in action column
            ->make(true);
    }

    public function create(){
        return view('permissions.create');
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:permissions|min:3',
        ]);

        if($validator->fails()){
            if($request->ajax()){
                session()->flash('error','Something Went Wrong');
                return response()->json([
                    'errors'=>$validator->errors()
                ],422);
            }
        }
            Permission::create(['name'=>$request->name]);

            if ($request->ajax()) {
                session()->flash('success','Permission Added Successfully!');
                return response()->json(['success' => true], 200);
            }
    }

    public function edit($id){
        $permission = Permission::findOrFail($id);
        return view('permissions.edit',['permission'=>$permission]);
    }

    public function update(Request $request, $id){
        $permission = Permission::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3|unique:permissions,name,'.$id.',id',
        ]);

        if($validator->fails()){
            if($request->ajax()){
                session()->flash('error',$validator->errors());
                return response()->json([
                    'errors'=>$validator->errors(),
                ],422);
                // return redirect()->route('permissions.edit',$id)->withInput()->withErrors($validator);
            }
        }

        $permission->name = $request->name;
        $permission->save();
        session()->flash('success','Permission Updated successfully!');
        if($request->ajax()){
            return response()->json([
                'success'=> true
            ],200);
        }
        // return redirect()->route('permissions.index')->with('success','Permission Updated Successfully!');

        // if($validator->passes()){
        //     $permission->name = $request->name;
        //     $permission->save();
        //     return redirect()->route('permissions.index')->with('success','Permission Updated Successfully!');
        // }else{
        //     return redirect()->route('permissions.edit',$id)->withInput()->withErrors($validator);
        // }
    }

    public function destroy(Request $request){
        $id = $request->id;

        $permission = Permission::find($id);

        if($permission == null){
            session()->flash('error','Permission not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $permission->delete();

        session()->flash('success', 'Permission deleted Successfully!');

        return response()->json([
            'status'=>true
        ]);
    }
}
