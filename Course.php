<?php


namespace App; 

use Illuminate\Database\Eloquent\Model;



class Course extends Model
{
  
    protected $fillable = [
        'course_id','course_code', 'course_title',  'prerequisitone', 'prerequisittwo', 'prerequisitthree', 'semester', 'year', 'mode', 'campus','description','fees'
    ];

    protected $hidden = [
    
    ];
}