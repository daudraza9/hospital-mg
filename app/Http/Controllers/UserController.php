<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index(Request $request,$id)
    {
        $user = User::findorfail($id);
        return view('user.update_profile',['user'=>$user]);
    }

    public function update(Request $request)
    {
     Validator::make($request->all(),[
         'name'=>'requir ed|string|max:255',
         'email'=> 'required|string|email|max:255|unique:users,email,'.$request->id,
         'password'=>'nullable|min:8|confirmed'
     ])->validate();
     $user = User::findorfail($request->id);
        $user->name = $request->name;
        $user->email =$request->email;
        if(!empty($request->password))
        {
            $user->password=Hash::make(request('password'));
        }
        if($request->hasFile('avatar') && $request->file('avatar')->isValid())
        {
            $user->media()->delete();
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }
        $user->save();
        return response()->json(['success'=>true,'message'=>'User is update successfully']);
    }

    public function add(Request $request)
    {
        return view('user.add');
    }

    public function create(Request $request)
    {
        Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required'
        ])->validate();

     $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make(request('password'))
     ]);
     if($request->hasFile('avatar') && $request->file('avatar')->isValid())
     {
         $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
     }
     if($request->has('role'))
     {
        if(empty($request->role)){
            $user->syncRoles([]);
        }else{
            $user->syncRoles($request->role);
        }
     }

     return response()->json(['success'=>true,'message'=>'User Added']);
    }

    public function view(Request $request)
    {
        $user = User::latest()->get();
        return view('user.view',compact('user'));
    }

    public function usersList(Request $request){

        $params=[
            'keyword'=>$request->keyword,
            'role'=>$request->role,
        ];
        $user = User::select('*');
        if(isset($params['role']) && !empty($params['role'])) {
            $user = $user->role($params['role']);
        }

        if (isset($params['keyword'])) {
            $keyword = $params['keyword'];
            $user->where(function ($user) use ($keyword) {
                $user->orWhere('name', 'like', '%' . $keyword . '%');
            });
        }

        if(request()->ajax())
        {
            return DataTables::of($user)
                ->addColumn('action', function($data){
                    $button = '<a href="#"  onclick="deleteUser('.$data->id.')"> <button type="button" name="edit" id="" class="edit btn btn-primary btn-sm">Delete</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" onclick="viewProfile(`'.$data->getFirstMediaUrl('avatar','thumb').'`)"> <button type="button" name="delete" id="" class="delete btn btn-danger btn-sm">View Profile</button></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        $user = User::findorfail($request->id);
        $user->delete();
        return response()->json(['success'=>true,'message'=>'User Deleted']);
    }

}
