<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $table = "interview";
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    
    public function assessors(){
        return $this->hasMany('App\Models\InterviewAssessor');
    }
}
