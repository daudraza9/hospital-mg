<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    //
    public function index()
    {
        return view('role.index');
    }
    public function create()
    {
        return view('role.create');
    }
    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'name'=>'required'
            ])->validate();
        Role::create([
            'name'=>$request->name
        ]);

        return response()->json(['success'=>true,'message'=>'Role Added']);
    }
    public function datatable(Request $request)
    {
        if(request()->ajax())
        {
            return datatables()->of(Role::orderBy('roles.id','asc')->get())
                ->addColumn('action', function($data){
                    $button = '<a href="'.route('role.edit',['id'=>$data->id]).'"> <button type="button" name="edit" class="edit btn btn-primary btn-sm text-right">Edit</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" onclick="deleteRole('.$data->id.')" <button type="button" name="delete" class="delete btn btn-danger btn-sm  text-right">Delete</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="'.route('role.permissionEdit',['id'=>$data->id]).'" <button type="button" name="manage" class="delete btn btn-secondary btn-sm  text-right">Manage Permission</button></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        $role = Role::findorfail($request->id);
        $role->delete();

        return response()->json(['success'=>true,'message'=>'Role Deleted']);

    }
    public function edit(Request $request,$id)
    {
        $role = Role::findorfail($id);
        return view('role.create',['role'=>$role]);
    }
    Public function update(Request $request)
    {
        Validator::make($request->all(),[
           'name'=>'required'
        ]);

        $role = Role::findorfail($request->id);
        $role->name = $request->name;
        $role->save();

        return response()->json(['success'=>true,'message'=>'Role Updated']);
    }
    public function permissionEdit(Request $request,$id)
    {
        $role = Role::findById($id);
        return view('role.permission',compact('role'));
    }
    public function permissionUpdate(Request $request,$id)
    {
        $role = Role::findorFail($id);
        $perms = array();
        foreach (permissions as $key => $permission) {
            if($request->has($key)) {
                $perms[] = $permission;
            }
        }
        if(isset($role)){
            $role->syncPermissions($perms);
            return response()->json(['success'=>true,'message'=>'Successfully updated!']);
        }
        return response()->json(['success'=>false,'message' => 'Role not found!']);
    }
    public function roleSelect(Request $request)
    {
        $roles = Role::select('*');

        if ($request->has('search')) {
            $keyword = $request->search;
            $roles->where(function ($roles) use ($keyword) {
                $roles->orWhere('name', 'like', '%' . $keyword . '%');
            });
        }

        return response()->json($roles->paginate(50, ['*'], 'page', $request->page));
    }
}
