<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Comment\Doc;

class ApiController extends Controller
{
    //
    public function storeDoctor(StoreDoctorRequest $request)
    {
        $validated = $request->validated();

        $validated = Doctor::create(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'phone' => $request->phone, 'title' => $request->title, 'address' => $request->address, 'experience' => $request->experience]);
        return response()->json([
            "message" => "Doctor record created"
        ],201);
    }

    public function getDoctor(Request $request){
        $doctor = Doctor::all();
        return response()->json([$doctor,'message' => 'All doctors']);
    }

    public function searchDoctor(Request $request,$id){

        if($doctor = Doctor::findorfail($id)->exists()){
            $doctor = Doctor::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($doctor, 200);
        }else{
            return response()->json([
                "message" => "Doctor not found"
            ], 404);
        }

    }
    public function login(Request $request){

        $data =[
            'email'=>$request->email,
            'password'=>$request->password
        ];

        if(auth()->attempt($data)){
            $token =auth()->user()->createToken('LoginAuth')->accessToken;
            return response()->json(['data'=>auth()->user(),'token'=>$token]);
        }else{
            return response()->json(['error'=>'Unauthorized']);
        }

    }

    public function register(Request $request){

        Validator::make($request->all(),[
            'name' => 'required|regex:/^[a-zA-Z]+$/u|string|max:200',
            'email' => 'required|email|max:200|unique:users,email,',
            'password'=> 'nullable|min:8'
        ])->validate();


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $accessToken = $user->createToken('Personal Access Token');
        $token = $accessToken->token;
        $token->save();
        return response()->json(['User'=>$user,'Access_Token'=>$accessToken->accessToken]);

    }

    public function deleteDoctor(Request $request,$id){

        $doctor = Doctor::findorfail($id);
        $doctor->delete();
        return response()->json(['success'=>true,'message','Doctor is deleted']);

    }
}
