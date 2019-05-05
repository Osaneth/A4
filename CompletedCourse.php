<?php


namespace App; 

use Illuminate\Database\Eloquent\Model;



class CompletedCourse extends Model
{
  
    protected $fillable = [
        'id','student_id', 'course_id',  'semester', 'year', 'grade'
    ];

    protected $hidden = [
    
    ];
}