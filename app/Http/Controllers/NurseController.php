<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Nurse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NurseController extends Controller
{
    //
    public function index()
    {
        return view('nurses.index');
    }

    public function create()
    {
        return view('nurses.create');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'email' => 'required|unique:nurses|email|',
            'phone' => 'required|min:10',
            'position' => 'required',
            'joined_at' => 'required|date',
            'department_id'=>'nullable|exists:departments,id'
        ])->validate();

        $nurse = Nurse::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'joined_at' => Carbon::parse($request->joined_at)->format('Y-m-d'),
            'department_id'=> $request->department
        ]);

        return response()->json(['success' => true, 'message' => 'Nurse Added Successfully!']);
    }

    public function datatable(Request $request)
    {
        $params =[
          'keyword'=>$request->keyword,
        ];
        $data=Nurse::select("nurses.*",DB::raw('CONCAT(nurses.first_name," ",nurses.last_name) as name'),'departments.name as department')
            ->leftjoin('departments','departments.id','=','nurses.department_id');
        if(isset($params['keyword']) && $params['keyword'] != ''){
            $keyword = $params['keyword'];
            $data->where(function ($data) use ($keyword) {
                $data->orWhere('first_name', 'like', '%' . $keyword . '%');
                $data->orWhere('last_name', 'like', '%' . $keyword . '%');
            });
        }
        if (request()->ajax()) {
            return datatables()->of($data->orderBy('nurses.id','asc'))
                ->addColumn('action', function ($data) {
                    $button = '<div style="width: 180px;"><a href="' . route('nurse.edit', ['id' => $data->id]) . '"> <button type="button" name="edit" id="" class="mr-1 edit btn btn-primary btn-sm">Edit</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" onclick="deleteNurse(' . $data->id . ')" id="" ><button type="button" name="delete" id="" class="delete btn btn-danger btn-sm">Delete</button></a></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        $nurse = Nurse::find($request->id);
        $nurse->delete();
        return response()->json(['success' => true, 'message' => "Nurse Deleted!"]);
    }

    public function edit(Request $request, $id)
    {
        $nurse = Nurse::find($id);
        return view('nurses.create', ['nurse' => $nurse]);
    }

    public function update(Request $request)
    {

        Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'email' => 'required|email|unique:nurses,email,' . $request->id,
            'phone' => 'required|min:10|unique:nurses,phone,' . $request->id,
            'position' => 'required',
            'joined_at' => 'required|date',
            'department_id'=>'nullable|exists:departments,id'
        ])->validate();

        $nurse = Nurse::findorfail($request->id);
        $nurse->first_name = $request->first_name;
        $nurse->last_name = $request->last_name;
        $nurse->email = $request->email;
        $nurse->phone = $request->phone;
        $nurse->position = $request->position;
        $nurse->joined_at = $request->joined_at;
        $nurse->department_id = $request->department;
        $nurse->save();

        return response()->json(['success' => true, 'message' => 'Nurse Updated Successfully!']);
    }

    public function selectDepartment(Request $request)
    {
        $department = Department::select('departments.id', 'departments.name');

        if ($request->has('search')) {
            $keyword = $request->search;
            $department->where(function ($department) use ($keyword) {
                $department->orWhere('departments.id', 'like', '%' . $keyword . '%');
                $department->orWhere('departments.name', 'like', '%' . $keyword . '%');
            });
        }
        return response()->json($department->paginate(5, ['*'], 'page', $request->page));
    }
}
