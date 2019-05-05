<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Student;
use Illuminate\Http\Request;
use App\Mail\GradeFeedback;




use Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;



class AdminController extends Controller
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


    

    public static function getrecheck(Request $request){
        try{
            $std = new Admin();
           $item =  $std->recheckdetails($request);
            return response()->json($item);
        }catch(Exception $e){
            return response()->json($e); 
        }
    }

    public static function addgrades(Request $request){
        try{
        //     $std = new Admin();
        //    $item =  $std->upload($request);
        $item = Admin::upload($request);
        
            return response()->json($item);
        }catch(Exception $e){
            return response()->json($e); 
        }
    }

    public static function addresults(Request $request){
        try{
        //     $std = new Admin();
        //    $item =  $std->upload($request);
        $item = Admin::upload($request);
        
            return response()->json($item);
        }catch(Exception $e){
            return response()->json($e); 
        }
    }

    public static function getreport(Request $request){
        try{
             $std = new Admin();
            $item =  $std->reports($request);

            $item2 = $std->yearreport($request);

        
            return response()->json($item);
        }catch(Exception $e){
            return response()->json($e); 
        }
    }

    public static function getyearreport(Request $request){
        try{
             $std = new Admin();
            //$item =  $std->reports($request);

            $item2 = $std->yearreport($request);

        
            return response()->json($item2);
        }catch(Exception $e){
            return response()->json($e); 
        }
    }

    public static function get2018report(Request $request){
        try{
             $std = new Admin();
            //$item =  $std->reports($request);

            $item2 = $std->year2018($request);

        
            return response()->json($item2);
        }catch(Exception $e){
            return response()->json($e); 
        }
    }
     
     
  



    
   
}

    

