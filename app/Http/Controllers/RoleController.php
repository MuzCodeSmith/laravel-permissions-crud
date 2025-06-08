<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\error;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }

    public function index()
    {
        return view('roles.list');
    }

    public function data()
    {
        $roles = Role::with('permissions')->select(['id', 'name', 'created_at']);
        return DataTables::of($roles)
            ->addColumn('permissions', function ($role) {
                return $role->permissions->pluck('name')->implode(', ');
            })
            ->addColumn('action', function ($role) {
                $edit = auth()->user()->can('edit roles')
                    ? '<a href="' . route('roles.edit', $role->id) . '" class="bg-slate-700 hover:bg-slate-500 text-sm text-white rounded-lg px-4 py-2 mr-2">Edit</a>' : '';

                $delete = auth()->user()->can('delete roles')
                    ? '<a href="javascript:void(0);" onclick="deleteRole(' . $role->id . ')" class="bg-red-700 hover:bg-red-500 text-sm text-white rounded-lg px-4 py-2">Delete</a>' : '';

                return $edit . $delete;
            })
            ->editColumn('created_at', function ($role) {
                return \Carbon\Carbon::parse($role->created_at)->format('d M, Y');
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.create', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);


        if ($validator->fails()) {
            if ($request->ajax()) {
                session()->flash('error', $validator0 > error());
                return response()->json(
                    [
                        'errors' => $validator->errors()
                    ],
                    422
                );
            }
        }

        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
        session()->flash('success', 'Role Created Successfully!');
        if ($request->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }

        return redirect()->route('roles.index')->with('success', 'Role added successfully');


        // if($validator->passes()){
        //     $role =Role::create(['name'=>$request->name]);
        //     if($request->permissions){
        //         foreach($request->permissions as $permission){
        //             $role->givePermissionTo($permission);
        //         }
        //     }
        //     return redirect()->route('roles.index')->with('success','Role added successfully');
        // }else{
        //     return redirect()->route('roles.create')->withInput()->withErrors($validator);
        // }

    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasRoles = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.edit', ['role' => $role, 'hasRoles' => $hasRoles, 'permissions' => $permissions]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . ',id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $role->name = $request->name;
        $role->save();
        if (!empty($request->permissions)) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        session()->flash('success','Role Updated Successfully');
        return response()->json([
                'status'=>true,
        ]);

        // if ($validator->passes()) {
        //     $role->name = $request->name;
        //     $role->save();
        //     if (!empty($request->permissions)) {
        //         $role->syncPermissions($request->permissions);
        //     } else {
        //         $role->syncPermissions([]);
        //     }
        //     return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
        // } else {
        //     return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        // }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::findOrFail($id);

        if ($role == null) {
            session()->flash('error', 'Role not found');
            return response()->json([
                'status' => false
            ]);
        }

        $role->delete();
        session()->flash('success', 'Role deleted successfully!');
        return response()->json([
            'status' => true
        ]);
    }
}
