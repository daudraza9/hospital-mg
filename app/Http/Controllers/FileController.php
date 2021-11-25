<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    //
    public function index()
    {
        return view('file.file_upload');
    }

    public function view()
    {
        return view('file.view-file');
    }

    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'file' => 'required',
            'file.*' => 'required|mimes:.jpeg,png,jpg,gif,svg,pdf,docx'
        ])->validate();

        if ($request->hasFile('file')) {
            foreach ($request->file as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $realName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = 'FILE-' . time() . rand(1, 100) . '.' . $extension;
                Storage::putFileAs('/file/', $file, $fileName);

                $file = File::create([
                    'name' => $file->getClientOriginalName(),
                    'file' => $fileName
                ]);

            }
        }

        return response()->json(['success' => true, 'message' => 'File has been uploaded']);
    }

    public function storeMedia(Request $request)
    {

        Validator::make($request->all(), [
            'file' => 'required',
            'file.*' => 'required|mimes:.jpeg,png,jpg,gif,svg,pdf,docx'
        ])->validate();

        if ($request->hasFile('file')) {
            $file = $request->file;
            $extension = $file->getClientOriginalExtension();
            $realName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = 'FILE-' . time() . rand(1, 100) . '.' . $extension;
            Storage::putFileAs('/file/', $file, $fileName);
            $fileStorage = Storage::putFileAs('/file', $file, $fileName);
            $file = File::create([
                'name' => $file->getClientOriginalName(),
                'file' => $fileName
            ]);
            $file->addMediaFromRequest('file')->toMediaCollection('media');

        }

        return response()->json(['success' => true, 'message' => 'File has been uploaded']);
    }

    public function datatable(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(File::orderBy('files.id', 'asc')->get())
                ->addColumn('action', function ($data) {

                    $button = '<a href="#" onclick="deletefile(' . $data->id . ')" class="d-inline-block"> <button type="button" name="edit"   class="edit mr-1 btn btn-primary btn-sm text-right">Delete</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="' . Storage::url('/file/' . $data->file) . '" class="d-inline-block"><button type="button" name="delete" class="delete btn btn-dark btn-sm text-right ">View File</button></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function delete(Request $request)
    {
        $file = File::findorfail($request->id);
        $file->delete();

        return response()->json(['success' => true, 'message' => 'File deleted']);
    }

    public function display(Request $request)
    {
        $file = File::findorfail($request->id);
        return response()->json(['success' => true, 'message' => 'File deleted']);
    }

    public function mediaView(Request $request)
    {
        $file = File::latest()->get();
        return view('file.media-file-upload', compact('file'));
    }
}
