<?php

namespace App\Http\Controllers;

use App\User;
use App\Student;
use Illuminate\Http\Request;
use DB;


class StudentController extends Controller
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

    // public function addStudent(Request $request){
    //     $std = Student::addStudentdata();
    // }

     public static function addStudent(Request $request){
        try{
                $request['api_token'] = str_random(60);
            $request['Password'] = app('hash')->make($request['Password']) ;
            
            $user = new User();
            $user->addstudent($request);
        }catch(Exception $e){
            return response()->json($e);   
        }
         
       
        
       //  $user = Student::addstudent($request);
        // $user = User::create($request -> all());

        // return response()->json($user);
    }


    public static function applyrecheck(Request $request){
        
       try{
        $user = new User();
        $user->addrecheck($request);
        //return response()->json($user);
       }catch(Exception $e)
       {
        return response()->json($e);
       }
       
    
   }


   
   public static function getgrades(Request $request, $Student_Id){
    try{
        $std = new User();
       $item =  $std->gradedetails($request, $Student_Id);
        return response()->json($item);
    }catch(Exception $e){
        return response()->json($e); 
    }
}

public static function viewgrades(Request $request, $Student_Id){
    try{
        $std = new User();
       $item =  $std->grades($request, $Student_Id);
        return response()->json($item);
    }catch(Exception $e){
        return response()->json($e); 
    }
}
 
 
    
     
    public  function getProfile(Request $request, $Student_Id){
       try{
            // $studentid = $id;
            $student = User::where('Student_Id', '=' ,$Student_Id)->get();// finds student id and gets data
            return response()->json($student);
            //  $student = User::find($Student_Id);
            //  return response()->json($student);
       }catch (Exception $e){
        return response()->json($e->getMessage());
        //return response()->json(['error' => $e->getMessage()]);
    }
    
 
     }



//Adds all courses to do by student to student account
public function getprogram(Request $request){
       
    
     try{
         $item =  DB::table('users')
     ->leftJoin('programs','programs.programyear', '=', 'users.YearEnrolled')
    
     ->select('programs.programname', 'programs.program_code')
    // ->where('programs.program_code', '=',$id)
     //->whereColumn('courses.subgroup1','=', 'prerequisites.subgroup1')
     //->find('courses.subgroup1', '=','prerequisites.subgroup1')
     ->groupBy('programs.programname', 'programs.program_code')
     ->get();
     return response()->json($item);
     }catch (Exception $e){
     $message = [
         'status' => 'failed'
     ];
     return json_encode($message);
 }
     
 }

 public function changeprogram(Request $request, $Id)
 {
     try{

     
     $user = new User();
     $item = $user->addchangeprogram($request, $Id);
     return response()->json($item);
     } catch(Exception $e){
       // return response()->json(['error' => $e->getMessage()], 500);
       // throw new HttpException(500, $e->getMessage());
       return response()->json($e);
    }
 }


    
   
}

    

