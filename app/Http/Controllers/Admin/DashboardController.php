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
        $maxReview = InterviewHistory::count();
        $assessorCount = User::where('isadmin', 2)->count();
        $candidateCount = User::where('isadmin', 0)->count();
        
        
        $intTemplates = DB::table('interview_candidate as a')
                ->leftJoin('interview_history as b', 'b.candidate_id', '=', 'a.candidate_id')
                ->join('interview as c', 'c.id', '=', 'a.interview_id')
                ->join('users as d', 'd.id', '=', 'a.candidate_id')
                ->whereRaw('b.id is null')
                ->select('a.*', 'd.photo', 'c.name as interviewn', 'd.name as candidaten')
                ->orderBy('c.ctt', 'desc')
                ->get();

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
