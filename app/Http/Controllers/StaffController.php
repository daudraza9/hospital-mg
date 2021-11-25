<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        return view('staff.index');
    }
    public function create()
    {
        return view('staff.create');
    }
    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'first_name'=>'required|regex:/^[a-zA-Z]+$/u|max:10',
            'last_name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'email'=>'required|unique:staff|email',
            'phone'=>'required|min:10',
            'address'=>'required',
            'joined_at'=>'required|date',
            'salary'=>'required',
            'department'=>'required'
        ])->validate();

        Staff::create([
           'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'joined_at'=>Carbon::parse($request->joined_at)->format('Y-m-d'),
            'salary'=>$request->salary,
            'department'=>$request->department
        ]);
        return response()->json(['success' => true, 'message' => 'Staff Added Successfully!']);

    }
    public function datatable(Request $request)
    {
        $params =[
            'keyword'=>$request->keyword,
        ];

        $staff = Staff::select('*');
        if(isset($params['keyword']) && $params['keyword'] != ''){
            $keyword = $params['keyword'];
            $staff->where(function ($staff) use ($keyword) {
                $staff->orWhere('first_name', 'like', '%' . $keyword . '%');
                $staff->orWhere('last_name', 'like', '%' . $keyword . '%');
            });
        }

        if(request()->ajax())
        {
            return datatables()->of($staff->orderBy('staff.id','asc')->get())
                ->addColumn('name',function ($data){
                    return $data->first_name.' '.$data->last_name;
                })
                ->addColumn('action', function($data){
                    $button = '<div style="200px;"><a href="'.route('staff.edit',['id'=>$data->id]).'"> <button type="button" name="edit" id="" class="edit mr-1 btn btn-primary btn-sm text-right">Edit</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" onclick="deleteStaff('.$data->id.')" <button type="button" name="delete" id="" class="delete btn btn-danger btn-sm  text-right">Delete</button></a></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function delete(Request $request)
    {
         $staff = Staff::findorfail($request->id);
         $staff->delete();

         return response()->json(['success'=>true,'messgae'=>'Staff Deleted Successfully']);
    }
    public function edit(Request $request,$id)
    {
        $staff = Staff::findorfail($id);
        return view('staff.create',['staff'=>$staff]);
    }
    public function update(Request $request)
    {
        Validator::make($request->all(),[
            'first_name'=>'required|regex:/^[a-zA-Z]+$/u|max:10',
            'last_name'=>'required|regex:/^[a-zA-Z]+$/u|max:10',
            'email'=>'required|unique:staff,email,'.$request->id,
            'phone'=>'required|min:10',
            'address'=>'required',
            'joined_at'=>'required|date',
            'salary'=>'required',
            'department'=>'required'
        ])->validate();
        $staff = Staff::findorfail($request->id);
        $staff->first_name= $request->first_name;
        $staff->last_name= $request->last_name;
        $staff->email= $request->email;
        $staff->phone= $request->phone;
        $staff->address= $request->address;
        $staff->joined_at= $request->joined_at;
        $staff->salary= $request->salary;
        $staff->department= $request->department;
        $staff->save();
        return response()->json(['success'=>true,'message','Staff Updated Sucessfully']);
    }



}
