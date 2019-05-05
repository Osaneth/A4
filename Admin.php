<?php

namespace App;
use DB;
use Carbon\Carbon;

use Storage;
use Illuminate\Http\Request;
use App\Mail\GradeFeedback;

//use App\Mail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Admin extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
        //  public $student_Id;
        //  public $Firstname;
        //  public $Lastname;
        //  public $Gender;
        //  public $YearEnrolled;
        //  public $Address;
        //  public $Password;
        //  public $ProgramID;
        //  public $Hold;
        //  public $api_token;
     
    
    protected $fillable = [
        'student_Id', 'Firstname',  'Lastname', 'Gender', 'YearEnrolled', 'Address', 'Password', 'ProgramCode','Hold','api_token','Email', 'role',
        'Course_Title', 'Course_Code','Coordinator','Receipt','Date','Bank_Name','Bank_Account'
    ];

    public function getstudent_IdAttribute($request)
    {
        return $request->student_Id;
    }

    public function getCourse_TitleAttribute($request)
    {
        return $request->Course_Title;
    }

    
    public function getCourseCodeAttribute($request)
    {
        return $request->Course_Code;
    }

    
    public function getCoordinatorAttribute($request)
    {
        return $request->Coordinator;
    }

    public function getReceiptAttribute($request)
    {
        return $request->Receipt;
    }

    public function getDateAttribute($request)
    {
        return $request->Date;
    }

    public function getBankNameAttribute($request)
    {
        return $request->Bank_Name;
    }
    public function getBankAccountAttribute($request)
    {
        return $request->Bank_Account;
    }
    

    
//     public static function addstudent($request) {
        
           
//         $std  = new User();
      
//         $std->setFirstnameAttribute($request);
//         $std->setLastnameAttribute($request);
//         $std->setGenderAttribute($request);
//         $std->setYearEnrolledAttribute($request);
//         $std->setAddressAttribute($request);
//         $std->setPasswordAttribute($request);
//         $std->setProgramCodeAttribute($request);
//         $std->setHoldAttribute($request);
//         $std->settokenAttribute($request);
//         $std->setEmailAttribute($request);
//         $std->setRoleAttribute($request);

