<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private static $quizTypes = [
        '1' => 'Multi Choice',
        '2' => 'Single Choice',
//        '3' => 'Record Audio',
        '4' => 'Record Video',
    ];

    public function index(Request $request){
        $ds = getReviewPageSearchDate($request);
        $interview_id = $request->input('search-select', '');
        $range = [];
        if($interview_id){
            $range = explode('/', $request->input('range', '0/100'));
            
            $interview = DB::table('interview')->where('id', $interview_id)->first();
            $totalScore = DB::table('quiz')->where('interview_id', $interview_id)->sum('grade');
            $minScore = $totalScore * $range[0]/100;
            $maxScore = $totalScore * $range[1]/100;
        }
        
        if(auth()->user()->isadmin==0){
            $re = DB::table('interview_history')
                    ->select('interview_history.*', 'users.name as usern', 'users.photo', 'users.phone', 'users.email as email', 'interview.name as interviewn', 'interview.att')
                    ->join('users', 'interview_history.candidate_id', '=', 'users.id')
                    ->join('interview', 'interview_history.interview_id', '=', 'interview.id')
                    ->where('interview_history.candidate_id',auth()->user()->id)
                    ->whereRaw($interview_id
                            ?('interview_history.interview_id='.$interview_id)
                            :DB::raw('date(interview_history.rundate) between date("'.$ds[0].'") and date("'.$ds[1].'")'))
                    ->whereRaw($request->input('search-what','') 
                            ? ('(interview.name like "%'.$request->input('search-what').'%" OR users.name like "%'.$request->input('search-what').'%")')
                            : ('1')
                            )
                    ->whereRaw($interview_id?('interview_history.grade between ' . $minScore . ' and ' . $maxScore):'1')
                    ->orderBy('interview_history.rundate', 'desc')
                    ->get();
        }else if(auth()->user()->isadmin==2){
            $re = DB::table('interview_history')
                    ->select('interview_history.*', 'users.name as usern', 'users.photo', 'users.phone', 'users.email as email', 'interview.name as interviewn', 'interview.att')
                    ->join('users', 'interview_history.candidate_id', '=', 'users.id')
                    ->join('interview', 'interview_history.interview_id', '=', 'interview.id')
                    ->join('interview_assessor', function($join){
                        return $join->on('interview_assessor.interview_id', '=', 'interview_history.interview_id')
                                ->where('interview_assessor.assessor_id', auth()->user()->id);
                    })
                    ->whereRaw($interview_id
                            ?('interview_history.interview_id='.$interview_id)
                            :DB::raw('date(interview_history.rundate) between date("'.$ds[0].'") and date("'.$ds[1].'")'))
                    ->whereRaw($request->input('search-what','') 
                            ? ('(interview.name like "%'.$request->input('search-what').'%" OR users.name like "%'.$request->input('search-what').'%")')
                            : ('1'))
                    ->whereRaw($interview_id?('interview_history.grade between ' . $minScore . ' and ' . $maxScore):'1')
                    ->orderBy('interview_history.rundate', 'desc')
                    ->get();
        }else{
            $re = DB::table('interview_history')
                    ->select('interview_history.*', 'users.name as usern', 'users.photo', 'users.phone', 'users.email as email', 'interview.name as interviewn', 'interview.att')
                    ->join('users', 'interview_history.candidate_id', '=', 'users.id')
                    ->join('interview', 'interview_history.interview_id', '=', 'interview.id')
                    ->whereRaw($interview_id
                            ?('interview_history.interview_id='.$interview_id)
                            :DB::raw('date(interview_history.rundate) between date("'.$ds[0].'") and date("'.$ds[1].'")'))
                    ->whereRaw($request->input('search-what','') 
                            ? ('(interview.name like "%'.$request->input('search-what').'%" OR users.name like "%'.$request->input('search-what').'%")')
                            : ('1'))
                    ->whereRaw($interview_id?('interview_history.grade between ' . $minScore . ' and ' . $maxScore):'1')
                    ->orderBy('interview_history.rundate', 'desc')
                    ->get();
        }
        
        $interviews = DB::table('interview')->get();
        $searchSelect = '<select name="search-select" class="form-control" style="width:300px;" onchange="this.form.submit()">';
        $searchSelect .= '<option value=""> -- Search by interview -- </option>';
        foreach($interviews as $it){
            $searchSelect .= '<option value="'.$it->id.'" '.($interview_id==$it->id?'selected':'').'>'.$it->name.'</option>';
        }
        $searchSelect .= '</select>';
        return view('review.index',[
            'pageName'=>'review', 
            'searchFormAction'=>'/admin/review', 
            'searchWhat'=>$request->input('search-what'), 
            'searchPlaceholder'=>'Search by candidate, interview name', 
            'searchSelect'=>$searchSelect, 
            'searchInterviewId'=>$interview_id, 
            'range'=>implode('/', $range), 
            'history'=>$re, 
            'qtypes'=>self::$quizTypes, 
            'searchDateRange'=>$ds
        ]);
    }
    
    public function viewInterview($id, $step = 0){
        $history = DB::table('interview_history')->where('id', $id)->first();
        $steps = (array)json_decode($history->interview_result);
        
        if(count($steps)<$step){
            return redirect('/admin/review/'.$id);
        }
        
        $interview = DB::table('interview')->where('id', $history->interview_id)->first();
        $candidate = DB::table('users')->where('id', $history->candidate_id)->first();
        
        $quiz = $step ? $steps[$step-1] : false;
        
        $reviews = DB::table('review as a')
                ->select('a.*','b.name as assessorn','b.photo')
                ->join('users as b', 'b.id', '=', 'a.assessor_id')
                ->where('a.interview_history_id', $id)
                ->where('a.quiz_id', $quiz ? $quiz->id : 0)
                ->get();
        
        return view('review.view',[
            'pageName'=>'review', 
            'reviews'=>$reviews, 
            'step'=>$step, 
            'steps'=>$steps, 
            'quiz'=>$quiz, 
            'history'=>$history, 
            'interview'=>$interview, 
            'candidate'=>$candidate, 
            'qtypes'=>self::$quizTypes]);
    }
    
    public function setGrade(Request $request){
        $historyId = $request->input('historyId');
        $quiz_id = $request->input('quiz_id', 0);
        $mark = $request->input('grade', 0);
        $comment = $request->input('review', '');

        $review = Db::table('review')
                ->where('interview_history_id', $historyId)
                ->where('assessor_id', auth()->user()->id)
                ->where('quiz_id', $quiz_id)
                ->first();

        if(!$review){
            Db::table('review')->insert([
                'comment' => $comment,
                'grade' => $mark,
                'interview_history_id' => $historyId,
                'assessor_id' => auth()->user()->id,
                'quiz_id' => $quiz_id,
                'review_time' => now(),
            ]);
        }else{
            Db::table('review')
                ->where('interview_history_id', $historyId)
                ->where('assessor_id', auth()->user()->id)
                ->where('quiz_id', $quiz_id)
                ->update([
                    'comment' => $comment,
                    'grade' => $mark,
                    'review_time' => now(),
                ]);
        }

        if($quiz_id){
            $history = Db::table('interview_history')->where('id', $historyId)->first();
            $history = (array) $history;
            $steps = (array)json_decode($history['interview_result']);
            
            $avgGrade = Db::table('review')
                ->where('interview_history_id', $historyId)
                ->where('quiz_id', $quiz_id)
                ->sum('grade');
            
            $totalmark = 0;
            foreach($steps as $i=>&$sp){
                $sp = (array)$sp;
                if($sp['id']==$quiz_id && intval($sp['qtype'])>2){
                    $sp['mark'] = $avgGrade;
                }
                $totalmark += empty($sp['mark']) ? 0 : $sp['mark'];
            }

            $history['grade'] = $totalmark;
            $history['interview_result'] = json_encode($steps);
            $history = Db::table('interview_history')->where('id', $historyId)->update($history);
        }
        
        
        die();
    }
    
    public function historyinfo(Request $request){
        $review = DB::table('review')
                ->where('interview_history_id', $request->input('history_id'))
                ->where('assessor_id', auth()->user()->id)
                ->where('quiz_id', $request->input('quiz_id', 0))
                ->first();
        
        if($request->input('quiz_id', 0)){
            $history = DB::table('interview_history')->where('id', $request->input('history_id'))->first();
            $re = ['comment'=>$review?$review->comment:''];
            
            foreach(json_decode($history->interview_result) as $quiz){
                
                if($quiz->id == $request->input('quiz_id')){
                    $re['qtype'] = $quiz->qtype;
                    $re['grade'] = $quiz->grade;
                    $re['mark'] = intval($quiz->qtype)>2?($review?$review->grade:0):(isset($quiz->mark)?$quiz->mark:0);
                }
            }
            
            echo json_encode($re);
        }else{
            echo $review?$review->comment:'';
        }
        
        die;
    }
    
    public function exportcsv(Request $request){
        $interviewId = $request->input('it');
        $range = explode('/', $request->input('range'));
        $interview = DB::table('interview')->where('id', $interviewId)->first();
        $totalScore = DB::table('quiz')->where('interview_id', $interviewId)->sum('grade');
        $minScore = $totalScore * $range[0]/100;
        $maxScore = $totalScore * $range[1]/100;
        
        $rows = DB::table('interview_history as a')
                    ->join('users as b', 'b.id', '=', 'a.candidate_id')
                    ->where('a.interview_id', $interviewId)
                    ->whereRaw('a.grade between ' . $minScore . ' and ' . $maxScore)
                    ->orderBy('a.grade', 'desc')
                    ->get()
                ;
        
        $filename = $interview->name . "_Score_From_".$minScore."_TO_".$maxScore.".csv";
        @unlink($filename);
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('#', 'Name', 'E-mail', 'Phone', 'Date', 'Score'));

        foreach($rows as $i=>$row) {
            fputcsv($handle, array($i+1, $row->name, $row->email, $row->phone, $row->grade));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download(public_path().'/'. $filename, $filename, $headers);
    }
}
