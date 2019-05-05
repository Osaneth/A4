<?php

namespace App\Http\Controllers;

use DB;
use App\Course;
use App\CompletedCourse;
use App\RegisteredCourse;
use App\Program;
use App\FailedCourse;
use Illuminate\Http\Request;



class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //gets all courses in the database
    public function allCourse(Request $request){
        try{

        
       
        $user = Course::create($request -> all());

        return response()->json($user);
    }catch (Exception $e){
        $message = [
            'status' => 'failed'
        ];
        return json_encode($message);
    }
    
    }
    

    //Gets all courses from student account
    public function getallCourse(Request $request, $id){
       
       // return response()->json(TotalCourse::all());
       // $studentid = $id;
       try{

        $code = DB::table('users')->select('ProgramCode as pcode')->where([['student_Id', $id ]])->first();
        $student = Program::where('program_code', '=' ,$code->pcode)->get(); // finds student id and gets data
        return response()->json($student);
       }catch (Exception $e){
        $message = [
            'status' => 'failed'
        ];
        return json_encode($message);
    }
    
        
    }

    //Gets registred courses from  student account
    public function getRegisteredCourse(Request $request, $id){
       
        // return response()->json(TotalCourse::all());
        // $studentid = $id;
        try{
            $student = RegisteredCourse::where('student_id', '=' ,$id)->get();// finds student id and gets data
             return response()->json($student);
        }catch (Exception $e){
            $message = [
                'status' => 'failed'
            ];
            return json_encode($message);
        }
         
     }
 

    public function getCompletedCourse(Request $request, $id){
       
       // $studentid = $id;
        // $student = CompletedCourse::find($id);
        // return response()->json($student);
        try{
            $student = CompletedCourse::where('student_id', '=' ,$id)->get(); // finds student id and gets data
            return response()->json($student);
        }catch (Exception $e){
        $message = [
            'status' => 'failed'
        ];
        return json_encode($message);
    }
       

    }

    public function getFailedCourse(Request $request, $id){
       
        // $studentid = $id;
         // $student = CompletedCourse::find($id);
         // return response()->json($student);
        try{
            $student = FailedCourse::where('student_id', '=' ,$id)->get(); // finds student id and gets data
         return response()->json($student);
 
        }catch (Exception $e){
            $message = [
                'status' => 'failed'
            ];
            return json_encode($message);
        }
         
     }

    //Adds all courses to do by student to student account
    public function getPrereqCourse(Request $request, $id){
       
       // return response()->json(TotalCourse::all());
       // $studentid = $id;
       //$offere = '1A';
        // $student = Prerequisites::where([['id', '=' ,$id],['offered' ,'=' ,$offere]])->get();// finds student id and adds data
        // return response()->json($student);

        // $student = Prerequisites::where([['id', '=' ,$id],['offered' ,'=' ,$offere]])->get();// finds student id and adds data
        // return response()->json($student);
        try{
        //     return DB::table('courses')
        // ->leftJoin('prerequisites','prerequisites.subgroup1', '=', 'courses.subgroup1')
        // //->leftJoin('prerequisites','prerequisites.subgroup1', '=', 'courses.subgroup1')
        // ->leftJoin('programs' ,'programs.course_code','=', 'courses.course_code')
        // ->select('courses.course_code', 'prerequisites.type' ,'prerequisites.coursecode')
        // ->where('programs.program_code', '=',$id)
        // ->whereColumn('courses.subgroup1','=', 'prerequisites.subgroup1')
        // //->find('courses.subgroup1', '=','prerequisites.subgroup1')
        // ->groupBy('courses.course_code')
        // ->get();

        $program =  DB::table('users')->select('ProgramCode as pcode')->where([['student_Id', $id ]])->first();
           

        return DB::table('prerequisites')
        ->leftJoin('programs', 'programs.subgroup', '=', 'prerequisites.subgroup1')
        ->join('users', 'users.ProgramCode', '=', 'programs.program_code')
        ->select( 'programs.course_code','prerequisites.type', 'prerequisites.coursecode')
        ->where([['programs.program_code','=', $program->pcode]])
       //->groupBy('programs.course_code')
        ->get();

        }catch (Exception $e){
        $message = [
            'status' => 'failed'
        ];
        return json_encode($message);
    }
        
    }

    //Adds completed courses to user account
    public function AddCompletedCourse(Request $request){
       try{
        $user = CompletedCourse::create($request -> all());

        return response()->json($user);
       }catch (Exception $e){
        $message = [
            'status' => 'failed'
        ];
        return json_encode($message);
    }
        
    }

    //Adds registred courses to user account
    public function AddRegisteredCourse(Request $request){
       try{
        $user = RegisteredCourse::create($request -> all());

        return response()->json($user);
       }catch (Exception $e){
        $message = [
            'status' => 'failed'
        ];
        return json_encode($message);
    }
        
    }

    
}
 
