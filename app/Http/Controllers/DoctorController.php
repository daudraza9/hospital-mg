<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Models\Appointment;
use App\Models\DoctorPatient;
use App\Models\Patient;
use Illuminate\Validation\Rule;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Comment\Doc;
use PHPUnit\Framework\MockObject\Stub;
use Yajra\DataTables\Facades\DataTables;
use function GuzzleHttp\Promise\all;
use App\Rules\UpperCaseRule;

class DoctorController extends Controller
{
    //
    public function index()
    {
        return view('doctors.index');
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(StoreDoctorRequest $request)
    {
        $validated = $request->validated();

        $validated = Doctor::create(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'phone' => $request->phone, 'title' => $request->title, 'address' => $request->address, 'experience' => $request->experience]);
        return response()->json(['success' => true, 'message' => 'Doctor Added Successfully!']);
    }

    public function datatable(Request $request)
    {

        $params = ['keyword' => $request->keyword,];
        $doctor = Doctor::select('*');

        if (isset($params['keyword']) && $params['keyword'] != '') {
            $keyword = $params['keyword'];
            $doctor->where(function ($doctor) use ($keyword) {
                $doctor->orWhere('first_name', 'like', '%' . $keyword . '%');
                $doctor->orWhere('last_name', 'like', '%' . $keyword . '%');
            });
        }

        if (request()->ajax()) {
            return datatables()->of($doctor->orderBy('doctors.id', 'asc')->get())->addColumn('name', function ($data) {
                    return $data->first_name . ' ' . $data->last_name;
                })->addColumn('action', function ($data) {

                    $button = '<div style="width: 422px;"><a href="' . route('doctor.edit', $data->id) . '" class="d-inline-block"> <button type="button" name="edit"   class="edit mr-1 btn btn-primary btn-sm text-right">Edit</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" onclick="delete_doctor(' . $data->id . ')"  class="d-inline-block"><button type="button" name="delete"  class="delete  mr-1  btn btn-danger btn-sm text-right ">Delete</button></a>';
                    $button .= '<a href="#" onclick="appointment(' . $data->id . ')"  class="d-inline-block"><button type="button" name="delete"  class="delete  mr-1  btn btn-danger btn-sm text-right ">Appointment</button></a>';
                    $button .= '<a href="' . route('doctor.patient.index', ['id' => $data->id]) . '" class="d-inline-block"><button type="button" name="delete" class="delete btn btn-dark btn-sm text-right ">Add Patient</button></a></div>';
                    return $button;

                })->rawColumns(['action'])->make(true);
        }

    }

    public function edit(Request $request, $id)
    {
        $doctor = Doctor::findorfail($id);
        return view('doctors.create', ['doctor' => $doctor]);
    }

    public function update(Request $request)
    {

        Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
            'email' => 'required|email|unique:doctors,email,' . $request->id,
            'phone' => 'required|min:10|unique:doctors,phone,' . $request->id,
            'title' => 'required',
            'address' => 'required',
            'experience' => 'required'
        ])->validate();

        $doctor = Doctor::findorfail($request->id);
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->last_name;
        $doctor->email = $request->email;
        $doctor->phone = $request->phone;
        $doctor->title = $request->title;
        $doctor->address = $request->address;
        $doctor->experience = $request->experience;
        $doctor->save();

        return response()->json(['success' => true, 'message' => 'Doctor Updated Successfully!']);

    }

    public function delete(Request $request)
    {

        $doctor = Doctor::find($request->id);
        $doctor->delete();
        return response()->json(['success' => true, 'message' => "Doctor Deleted!"]);
    }

    public function indexDoctorPatient(Request $request)
    {
        $doctor = Doctor::find($request->id);
        return view('doctors.patient.index', compact('doctor'));
    }

    public function addPatient(Request $request)
    {
        $doctor = Doctor::find($request->id);
        return view('doctors.patient.add', compact('doctor'));
    }

    public function patientdatatable(Request $request)
    {
        $patient = Patient::join('doctor_patient', 'doctor_patient.patient_id', '=', 'patients.id')->where('doctor_patient.doctor_id', '=', $request->id)->select('patients.*');

        return Datatables::of($patient->orderBy('doctor_patient.created_at', 'desc'))->addColumn('action', function ($data) {
                $button = '<a href="#"> <button type="button" name="edit" onclick="deletePatient(' . $data->id . ');"   class="edit mr-1 btn btn-primary btn-sm text-right">Delete</button></a>';
                return $button;
            })->rawColumns(['action'])->make(true);

    }

    public function storePatient(Request $request)
    {
        Validator::make($request->all(), ['patient' => 'required|min:1',])->validate();

        foreach ($request->patient as $key) {
            DoctorPatient::create(['patient_id' => $key, 'doctor_id' => $request->doctor_id]);
        }
        return response()->json(['success' => true, 'message' => 'Patient Added Successfully!']);
    }

    public function select(Request $request)
    {
        $doctor = Doctor::findOrFail($request->doctor_id);

        $patient = Patient::leftJoin('doctor_patient', function ($join) use ($doctor) {
            $join->on('doctor_patient.patient_id', '=', 'patients.id');
            $join->where('doctor_patient.doctor_id', '=', $doctor->id);
        })->select('patients.id', 'patients.first_name', 'patients.last_name', 'patients.email')->whereNull('doctor_patient.doctor_id');

        // $patient = Patient::select('*');
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

    public function deletePatient(Request $request)
    {
        $patient = DoctorPatient::where('doctor_patient.doctor_id', '=', $request->doctor_id)
            ->where('doctor_patient.patient_id', '=', $request->id)->delete();
        if ($patient) {
            return response()->json(['success' => true, 'message', 'Patient Deleted']);
        } else {
            return response()->json(['success' => false, 'message', 'Patient not found']);
        }
    }

    public function viewAppointment(Request $request)
    {
        $appointment = Appointment::select('*', 'patients.first_name as patient')->leftjoin('patients', 'patients.id', '=', 'appointments.patient_id')->where('appointments.doctor_id', '=', $request->id);

        if (request()->ajax()) {
            return datatables()->of($appointment->orderBy('appointments.id', 'asc')->get())->addColumn('action', function ($data) {

                })->rawColumns(['action'])->make(true);
        }
    }

}
