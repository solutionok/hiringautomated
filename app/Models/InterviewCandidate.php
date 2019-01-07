<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewCandidate extends Model
{
    protected $table = "interview_candidate";
    
    protected $fillable = [
        'interview_id', 'candidate_id'
    ];
    
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
