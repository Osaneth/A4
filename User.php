<?php

namespace App;
use DB;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
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
        'Course_Title', 'Course_Code','Coordinator','Receipt','Date','Bank_Name','Bank_Account',
        'Grade', 'Semester', 'Year'
    ];

    

    public function setStudentIDAttribute( $request)
    {
        $this->attributes['student_Id']= $request->student_Id;
       
    }

    public function setCourseTitleAttribute( $request)
    {
        $this->attributes['Course_Title']= $request->Course_Title;
          
    }

    public function setCourseCodeAttribute( $request)
    {
        $this->attributes['Course_Code']= $request->Course_Code;
          
    }

    public function setCoordinatorAttribute( $request)
    {
        $this->attributes['Coordinator']= $request->Coordinator;
          
    }
    
    public function setReceiptAttribute( $request)
    {
        $this->attributes['Receipt']= $request->Receipt;
          
    }
    
    public function setDateAttribute( $request)
    {
        $this->attributes['Date']= $request->Date;
          
    }

    public function setBankNameAttribute( $request)
    {
        $this->attributes['Bank_Name']= $request->Bank_Name;
          
    }

    public function setBankAccountAttribute( $request)
    {
        $this->attributes['Bank_Account']= $request->Bank_Account;
          
    }
    
    public function setFirstnameAttribute( $request)
    {
        $this->attributes['Firstname']= $request->Firstname;
          
    }

    public function setLastnameAttribute( $request)
    {
        $this->attributes['Lastname']= $request->Lastname;
    }

    public function setGenderAttribute( $request)
    {
        $this->attributes['Gender']= $request->Gender;
    }

    public function setYearEnrolledAttribute( $request)
    {
        $this->attributes['YearEnrolled']= $request->YearEnrolled;
    }

    public function setAddressAttribute( $request)
    {
        $this->attributes['Address']= $request->Address;
    }

    public function setPasswordAttribute( $request)
    {
        $this->attributes['Password']= $request->Password;
    }

    public function setProgramCodeAttribute( $request)
    {
        $this->attributes['ProgramCode']= $request->ProgramCode;
    }

    public function setHoldAttribute( $request)
    {
        $this->attributes['Hold']= $request->Hold;
    }

    public function settokenAttribute( $request)
    {
        $this->attributes['api_token']= $request->api_token;
    }

    public function setEmailAttribute( $request)
    {
        $this->attributes['Email']= $request->Email;
    }

    public function setRoleAttribute( $request)
    {
        $this->attributes['role']= $request->role;
    }

    public function getCourse_TitleAttribute($request)
    {
        return $request->Course_Title;
    }

    public function getCourse_CodeAttribute($request)
    {
        return $request->Course_Code;
    }

    
    public function getGradeAttribute($request)
    {
        return $request->Grade;
    }

    public function getSemesterAttribute($request)
    {
        return $request->Semester;
    }

    public function getYearAttribute($request)
    {
        return $request->Year;
    }


    public static function grades($request, $Student_Id){
        try{
           $std  = new User();
   
           
               $title = $std->getCourse_TitleAttribute($request);
               $code = $std->getCourse_CodeAttribute($request);
               $grade = $std->getGradeAttribute($request);
               $semester = $std->getSemesterAttribute($request);
               $year = $std->getYearAttribute($request);
      
           
   
           //$program =  DB::table('users')->select('ProgramCode as pcode')->where([['student_Id', $Student_Id ]])->first();
           

               return DB::table('grades')
                //->join('programs', 'programs.course_code', '=', 'grades.course_code')
                //->join('users', 'users.ProgramCode', '=', 'programs.program_code')
                ->select('grades.course_title', 'grades.course_code', 'grades.grade', 'grades.semester', 'grades.year')
                ->where([['grades.student_id','=', $Student_Id]])
               // ->orWhere([['programs.program_code', $program->pcode]])
                //->groupBy('grades.course_code')
                ->get();
              //  ->first();
   
        }catch(Exception $e){
               return response()->json($e); 
           }
    }


    public static function gradedetails($request, $Student_Id){
        try{
           $std  = new User();
   
           
               $title = $std->getCourse_TitleAttribute($request);
               $code = $std->getCourse_CodeAttribute($request);
               $grade = $std->getGradeAttribute($request);
               $semester = $std->getSemesterAttribute($request);
               $year = $std->getYearAttribute($request);
      
           
   
           $program =  DB::table('users')->select('ProgramCode as pcode')->where([['student_Id', $Student_Id ]])->first();
           

               return DB::table('grades')
                ->join('programs', 'programs.course_code', '=', 'grades.course_code')
                ->join('users', 'users.ProgramCode', '=', 'programs.program_code')
                ->select('grades.course_title', 'grades.course_code', 'grades.grade', 'grades.semester', 'grades.year')
                ->where([['grades.student_id','=', $Student_Id], ['programs.program_code', $program->pcode]])
               // ->orWhere([['programs.program_code', $program->pcode]])
                ->groupBy('grades.course_code')
                ->get();
              //  ->first();
   
        }catch(Exception $e){
               return response()->json($e); 
           }
    }


    public static function addstudent($request) {
        
           
        $std  = new User();
      
        $std->setFirstnameAttribute($request);
        $std->setLastnameAttribute($request);
        $std->setGenderAttribute($request);
        $std->setYearEnrolledAttribute($request);
        $std->setAddressAttribute($request);
        $std->setPasswordAttribute($request);
        $std->setProgramCodeAttribute($request);
        $std->setHoldAttribute($request);
        $std->settokenAttribute($request);
        $std->setEmailAttribute($request);
        $std->setRoleAttribute($request);

        $std->save();  
 }



 public static function addrecheck($request) {
        
           
    $std  = new User();
  
     $std->setStudentIDAttribute($request);
     $std->setCourseTitleAttribute($request);
    $std->setCourseCodeAttribute($request);
  
    $std->setCoordinatorAttribute($request);
    $std->setReceiptAttribute($request);
    $std->setDateAttribute($request);
    $std->setBankNameAttribute($request);
    $std->setBankAccountAttribute($request);

    // $data = array('student_Id'=> $id, "Course_Title"=>  $title );
    // //$std->save( $data);
    // DB::table('graderecheck')->save($data);

        

    
    
    //DB::insert into '' 

//    // DB::insert('insert into graderecheck (student_Id ) values (?), (?)', [$id, $title]);
//     DB::table('graderecheck')->insert(['student_Id' => $std->setStudentIDAttribute($request), 'Course_Title' =>  $std->setCourseTitleAttribute($request)]);
//    // return response()->json($std);
// $data = array('student_Id'=> $id, "Course_Title"=>  $title );
//     // DB::table('graderecheck')->insert($data);
//    // DB::insert('insert into graderecheck (student_Id) ( values(?)',[$id]);
//    // $std->save();  
    DB::table('graderecheck')->insert(array(
        'student_Id'=> $request->student_Id,
        'Course_Title'=>$request->Course_Title,
        'Course_Code'=>$request->Course_Code,
        // 'Coordinator'=>$request->Coordinator,
        // 'Receipt'=>$request->Receipt,
        // 'Date'=>$request->Date,
        // 'Bank_Name'=>$request->Bank_Name,
        // 'Bank_Account'=>$request->Bank_Account,
        
    ));
    //return response()->json($std);
      //  return ($std->setStudentIDAttribute($request));


}
    

    // protected $hidden = [
    //     'Password', 'remember_token', 'api_token'
    // ];

    
    // public static function addstudent($request) {
    //     $data = [
    //         'student_Id' => $request->student_Id,
    //         'Firstname' => $request->Firstname,
    //         'Lastname' => $request->Lastname,
    //         'Gender' => $request->Gender,
    //         'YearEnrolled' => $request->YearEnrolled,
    //         //'comment' => $request->comment,
    //         'Address' => $request->Address,
    //         'Password' => $request->Password,
    //         'ProgramCode' => $request->ProgramCode,
    //         'Hold' => $request->Hold,
    //         'api_token' => $request->api_token,

    //         // $request['api_token'] = str_random(60);
    //     // $request['Password'] = app('hash')->make($request['Password']) ;
    //         // 'active_yn' => true,
    //         // 'modified_by' => auth()->user()->name,
    //         // 'modified_on' => Carbon::now()->toDateTimeString()
    //     ];

    //     DB::table('users')->insert($data);
    // }

    
 public static function addchangeprogram($request, $id) {
        
    try {
        $data = [
            'ProgramCode' => $request->program,
            //'ProgramName' => $request->program,
            
        ];
    
        return DB::table('users')->where([['student_Id', $id]])->update($data); 
        //return response()->json(" 'created' => true ");
    //    return [
    //     'created' => true 
    // ];
    }catch(Exception $e){
       return response()->json($e); 
       //return response()->json(['error' => $e->getMessage()], 500);
       //throw new HttpException(500, $e->getMessage());
    }
    
    
    
   

}


    

    
}
