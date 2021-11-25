<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Mail\AppointmentMail;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PDF;

class AppointmentController extends Controller
{
    //
    public function index()
    {
        return view('appointment.index');
    }
    public function create()
    {
        return view('appointment.create');
    }
    public function selectPatient(Request $request)
    {
        $patient = Patient::select('patients.id','patients.first_name','patients.last_name','patients.email');
        if ($request->has('search')) {
            $keyword = $request->search;
            $patient->where(function ($patient) use ($keyword) {
                $patient->orWhere('patients.id', 'like', '%' . $keyword . '%');
                $patient->orWhere('patients.first_name', 'like', '%' . $keyword . '%');
                $patient->orWhere('patients.last_name', 'like', '%' . $keyword . '%');
                $patient->orWhere('patients.email', 'like', '%' . $keyword . '%');
            });
        }
        return response()->json($patient->paginate(5, ['*'], 'page', $request->page));
    }

    public function selectDoctor(Request $request)
    {
        $doctor = Doctor::select('doctors.id','doctors.first_name','doctors.last_name','doctors.email');
        if ($request->has('search')) {
            $keyword = $request->search;
            $doctor->where(function ($doctor) use ($keyword) {
                $doctor->orWhere('doctors.id', 'like', '%' . $keyword . '%');
                $doctor->orWhere('doctors.first_name', 'like', '%' . $keyword . '%');
                $doctor->orWhere('doctors.last_name', 'like', '%' . $keyword . '%');
                $doctor->orWhere('doctors.email', 'like', '%' . $keyword . '%');
            });
        }
        return response()->json($doctor->paginate(5, ['*'], 'page', $request->page));
    }
    public function add(Request $request)
    {
        Validator::make($request->all(),[
           'patient_id'=>'nullable|exists:patients,id',
           'doctor_id'=>'nullable|exists:doctors,id',
           'fee'=>'required',
            'date'=>'required|date',
            'time'=>'required'
        ])->validate();

        $appointment = Appointment::create([
           'patient_id'=>$request->patient,
           'doctor_id'=>$request->doctor,
           'fee'=>$request->fee,
           'date'=>$request->date,
           'time'=>$request->time
        ]);

        $patient = Patient::where('patients.id','=',$request->patient)
                   ->first();
        $email = $patient->email;

        Mail::to([['email'=>$email,'name'=>$patient->first_name." ".$patient->last_name]])->send(new AppointmentMail($patient->first_name,$patient->last_name,$appointment));

        return response(['success'=>true,'message'=>'Appointment Added Successfully']);
    }
    function datatable(Request $request)
    {
        $params =[
          'keyword'=>$request->keyword,
        ];
        $appointment = Appointment::select('appointments.*','patients.first_name as patient','doctors.first_name as doctor')
            ->leftjoin('patients','patients.id','=','appointments.patient_id')
            ->leftjoin('doctors','doctors.id','=','appointments.doctor_id');

        if(isset($params['keyword']) && $params['keyword'] != '')
        {
            $keyword = $params['keyword'];
            $appointment->where(function ($appointment) use ($keyword) {
                $appointment->orWhere('date', 'like', '%' . $keyword . '%');
            });
        }
        if(request()->ajax())
        {
            return datatables()->of($appointment->orderBy('appointments.id','asc')->get())
                ->addColumn('action', function($data){
                    $button = '<a href="'.route('appointment.edit',['id'=>$data->id]).'"> <button type="button" name="edit"   class="edit mr-1 btn btn-primary btn-sm text-right">Edit</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" onclick="deleteAppointment('.$data->id.')"> <button type="button" name="delete"  class="delete mr-1 btn btn-danger btn-sm text-right">Delete</button></a>';
                    $button .= '<a href="'.route('appointment.pdf',['id'=>$data->id]).'"> <button type="button" name="delete"  class="delete mr-1 btn btn-danger btn-sm text-right">PDF</button></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function delete(Request $request)
    {
        $appointment = Appointment::findorfail($request->id);
        $appointment->delete();

        return response()->json(['success'=>true,'message'=>'Appointment Removed']);
    }
    public function edit(Request $request,$id)
    {
        $appointment = Appointment::findorfail($id);
        return view('appointment.create',['appointment'=>$appointment]);
    }
    public function update(Request $request)
    {
        Validator::make($request->all(),[
            'patient_id'=>'nullable|exists:patients,id',
            'doctor_id'=>'nullable|exists:doctors,id',
            'fee'=>'required',
            'date'=>'required|date',
            'time'=>'required'
        ])->validate();

        $appointment = Appointment::findorfail($request->id);
        $appointment->patient_id = $request->patient;
        $appointment->doctor_id = $request->doctor;
        $appointment->fee = $request->fee;
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->save();

        return response()->json(['success'=>true,'message'=>'Appointment Changed successfully']);
    }

    public function pdf(Request $request,$id){
        $appointment = Appointment::findorfail($id);
        $pdf = PDF::loadView('generate-pdf.appointment',compact('appointment'));
        return $pdf->stream('appointment.pdf');
    }

//    public function GeneratePdf(Request $request){
//
//        $appointment = Appointment::findorfail($request->id);
//        $pdf = PDF::loadView('generate-pdf.appointment',compact('appointment'));
//        return response()->download('appointment.pdf');
//    }
}
