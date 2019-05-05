<?php


namespace App; 

use Illuminate\Database\Eloquent\Model;



class RegisteredCourse extends Model
{
  
    protected $fillable = [
        'id','student_id', 'course_id',  'semester', 'year'
    ];

    protected $hidden = [
    
    ];
}