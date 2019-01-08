<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewAssessor extends Model
{
    protected $table = "interview_assessor";
    
    protected $fillable = [
        'interview_id', 'assessor_id'
    ];
    
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    public function interview(){
        return $this->belongsTo('App\Interview');
    }
    
    public function user(){
        return $this->hasOne('User','id','assessor_id');
    }
}
