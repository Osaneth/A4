<?php
namespace App;
use DB;

use App\User;

use Illuminate\Database\Eloquent\Model;


class Student 
{
  

    
    protected $fillable = [
        'student_Id', 'Firstname',  'Lastname', 'Gender', 'YearEnrolled', 'Address', 'Password', 'ProgramID','Hold','api_token'
    ];

    protected $hidden = [
        'Password', 'remember_token', 'api_token'
    ];

    // public static function addStudentdata(Request $request){
    //     $request['api_token'] = str_random(60);
    //     $request['Password'] = app('hash')->make($request['Password']) ;
    //     $user = Student::create($request -> all());

    //     return response()->json($user);
    // }
    
    // public static function getProfile1(Request $request, $Student_Id){
       
    //     // $studentid = $id;
    //     $student = User::where('Student_Id', '=' ,$Student_Id)->get();// finds student id and gets data
    //     return response()->json($student);
    //     //  $student = User::find($Student_Id);
    //     //  return response()->json($student);
 
    //  }

    

    // public function setStudentIDAttribute( $request)
    // {
    //     $this->attributes['student_Id']= $request;
    // }

    // public function setFirstname( $value)
    // {
    //     $this->attributes['Firstname']= $value;
    // }

    public function setLastname( $value)
    {
        $this->attributes['Lastname']= $value;
        return $this;
    }

    public function setGender( $value)
    {
        $this->attributes['Gender']= $value;
    }

    public function setYearEnrolled( $request)
    {
        $this->attributes['YearEnrolled']= $request;
    }

    public function setAddress( $request)
    {
        $this->attributes['Address']= $request;
    }

    public function setPassword( $request)
    {
        $this->attributes['Password']= $request;
    }

    public function setProgramCode( $request)
    {
        $this->attributes['ProgramCode']= $request;
    }

    public function setHold( $request)
    {
        $this->attributes['Hold']= $request;
    }

    public function settoken( $request)
    {
        $this->attributes['api_token']= $request;
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

    
}