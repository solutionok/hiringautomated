<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Interview;
use App\Models\InterviewHistory;
use App\Models\Review;
use App\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $interviewCount = Interview::where('active_status', 1)->count();
        $interviewIds = Interview::where('active_status', 1)->pluck('id')->toArray();
        $interviewIds[]=-1;
        $interviewHistoryIds = InterviewHistory::whereIn('interview_id', $interviewIds)->pluck('id')->toArray();
        $interviewHistoryIds[]=-1;
        $reviewCount = Review::whereIn('interview_history_id', $interviewHistoryIds)->groupBy('interview_history_id','assessor_id')->count();
        $assessorCount = User::where('isadmin', 2)->count();
        $candidateCount = User::where('isadmin', 0)->count();
        
        
        if(auth()->user()->isadmin==1){
            $intTemplates = DB::table('interview')->where('active_status','0')->get();
            
            $hasReviewInterviewIds = DB::table('review')->pluck('interview_history_id')->toArray();
            $hasReviewInterviewIds = array_unique($hasReviewInterviewIds);
            array_push($hasReviewInterviewIds, -1);
            
            $interviews = DB::table('interview_history')
                    ->select('interview_history.*', 'interview.name as interviewn', 'users.name as candidaten', 'users.photo')
                    ->join('interview', 'interview.id', '=', 'interview_history.interview_id')
                    ->join('users', 'users.id', '=', 'interview_history.candidate_id')
                    ->whereNotIn('interview_history.id', $hasReviewInterviewIds)
                    ->orderBy('interview_history.rundate', 'desc')
                    ->get();
        }else{
            $intTemplates = [];
            
            $hasReviewInterviewIds = DB::table('review')->pluck('interview_history_id')->toArray();
            $hasReviewInterviewIds = array_unique($hasReviewInterviewIds);
            array_push($hasReviewInterviewIds, -1);
            
            $interviews = DB::table('interview_history')
                    ->select('interview_history.*', 'interview.name as interviewn', 'users.name as candidaten', 'users.photo')
                    ->join('interview', 'interview.id', '=', 'interview_history.interview_id')
                    ->join('users', 'users.id', '=', 'interview_history.candidate_id')
                    ->join('interview_assessor', 'interview_assessor.interview_id', '=', 'interview.id')
                    ->where('interview_assessor.assessor_id',auth()->user()->id)
                    ->whereNotIn('interview_history.id', $hasReviewInterviewIds)
                    ->groupBy('interview_history.id')
                    ->orderBy('interview_history.rundate', 'desc')
                    ->get();
        }
        
        return view('dashboard.index',[
            'pageName'=>'dashboard', 
            'interviews'=>$interviews, 
            'intTemplates'=>$intTemplates,
            'interviewCount'=>$interviewCount,
            'reviewCount'=>$reviewCount,
            'assessorCount'=>$assessorCount,
            'candidateCount'=>$candidateCount,
        ]);
    }
}
