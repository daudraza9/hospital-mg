<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    //
    public function index()
    {
        return view('department.index');
    }

    public function create()
    {
        return view('department.create');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'location'=>'required'
            ]);
        Department::create([
            'name'=>$request->name,
            'location' =>$request->location
        ]);
        return response()->json(['success'=>true,'message'=>'Department Added']);
    }
    public function datatable(Request $request)
    {
        $params =[
            'keyword'=>$request->keyword,
        ];
        $department =Department::select('*');

        if (isset($params['keyword']) && $params['keyword'] != '') {
            $keyword = $params['keyword'];
            $department->where(function ($department) use ($keyword) {
                $department->orWhere('name', 'like', '%' . $keyword . '%');
            });
        }
        if(request()->ajax())
        {
            return datatables()->of($department->orderBy('departments.id','asc')->get())
                ->addColumn('action', function($data){
                    $button = '<a href="'.route('department.edit',['id'=>$data->id]).'"> <button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" onclick="deleteDepartment('.$data->id.')" <button type="button" name="delete" id="" class="delete btn btn-danger btn-sm">Delete</button></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function delete(Request $request)
    {
        $department = Department::findorfail($request->id);
        $department->delete();
        return response()->json(['success'=>true,'message'=>'Department Deleted']);
    }
    public function edit(Request $request ,$id)
    {
        $department = Department::findorfail($id);
        return view('department.create',['department'=>$department]);
    }
    public function update(Request $request)
    {
        Validator::make($request->all(),[
           'name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:1',
           'location'=>'required'
        ]);
        $department = Department::findorfail($request->id);
        $department->name = $request->name;
        $department->location = $request->location;
        $department->save();

        return response()->json(['success'=>true,'message'=>'Department is updated successfully']);
    }
}
