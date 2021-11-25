<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\DoctorPatient;
use App\Models\Patient;
use App\Models\Room;
use App\Models\RoomPatient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoomController extends Controller
{
    //
    public function index()
    {
        return view('room.index');
    }
    public function create()
    {
        return view('room.create');
    }
    public function store(Request $request)
    {

        Validator::make($request->all(),[
           'floor_no'=>'required',
            'room_no'=>'required',
            'total_bed'=>'required'
        ])->validate();

        Room::create([
           'floor_no'=>$request->floor_no,
            'room_no'=>$request->room_no,
            'total_bed'=>$request->total_bed
        ]);

        return response()->json(['success'=>true,'message'=>'Room Added Successfully']);
    }
    public function datatable(Request $request)
    {
        if(request()->ajax())
        {
            return datatables()->of(Room::orderBy('rooms.id','asc')->get())
                ->addColumn('action', function($data){
                    $button = '<a href="'.route('room.edit',['id'=>$data->id]).'"> <button type="button" name="edit" id="" class="edit btn btn-primary btn-sm">Edit</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" onclick="deleteRoom('.$data->id.')" <button type="button" name="delete" id="" class="delete mr-1 btn btn-danger btn-sm">Delete</button></a>';
                    $button .= '<a href="'.route('room.patient.index',['id'=>$data->id]).'" onclick="" <button type="button" name="delete" id="" class="delete btn btn-danger btn-sm">Add Patient</button></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        $room = Room::findorfail($request->id);
        $room->delete();

        return response()->json(['success'=>true,'message'=>'Room Deleted Successfully']);
    }

    public function edit(Request $request,$id)
    {
        $room = Room::findorfail($id);
        return view('room.create',['room'=>$room]);
    }
    public function update(Request $request)
    {
        Validator::make($request->all(),[
            'floor_no'=>'required',
            'room_no'=>'required',
            'total_bed'=>'required'
        ])->validate();

        $room = Room::findorfail($request->id);
        $room->floor_no = $request->floor_no;
        $room->room_no = $request->room_no;
        $room->total_bed = $request->total_bed;
        $room->save();

        return response()->json(['success'=>true,'message'=>'Room Updated Successfully']);
    }
    public function  indexpatient(Request $request)
    {
        $room = Room::findorfail($request->id);
        return view('room.patient.index',compact('room'));
    }
    public function select(Request $request)
    {
        $room = Room::findorfail($request->room_id);

        $patient = Patient::leftjoin('room_patient',function ($join) use ($room){
            $join->on('room_patient.patient_id','=','patients.id');
            $join->where('room_patient.room_id','=',$room->id);
        })->select('patients.id', 'patients.first_name', 'patients.last_name', 'patients.email')
            ->whereNull('room_patient.room_id');

        if ($request->has('search')) {
            $keyword = $request->search;
            $patient->where(function ($patient) use ($keyword) {
                $patient->orWhere('patients.first_name', 'like', '%' . $keyword . '%');
                $patient->orWhere('patients.last_name', 'like', '%' . $keyword . '%');
                $patient->orWhere('patients.email', 'like', '%' . $keyword . '%');
            });
        }
        return response()->json($patient->paginate(5, ['*'], 'page', $request->page));
    }
    public function createPatient(Request $request)
    {
//        $room = Room::findorfail($request->id);
//        return
    }
    public function storePatient(Request $request)
    {
        Validator::make($request->all(),[
            'patient' => 'required|min:1',
        ])->validate();

        foreach ($request->patient as $key) {
            RoomPatient::create([
                'patient_id' => $key,
                'room_id' => $request->room_id
            ]);
        }
        return response()->json(['success' => true, 'message' => 'Patient Added Successfully!']);

    }
    public function patientDatatable(Request $request)
    {
        $patient = Patient::join('room_patient','room_patient.patient_id','=','patients.id')
            ->where('room_patient.room_id','=',$request->id)
            ->select('patients.*');

        return Datatables::of($patient->latest())
            ->addColumn('action', function ($data) {
                $button = '<a href="#"> <button type="button" name="edit" onclick="deletePatient('.$data->id.')"   class="edit mr-1 btn btn-primary btn-sm text-right">Delete</button></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function deletePatient(Request $request)
    {
        $patient= RoomPatient::where('room_patient.room_id','=',$request->room_id)
        ->where('room_patient.patient_id','=',$request->id)
        ->delete();
        if($patient)
        {
            return response()->json(['success' => true, 'message', 'Patient Deleted']);
        }
        else{
            return response()->json(['success' => true, 'message', 'Patient not found']);
        }
    }
}
