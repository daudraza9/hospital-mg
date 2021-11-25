<?php

namespace App\Http\Controllers;

use App\Models\Department;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use PDF;

class PdfGenerator extends Controller
{
    //
    public function index(){
        return view('generate-pdf.index');
    }
    public function generate(Request $request){

        $user = User::latest()->get();
        $pdf = PDF::loadView('generate-pdf.pdf',compact('user'));
        return $pdf->stream('data.pdf');

    }
}
