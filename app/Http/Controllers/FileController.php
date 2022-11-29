<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\FileCategory;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){

    }
    public function index()
    {
        return view('file.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $file_category = DB::table('file_category')->get();
        if (
            in_array("Staff", (array) app('auth')->user()->getRoleNames()[0]) ||
            in_array("Relawan", (array) app('auth')->user()->getRoleNames()[0])
        ){
            return view('file.upload',['file_category' => $file_category->except('3')]);
        }else{
            return view('file.upload',['file_category' => $file_category]);
        }
        
        // $categories = [
        //     1 => "notulensi",
        //     2 => "Memo",
        //     3 => "SOP",
        //     4 => "Dokumen KontraS"
        // ];
        // return view('file.upload', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => 'Ente mesti upload file',
            'max' => 'max 5mb bos',
            'mimetypes' => 'bolehnye pdf, docx, pptx, xlsx, jpg, sama png doang ngab',
            'category' => 'required'
        ];
        $this->validate($request, [
            'file' => 'required|max:5000|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation,image/jpeg,image/png',
            'category' => 'required|unique:file_category'
        ], $messages);
        $input = $request->input('category');
        $upload = $request->file('file');
        $path = $upload->store('public/storage');
        $file = File::create([
            'name' => $upload->getClientOriginalName(),
            'file_path' => $path,
            'category' => $input
        ]);
        return redirect('/file')->with('success' . 'File Telah diupload');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dl = File::find($id);
        return Storage::download($dl->file_path, $dl->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getNotulensi()
    {
        $files = DB::select('select * from files where category = 1');
        if ($files) {
            return view('file.Notulensi', ['files' => $files]);
        } else {
            return view('file.index');
        }
    }
    public function getMemo()
    {
        $files = DB::select('select * from files where category = 2');
        if ($files) {
            return view('file.memo', ['files' => $files]);
        } else {
            return view('file.index');
        }
    }
    public function getSOP()
    {
        $files = DB::select('select * from files where category = 3');
        if ($files) {
            return view('file.sop', ['files' => $files]);
        } else {
            return view('file.index');
        }
    }
    public function getDokument()
    {
        $files = DB::select('select * from files where category = 4');
        if ($files) {
            return view('file.doku', ['files' => $files]);
        } else {
            return view('file.index');
        }
    }

}
