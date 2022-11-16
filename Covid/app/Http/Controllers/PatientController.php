<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class PatientController extends Controller
{
    // method index, untuk menampilakan seluruh data
    function index(){
       //mengambil model patient unutk select data
       $patients = Patient::all();
;       //kondisi jika data ada tampilakan data jika tidan tanpilkan not found 404
       if(count($patients) == true){
           $data = [
               'message' => 'Get All Resource',
               'data' => $patients
            ];
            // mengembalikan data json dan status codenya
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Data is empty',
                'status' => 200
            ];
            // mengambalikan data json dan status codenya
            return response()->json($data, 200);
        } 
    }
    // method store, untuk menambahkan data
    function store(Request $request){
        //membaut validasi
        $validateData = $request->validate([
            'name' => 'required',
            'phone' => 'numeric|required',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required',
            'out_date_at' => 'nullable',
        ]);
    // menggunakan patient untuk tambah data
    $patient = Patient::create($validateData);
    $data = [
            'message' => 'Resource is added successfully',
            'data' => $patient,
        ];
        // mengambalikan data json dan status codenya
        return response()->json($data, 201);
        
    }
    // method show untuk menampilkan detail data
    function show($id){
        //mencari data patient berdasrakan id
        $patient = Patient::find($id);
        //membuat kondisi data ada atau tidak
        if($patient){
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $patient,
            ];
            // mengembalikan data json dan status code nya
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Resource not found',
                'status' => 404,
            ];
            //mengmbalikan data json dan status code nya
            return response()->json($data, 404);
        }
    }
    
    //membuat method update unutk mengubah data patient
    function update(Request $request, $id){
        //mencari data patient berdasarkan id
        $patient = Patient::find($id);
        //kondisi jika data ada tampilakan data jika tidan tanpilkan not found 404
        if($patient){
            //mendapatkan data request
            $input = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at,
            ];
            //mengupdate data
            $patient->update($input);
            $data = [
                'message' => 'Resource is update successfully',
                'data' => $patient,
            ];
            //mengmbalikan data json dan status code nya
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => "Resource not found",
                'status' => 404
            ];
            //mengmbalikan data json dan status code nya
            return response()->json($data, 404);
        }
    }

    //membuat method destroy untuk menghapus data
    function destroy($id){
        //mencari data patient berdasarakan id
        $patient = Patient::find($id);
        //membuat kondisi jika data ada hapus datanya dan jika tidak ada maka tampilkan not found 404
        //hapus data patient
        if($patient){
            $patient->delete();
            $data = [
                'message' => 'Resource is delete successfully',
                'Status' => 200,
            ];
            //mengembalikan data json dan status codenya
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Resource not found',
                'Status' => 404,
            ];
            //mengembalikan data json dan status codenya
            return response()->json($data, 404);
        }
    }

    //method search untuk menampilkan data nama yang di cari
    function search($name){
        //mencari data berdasarkan nama
        $patient = Patient::where('name','like', "%".$name."%")->get();
        //membuat kondisi jika ada datanya maka tampilkan jika tidak ada tampilkan not found 404
        if(count($patient) > 0){
            $data = [
                'message' => 'Get searched resource',
                'data' => $patient,
            ];
            //mengembalikan data json dan status codenya
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Resource not found',
                'Status' => 404,
            ];
            //mengembalikan data json dan status codenya
            return response()->json($data, 404);
        }
    }

    //method positive untuk menakap data patient yang positif
    function positive(){
        //mencari data berdasarkan status
        $patient = Patient::where('status','positive')->get();
        //membuat kondisi jika datanya ada maka tampilkan jika tidak ada tampilkan not found 404
        if(count($patient) > 0){
            $data = [
                'message' => 'Get positive resource',
                'total' => count($patient),
                'data' => $patient
            ];
            //mengembalikan data json dan status codenya
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Resource not found',
                'Status' => 404,
            ];
            //mengembalikan data json dan status codenya
            return response()->json($data, 404);
        }
    }

    // method recovered untuk menangkap data yang recovered/sembuh
    function recovered(){
        //mencari data berdasarkan status
        $patient = Patient::where('status','recovered')->get();
        //membuat kondisi jika datanya ada maka tampilkan jika tidak ada tampilkan not found 404
        if(count($patient) > 0){
            $data = [
                'message' => 'Get recovered resource',
                'total' => count($patient),
                'data' => $patient
            ];
            //mengembalikan data json dan status codenya
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Resource not found',
                'Status' => 404,
            ];
            //mengembalikan data json dan status codenya
            return response()->json($data, 404);
        }
    }

    //membuat method dead untuk menagkap data yang dead/meninggal
    function dead(){
        //mencari data berdasarkan status
        $patient = Patient::where('status','dead')->get();
        //membuat kondisi jika datanya ada maka tampilkan jika tidak ada tampilkan not found 404
        if(count($patient) > 0){
            $data = [
                'message' => 'Get Dead resource',
                // 'total' => count($patient),
                'data' => $patient
            ];
            //mengembalikan data json dan status codenya
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Resource not found',
                'Status' => 404,
            ];
            //mengembalikan data json dan status codenya
            return response()->json($data, 404);
        }

    }
}