<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\Course;
use App\Program;
use App\Prerequisites;
use App\CompletedCourse;
use App\ FailedCourse ;


class FileController  extends Controller
{
    //

    


    public function getresultdata(Request $request)
    {   
        //get file
       // $upload=$request->file('uploads');
      // $filePath=$upload->getRealPath();

       
        //open and read
       // $filename = Storage::get('Courses.csv');
       try{

       
       $filename = storage_path('/app/Result.csv');
        $file=fopen($filename, 'r'); 
        $header= fgetcsv($file);
        // dd($header);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z_]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through othe columns
        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
            {
                continue;
            }
            //trim data
            // foreach ($columns as $key => &$value) {
            //     $value=preg_replace('/\D/','',$value);
            // }
           $data= array_combine($escapedHeader, $columns);
           // setting type
        //    foreach ($data as $key => &$value) {
        //     $value=($key=="zip" || $key=="month")?(integer)$value: (float)$value;
        //    }
           // Table update
           $studentid=$data['student_id'];
           $courseid=$data['course_id'];
        //    $prerequisitone=$data['prerequisitone'];
        //    $prerequisittwo=$data['prerequisittwo'];
        //    $prerequisitthree=$data['prerequisitthree'];
           $grade=$data['grade'];
           $semester=$data['semester'];
           $year=$data['year'];
           echo($grade);
           
           if($grade == 'A+'|| $grade == 'A'  || $grade =='B+' || $grade =='B' || $grade =='C+' || $grade =='C' )
           {
            $course= CompletedCourse::firstOrNew(['student_id'=>$studentid,'course_id' =>$courseid,'year'=>$year]);
            
               $course->semester=$semester;
               $course->grade=$grade;
               $course->save();
              // $course->semester=$semester;
              
           }
           else{
               echo("Worked");
               FileController::getfailedgrades($request);
               

           }
                     
        } 
    }catch(Exception $e) {
        echo 'Error Occured ' ;
      }
        
        
    }

    public function getfailedgrades(Request $request)
    {   
        //get file
       // $upload=$request->file('uploads');
      // $filePath=$upload->getRealPath();

       
        //open and read
       // $filename = Storage::get('Courses.csv');
        $filename = storage_path('/app/Result.csv');
        $file=fopen($filename, 'r'); 
        $header= fgetcsv($file);
        // dd($header);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z_]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through othe columns
        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
            {
                continue;
            }
            //trim data
            // foreach ($columns as $key => &$value) {
            //     $value=preg_replace('/\D/','',$value);
            // }
           $data= array_combine($escapedHeader, $columns);
           // setting type
        //    foreach ($data as $key => &$value) {
        //     $value=($key=="zip" || $key=="month")?(integer)$value: (float)$value;
        //    }
        $studentid=$data['student_id'];
        $courseid=$data['course_id'];
     //    $prerequisitone=$data['prerequisitone'];
     //    $prerequisittwo=$data['prerequisittwo'];
     //    $prerequisitthree=$data['prerequisitthree'];
        $grade=$data['grade'];
        $semester=$data['semester'];
        $year=$data['year'];
        echo($grade);
        
        if($grade == 'D'|| $grade == 'E'  || $grade =='R'  )
        {

          
           $course= FailedCourse::firstOrNew(['student_id'=>$studentid,'course_id' =>$courseid,'year'=>$year]);
           //   $course->coursetitle=$coursetitle;
           //    $course->prerequisitone=$prerequisitone;
           //    $course->prerequisittwo=$prerequisittwo;
           //    $course->prerequisitthree=$prerequisitthree;
              $course->semester=$semester;
              $course->grade=$grade;
              $course->save();
             // $course->semester=$semester;

        }
        }
        
        
    }


    public function getcoursedata(Request $request)
    {   
        //get file
       // $upload=$request->file('uploads');
      // $filePath=$upload->getRealPath();

       
        //open and read
       // $filename = Storage::get('Courses.csv');
       try{
        $filename = storage_path('/app/Courses.csv');
        $file=fopen($filename, 'r'); 
        $header= fgetcsv($file);
        // dd($header);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z_]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through othe columns
        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
            {
                continue;
            }
            //trim data
            // foreach ($columns as $key => &$value) {
            //     $value=preg_replace('/\D/','',$value);
            // }
           $data= array_combine($escapedHeader, $columns);
           // setting type
        //    foreach ($data as $key => &$value) {
        //     $value=($key=="zip" || $key=="month")?(integer)$value: (float)$value;
        //    }
           // Table update
           $coursecode=$data['course_code'];
           $coursetitle=$data['course_title'];
        
           $semester=$data['semester'];
           $year=$data['year'];
           $mode=$data['mode'];
           $campus=$data['campus'];
           $description=$data['description'];
           $fees=$data['fees'];

           $course= Course::firstOrNew(['course_code'=>$coursecode,'course_title' =>$coursetitle,'year'=>$year]);
      
           $course->semester=$semester;
          // $course->semester=$semester;
           $course->year=$year;
           $course->mode=$mode;
           $course->campus=$campus;
           $course->description=$description;
           $course->fees=$fees;
           $course->save();
        }
        
       }catch (Exception $e){
        $message = [
            'status' => 'failed'
        ];
        return json_encode($message);
    }
       
        
    }


    public function upload(Request $request)
    {
        try{
            $files = $request->file('uploads');
       
     //  return [ 'uploads' => 'required|mimes:csv,txt' ];
      //  echo($request->file->mimeType() );

    
       if(!empty($files)) {

        
           foreach($files as $file) {
               
               $extension = $file->getClientOriginalExtension();
               $filename = $file->getClientOriginalName();
               echo( $filename);
               if($extension == "csv"){
                Storage::put($file->getClientOriginalName(),file_get_contents($file));
                if($filename == "Courses.csv"){
                    FileController::getcoursedata($request); 
                } 
                if ($filename == "Program.csv")
                {
                    FileController::getprogramdata($request);
                }

                if ($filename == "Prerequisites.csv")
                {
                    FileController::getpreredata($request);
                }

                if ($filename == "Result.csv")
                {
                    FileController::getresultdata($request);
                }

                return response()->json(array('Successful' ));
               }
               return response()->json(array('Invalid File Type'));
        }
        
        
		
	}
	return response()->json(array('Failed'));
	
    }catch (Exception $e){
        $message = [
            'status' => 'failed'
        ];
        return json_encode($message);
    }
       
    }


    public function getprogramdata(Request $request)
    {   
        //get file
       // $upload=$request->file('uploads');
      // $filePath=$upload->getRealPath();

       
        //open and read
       // $filename = Storage::get('Courses.csv');
       try{
        $filename = storage_path('/app/Program.csv');
        $file=fopen($filename, 'r'); 
        $header= fgetcsv($file);
        // dd($header);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z_]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through othe columns
        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
            {
                continue;
            }
            //trim data
            // foreach ($columns as $key => &$value) {
            //     $value=preg_replace('/\D/','',$value);
            // }
           $data= array_combine($escapedHeader, $columns);
           // setting type
        //    foreach ($data as $key => &$value) {
        //     $value=($key=="zip" || $key=="month")?(integer)$value: (float)$value;
        //    }
           // Table update
           $programcode=$data['program_code'];
           $coursecode=$data['course_code'];
           $programname=$data['program_name'];
           $programyear=$data['programyear'];
           $programgroup=$data['subgroup'];
       
           $course= Program::firstOrNew(['program_code'=>$programcode,'course_code' =>$coursecode, 'subgroup' => $programgroup]);
            
           $course->programname=$programname;
           $course->programyear=$programyear;
           $course->save();
        }
        
        
       }catch (Exception $e){
        $message = [
            'status' => 'failed'
        ];
        return json_encode($message);
    }
       
    }



    
    public function getpreredata(Request $request)
    {   
        
       $filename = storage_path('/app/Prerequisites.csv');
        $file=fopen($filename, 'r'); 
        $header= fgetcsv($file);
        // dd($header);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z0-9]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through othe columns
        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
            {
                continue;
            }
            //trim data
            // foreach ($columns as $key => &$value) {
            //     $value=preg_replace('/\D/','',$value);
            // }
           $data= array_combine($escapedHeader, $columns);
           // setting type
        //    foreach ($data as $key => &$value) {
        //     $value=($key=="zip" || $key=="month")?(integer)$value: (float)$value;
        //    }
           // Table update
           $year=$data['year'];
           $subgroup1=$data['subgroup1'];
           $coursecode=$data['coursecode'];
           $type=$data['type'];
           $subgroup2=$data['subgroup2'];
      

           $course= Prerequisites::firstOrNew(['year'=>$year,'coursecode' =>$coursecode, 'subgroup1'=>$subgroup1, 'type'=>$type, 'subgroup2'=>$subgroup2]);
    

           $course->save();
        }
        
        
    }


    
}