//         $std->save();  
//  }


 public static function recheckdetails($request){
     try{
        $std  = new Admin();

        
            $id = $std->getstudent_IdAttribute($request);
            $title = $std->getCourse_TitleAttribute($request);
            $code = $std->getCourseCodeAttribute($request);
            $coordinator = $std->getCoordinatorAttribute($request);
            $receipt = $std->getReceiptAttribute($request);
            $date = $std->getDateAttribute($request);
            $bankname = $std->getBankNameAttribute($request);
            $bankacc = $std->getBankAccountAttribute($request);

        

        return  DB::table('graderecheck')->get($id, $title,  $code, $coordinator, $receipt, $date, $bankname, $bankacc);
        //return response()->json($std);
            //  ->select('id', 'ref_code', 'name', 'price')
            //  ->where('ref_code','=', $request->ref_code)
            //  ->first();

     }catch(Exception $e){
            return response()->json($e); 
        }
 }

 
 public static function getresultdata(Request $request)
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
        $coursetitle=$data['course_title'];
     //    $prerequisitone=$data['prerequisitone'];
     //    $prerequisittwo=$data['prerequisittwo'];
     //    $prerequisitthree=$data['prerequisitthree'];
        $coursecode=$data['course_code'];
        $grade=$data['grade'];
        $semester=$data['semester'];
        $year=$data['year'];
        //echo($grade);
        
       
       //  $course= CompletedCourse::firstOrNew(['student_id'=>$studentid,'course_id' =>$courseid,'year'=>$year]);
         
         //    $course->semester=$semester;
         //    $course->grade=$grade;
         //    $course->save();
           // $course->semester=$semester;
           
        //    DB::table('grades')->insert(array(
        //      'student_id'=> $studentid,
        //      'course_title'=>$coursetitle,
        //      'course_code'=>$coursecode,
        //      'grade'=>$grade,
        //      'semester'=>$semester,
        //      'year'=>$year,
             
             
        //  ));

         $data = [
            'student_id'=> $studentid,
            'course_title'=>$coursetitle,
            'course_code'=>$coursecode,
            'grade'=>$grade,
            'semester'=>$semester,
            'year'=>$year,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        DB::table('grades')->insert($data);



        
                  
     } 
 }catch(Exception $e) {
    return response()->json($e);
   }
     
     
 }

 
 public static function getgradedata(Request $request)
 {   
     
    try{

    
    $filename = storage_path('/app/Grades.csv');
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
        $coursetitle=$data['course_title'];
     //    $prerequisitone=$data['prerequisitone'];
     //    $prerequisittwo=$data['prerequisittwo'];
     //    $prerequisitthree=$data['prerequisitthree'];
        $coursecode=$data['course_code'];
        $grade=$data['grade'];
        $semester=$data['semester'];
        $year=$data['year'];
       

        $data = [
            'student_id'=> $studentid,
            'course_title'=>$coursetitle,
            'course_code'=>$coursecode,
            'grade'=>$grade,
            'semester'=>$semester,
            'year'=>$year,
            'updated_at'=> date('Y-m-d H:i:s'),
        ];

        DB::table('grades')->where([['student_id', $studentid],['course_title',$coursetitle],['course_code',$coursecode]])->update($data); 

       
        $email = DB::table('users')->select('Email as email_id')->where([['student_Id', $studentid ]])->first();

         Mail::to($email->email_id)->send(new GradeFeedback);
            
           
            

        
                  
     } 
 }catch(Exception $e) {
    return response()->json($e);
   }
     
     
 }


 

 public static function upload(Request $request)
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
             if($filename == "Result.csv"){
                $grade = new Admin();
                $grade->getresultdata($request);
            } 
            if ($filename == "Grades.csv")
            {
                $grade = new Admin();
                $grade->getgradedata($request);
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


 
 public static function reports($request ){
    try{
      
     $sd = $request->startdate;
     $ed = $request->enddate;

    

       return DB::table('grades')
        ->join('courses', 'courses.course_code', '=', 'grades.course_code')
        //->join('courses', 'courses.year', '=', 'grades.year')
        ->join('fees', 'fees.Level', '=', 'courses.level')
        //->join('fees', 'fees.Year', '=', 'grades.year')
        //->select('fees.Amount')
     //   ->whereBetween('grades.created_at',[$sd->format('Y-m-d')." 00:00:00", $ed->format('Y-m-d')." 23:59:59"])
      ->whereBetween('grades.created_at', [$sd, $ed])
      ->sum('fees.Amount');
     
       

      

    }catch(Exception $e){
           return response()->json($e); 
       }
}



public static function yearreport($request ){
    try{
      // $std  = new Admin();

      // $program =  DB::table('users')->select('ProgramCode as pcode')->where([['student_Id', $Student_Id ]])->first();
    //   $dateS = new Carbon('first day of January 2017');
    //    $dateE = new Carbon('first day of November 2017');
    $dateS = ('2018-02-05');
    $dateE =  ('2018-06-08');
    //  $sd = $request->startdate;
    //  $ed = $request->enddate;

    

       return DB::table('grades')
        ->join('courses', 'courses.course_code', '=', 'grades.course_code')
        //->join('courses', 'courses.year', '=', 'grades.year')
        ->join('fees', 'fees.Level', '=', 'courses.level')
        //->join('fees', 'fees.Year', '=', 'grades.year')
        //->select('fees.Amount')
     //   ->whereBetween('grades.created_at',[$sd->format('Y-m-d')." 00:00:00", $ed->format('Y-m-d')." 23:59:59"])
      ->whereBetween('grades.created_at', [$dateS, $dateE])
      ->sum('fees.Amount');
    

       

      

    }catch(Exception $e){
           return response()->json($e); 
       }
}
 


public static function year2018($request ){
    try{
      // $std  = new Admin();

      // $program =  DB::table('users')->select('ProgramCode as pcode')->where([['student_Id', $Student_Id ]])->first();
    //   $dateS = new Carbon('first day of January 2017');
    //    $dateE = new Carbon('first day of November 2017');
    $dateS = ('2018-07-09');
    $dateE =  ('2018-11-09');
    //  $sd = $request->startdate;
    //  $ed = $request->enddate;

    

       return DB::table('grades')
        ->join('courses', 'courses.course_code', '=', 'grades.course_code')
        //->join('courses', 'courses.year', '=', 'grades.year')
        ->join('fees', 'fees.Level', '=', 'courses.level')
        //->join('fees', 'fees.Year', '=', 'grades.year')
        //->select('fees.Amount')
     //   ->whereBetween('grades.created_at',[$sd->format('Y-m-d')." 00:00:00", $ed->format('Y-m-d')." 23:59:59"])
      ->whereBetween('grades.created_at', [$dateS, $dateE])
      ->sum('fees.Amount');
     
       

      

    }catch(Exception $e){
           return response()->json($e); 
       }
}
    

    

    

    
}
