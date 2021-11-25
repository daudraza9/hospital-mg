<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    //
    public function index()
    {
        return view('patient.index');
    }
    public function create()
    {
        return view('patient.create');
    }
    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'first_name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'last_name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'email'=>'required|unique:patients|email|',
            'phone'=>'required|min:10',
            'age'=>'required',
            'weight'=>'required',
            'address'=>'required',
            'disease'=>'required',
            'gender'=>'required',
        ]);
        Patient::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'age'=>$request->age,
            'weight'=>$request->weight,
            'address'=>$request->address,
            'disease'=>$request->disease,
            'gender'=>$request->gender,
        ]);
        return response()->json(['success'=>true,'message'=>'Patient Added Successfully']);
    }
    public function datatable(Request $request)
    {
        $params = [
          'keyword'=>$request->keyword,
        ];
        $patient = Patient::select('*');

        if(isset($params['keyword']) && $params['keyword'] != ''){
            $keyword = $params['keyword'];
            $patient->where(function ($patient) use ($keyword){
               $patient->orWhere('first_name','like','%'.$keyword.'%');
               $patient->orWhere('last_name','like','%'.$keyword,'%');
            });
        }
        if(request()->ajax())
        {
            return datatables()->of($patient->orderBy('patients.id','asc')->get())
                ->addColumn('name',function ($data){
                    return $data->first_name. ' '.$data->last_name;
                })
                ->addColumn('action', function($data){
                    $button = '<div style="width: 330px;"><a href="'.route('patient.edit',['id'=>$data->id]).'"> <button type="button" name="edit"   class="edit mr-1 btn btn-primary btn-sm text-right">Edit</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" onclick="deletePatient('.$data->id.')"> <button type="button" name="delete"  class="delete mr-1 btn btn-danger btn-sm text-right">Delete</button></a>';
                    $button .= '<a href="#" onclick="viewAppointment('.$data->id.')"> <button  type="button" name="manage"  class="delete btn btn-secondary btn-sm ">View Appointment</button></a></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function delete(Request $request)
    {
        $patient = Patient::findorfail($request->id);
        $patient->delete();
        return response()->json(['success'=>true,'message'=>'Patient deleted Successfully']);
    }
    public function edit(Request $request,$id)
    {
        $patient = Patient::findorfail($id);
        return view('patient.create',['patient'=>$patient]);
    }
    public function update(Request $request)
    {
        Validator::make($request->all(),[
            'first_name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'last_name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'email'=>'required|unique:patients|email|',
            'phone'=>'required|min:10',
            'age'=>'required',
            'weight'=>'required',
            'address'=>'required',
            'disease'=>'required',
            'gender'=>'required',
        ]);
        $patient = Patient::findorfail($request->id);
        $patient->first_name = $request->first_name;
        $patient->last_name = $request->last_name;
        $patient->email = $request->email;
        $patient->phone = $request->phone;
        $patient->age = $request->age;
        $patient->weight = $request->weight;
        $patient->address = $request->address;
        $patient->disease = $request->disease;
        $patient->gender = $request->gender;
        $patient->save();

        return response()->json(['success'=>true,'message'=>'Patient Updated Successfully']);
    }
    public function viewAppointment(Request $request)
    {
        $appointment = Appointment::select('*','doctors.first_name as doctor')
            ->leftjoin('doctors','doctors.id','=','appointments.doctor_id')
            ->where('appointments.patient_id','=',$request->id);

        if(request()->ajax())
        {
            return datatables()->of($appointment->orderBy('appointments.id','asc')->get())
                ->addColumn('action', function($data){
                    $button = '<a href="#"> <button type="button" name="edit"   class="edit mr-1 btn btn-primary btn-sm text-right">Action</button></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
