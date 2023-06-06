<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        if ($students->count() > 0) {
            return response()->json([
                'status'=> 200,
                'students'=> $students
            ], 200);
        } else {
            return response()->json([
                'status'=> 404,
                'message'=> "No Records Found"
            ], 404);
        }
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|string|max:191',
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if ($student) {
                return response()->json([
                    'status' => 201,
                    'message' => "Student added Successfully."
                ], 201);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Something Went Wrong!"
                ], 500);
            }
        }
    }

    public function storeAll(Request $request)
    {
        $data = $request->all();
    
      
        if (is_array($data)) {
            $validator = Validator::make($data, [
                '*.name' => 'required|string|max:191',
                '*.course' => 'required|string|max:191',
                '*.email' => 'required|string|max:191',
                '*.phone' => 'required|digits:10',
            ]);
        } else {
            $validator = Validator::make($data, [
                'name' => 'required|string|max:191',
                'course' => 'required|string|max:191',
                'email' => 'required|string|max:191',
                'phone' => 'required|digits:10',
            ]);
        }
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            if (is_array($data)) {
                $students = collect($data)->map(function ($item) {
                    return [
                        'name' => $item['name'],
                        'course' => $item['course'],
                        'email' => $item['email'],
                        'phone' => $item['phone'],
                    ];
                });
    
                $result = Student::insert($students->toArray());
    
                if ($result) {
                    return response()->json([
                        'status' => 201,
                        'message' => "Students added Successfully."
                    ], 201);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => "Something Went Wrong!"
                    ], 500);
                }
            
            }
        }
    }
    

    public function show($id){
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status'=> 200,
                'student'=> $student
            ], 200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => "No student found"
            ], 404);

        }

    }

    public function edit($id){
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status'=> 200,
                'student'=> $student
            ], 200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => "No student found"
            ], 404);

    }
}

public function update(Request $request, int $id){
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:191',
        'course' => 'required|string|max:191',
        'email' => 'required|string|max:191',
        'phone' => 'required|digits:10',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
        ], 422);
    } else {
        $student = Student::find($id);
        

        if ($student) {
            $student->update([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            return response()->json([
                'status' => 201,
                'message' => "Student updated Successfully."
            ], 201);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No such student found!"
            ], 500);
        }
    }


} 
public function destroy($id){
    $student=Student::find($id);
    if($student){

        $student->delete();
        return response()->json([
            'status' => 200,
            'message' => "Student deleted successfully."
        ], 200);

    }else{
        return response()->json([
            'status' => 404,
            'message' => "No such student found!"
        ], 404);
        
    }

}

public function destroyAll(){

    Student::truncate();

    return response()->json([
        "message"=>"All data deleted successfully."

    ]);

}
}