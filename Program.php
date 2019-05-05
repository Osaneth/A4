<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class Program extends Model
{
  
    protected $fillable = [
        'Program_id', 'program_code', 'course_code'
    ];

    protected $hidden = [
        
    ];
}