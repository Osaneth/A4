<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class Prerequisites extends Model
{
  
    protected $fillable = [
        'Prereq_id', 'year','subgroup1', 'coursecode', 'type', 'subgroup2'
    ];

    protected $hidden = [
        
    ];
}