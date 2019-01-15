<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Quiz;
use App\Models\InterviewHistory;
use App\User;

class HomeController extends Controller
{
    
    public function index()
    {
        return view('home.index', ['pageClass'=>'front-main']);
    }
    
    
    public function interview(){
        $re = [];
        if(Auth::check()){
            $uid = auth()->user()->id;
            
            $hasInterviewIds = DB::table('interview_history')->where('candidate_id', $uid)->pluck('interview_id')->toArray();
            array_push($hasInterviewIds,-1);
            
            $re = DB::table('interview')
                    ->select('interview.*', 'interview_history.id as hisid', 'review.id as reviewid', 'interview_history.grade as mygrade', DB::raw('sum(quiz.grade) as grade'))
                    ->join('interview_candidate','interview_candidate.interview_id','=','interview.id')
                    ->join('quiz','quiz.interview_id','=','interview.id')
                    ->leftJoin('interview_history', function($join) use ($uid){
                        return $join->on('interview_history.interview_id','=','interview.id')
                                ->where('interview_history.candidate_id', $uid);
                    })
                    ->leftJoin('review','review.interview_history_id','=','interview_history.id')
                    ->where('interview_candidate.candidate_id',$uid)
                    ->groupBy('interview.id')
                    ->get();
        }
        return view('home.interview',['pageName'=>'interview','interviewList'=>$re]);
    }
    
    public function run($interviewId, Request $request)
    {
        $interviewSession = $request->session()->get('currentInterview', false);
        if(!$interviewSession && InterviewHistory::where('interview_id', $interviewId)->where('candidate_id', auth()->user()->id)->count()){
            return redirect('/home/interview');
        }
        
        $interview = DB::table('interview')->where('id', $interviewId)->first();
        $quizCount = DB::table('quiz')->where('interview_id', $interviewId)->count();
        

        if(!$interviewSession){
            $interviewSession = [
                'started' => strtotime(now()),
                'interviewId' => $interviewId,
                'step' => 1,
                'history' => []
            ];
        }
        
        $interviewSession['touched'] = strtotime(now());
        
        if(($quizCount-$interviewSession['step']) >= 0){
            $quiz = DB::table('quiz')->where('interview_id', $interviewId)->orderBy('order_val')->offset($interviewSession['step']-1)->limit(1)->first();
            $interviewSession['history'][$interviewSession['step']-1] = (array) $quiz;
            $request->session()->put('currentInterview', $interviewSession);
            $this->saveToDatabase($request);
            return view('home.run', ['pageName'=>'Interview', 'interview'=>$interview, 'quiz'=>$quiz, 'step'=>$interviewSession['step'], 'maxStep'=>$quizCount]);
        }else{
            $this->saveToDatabase($request);
            
            $request->session()->forget('currentInterview');
            
            return redirect('/home/interview');
        }
        
    }
    
    function saveToDatabase($request){
        $interviewSession = $request->session()->get('currentInterview', false);
        if(!$interviewSession){
            return redirect('/home/interview');
        }

        $row = [
            'candidate_id' => $user = auth()->user()->id,
            'interview_id' => $interviewSession['interviewId'],
            'rundate' => now(),
            'grade' => 0,
            'interview_result' => json_encode($interviewSession['history'])
        ];
        
        $grade = 0;
        $availGrade = 0;

        foreach($interviewSession['history'] as $h){
            $grade += isset($h['mark'])?$h['mark']:0;
            $availGrade += isset($h['grade'])?$h['grade']:0;
        }

        $row['grade'] = $grade;
        $row['availgrade'] = $availGrade;

        if(isset($interviewSession['savedid'])){
            DB::table('interview_history')->where('id', $interviewSession['savedid'])->update($row);
        }else{
            $interviewSession['savedid'] = DB::table('interview_history')->insertGetId($row);
            $request->session()->put('currentInterview', $interviewSession);
        }
    }

    public function runsave(Request $request)
    {
        $interviewSession = $request->session()->get('currentInterview', false);
        if(!$interviewSession){
            die('Your request was denided!');
        }
        
        $quiz = $interviewSession['history'][$interviewSession['step']-1];
        $quiz['runtime'] = strtotime(now()) - $interviewSession['touched'];

        if(intval($quiz['qtype']) == 3 || intval($quiz['qtype']) == 4){
            $fileName = uniqid().(intval($quiz['qtype'])==3 ? '.wav' : '.webm');
            $savePath = $request->recordFile->storeAS('app/record', $fileName);
            
            @chmod(dirname($savePath), 0777);
            @unlink($savePath);
            @rename($request->recordFile->path(), $savePath);
            
            $quiz['record'] = $savePath;
            
            echo 'The record data was saved successfully!';
        }else{
            $checked = $request->input('checked');
            $qdetail = (array) json_decode($quiz['qdetail']);
            
            if(count($checked)!=count($qdetail['ch'])){
                die('Your request was denided!');
            }
            
            $corrected = 0;
            $correctCount = 0;
            
            foreach($qdetail['ch'] as $i=>$ch){
                if(intval($ch) == 1){
                    $correctCount++;
                }
                
                if(intval($ch) == 0 && intval($checked[$i])==1){
                    $corrected--;
                }else if(intval($ch) == 1 && 1 == intval($checked[$i])){
                    $corrected++;
                }
            }
            
            if($corrected==$correctCount){
                $mark = $quiz['grade'];
                echo 'Saved';
            }else if($corrected>0 && $corrected<$correctCount){
                $mark = round($corrected/$correctCount*$quiz['grade'], 1);
                echo 'Saved';
            }else{
                $mark = 0;
                echo 'Saved';
            }
            
            $quiz['detail'] = $checked;
            $quiz['mark'] = $mark;
        }
        
        $interviewSession['history'][$interviewSession['step']-1] = $quiz;
        $interviewSession['step']++;
        $request->session()->put('currentInterview', $interviewSession);
    }
    
    public function mypage(Request $request){
        if(auth()->user()->isadmin!=0){
            return redirect('/admin/dashboard');
        }
        $id= auth()->user()->id; 
        $re = false;
        $interview = false;
        
        if($id){
            $re = DB::table('users')->where('id', $id)->first();
            $interview=DB::table('interview_candidate')->where('candidate_id', $id)->value('interview_id');
        }
        
        
        $interviews = DB::table('interview')->get();
        return view('home.mypage',['pageName'=>'profile', 'user'=>$re, 'interview'=>$interview, 'interviews'=>$interviews]);
    }
    
    public function emailcheck(Request $request){
        $email = $request->input('email');
        if(!$email)die;
        $id = $request->input('id');
        
        if($id && DB::table('users')->where('id','<>',$id)->where('email', 'like', $email)->count()){
            die('exists');
        }
        
        if(!$id && DB::table('users')->where('email', 'like', $email)->count()){
            die('exists');
        }
        
        die('ok');
    }
    
    public function mysave(Request $request){
        $employee_history = [];
        $education_history = [];
        $skill_grade = [];
        $data = $request->input();
        if(isset($data['emp-job'])){
            foreach($data['emp-job'] as $i=>$e){
                if(empty($data['emp-job'][$i]))continue;
                $employee_history[] = [$data['emp-job'][$i], $data['emp-from'][$i], $data['emp-to'][$i]];
            }
        }
        
        if(isset($data['edu-job'])){
            foreach($data['edu-job'] as $i=>$e){
                if(empty($data['edu-job'][$i]))continue;
                $education_history[] = [$data['edu-job'][$i], $data['edu-from'][$i], $data['edu-to'][$i]];
            }
        }
        
        if(isset($data['skill-label'])){
            foreach($data['skill-label'] as $i=>$e){
                if(empty($data['skill-label'][$i]))continue;
                $skill_grade[] = [$data['skill-label'][$i], $data['skill-level'][$i]];
            }
        }
        
        $user = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['phone']),///////////////////////////////////////////////
            'updated_at' => now(),
            'isadmin' => 0,
            'summary' => $data['summary'],
            'employee_history' => json_encode($employee_history),
            'education_history' => json_encode($education_history),
            'skill_grade' => json_encode($skill_grade),
        ];
        
        
        if (isset($_FILES['preview_image'])&&!$_FILES['preview_image']['error']) {
            $ext = strtolower(pathinfo($_FILES['preview_image']['name'])['extension']);
            $file = '/app/candidate/'.uniqid().'.'.$ext;
            $savePath = public_path().$file;
            @chmod(dirname($savePath), 0777);
            @unlink($savePath);
            rename($_FILES['preview_image']['tmp_name'], $savePath);
            $user['photo'] = $file;
        }
        
        
        $id = $request->input('candidate_id');
        DB::table('users')
                ->where('id', $id)
                ->update($user);
        
        return redirect('home/mypage');
    }
    
    public function passchange(Request $request){
        $d = $request->input();
        
        $currentPasswordHash = DB::table('users')->where('id',auth()->user()->id)->first()->password;
        
        if(!Hash::check($request->current_password, $currentPasswordHash)){
            die('<script>top.alert("Current password is wrong!");</script>');
        }
        
        $request->user()->fill([
            'password' => Hash::make($request->new_password)
        ])->save();
        
        die('<script>top.location.reload();</script>');
    }
    
    public function review($id, $step = 0){
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
        
        $hasReview = DB::table('review as a')
                ->where('a.interview_history_id', $id)
                ->get()->count();
        
        return view('home.review',[
            'pageName'=>'Interview', 
            'reviews'=>$reviews, 
            'hasReview'=>$hasReview, 
            'step'=>$step, 
            'steps'=>$steps, 
            'quiz'=>$quiz, 
            'history'=>$history, 
            'interview'=>$interview, 
            'candidate'=>$candidate]);
    }
    
    public function uploadcv(Request $request){
        if (isset($_FILES['cv-file'])&&!$_FILES['cv-file']['error']) {
            $ext = strtolower(pathinfo($_FILES['cv-file']['name'])['extension']);
            $file = '/app/cv/'.uniqid().'.'.$ext;
            $savePath = public_path().$file;
            @chmod(dirname($savePath), 0777);
            @unlink($savePath);
            rename($_FILES['cv-file']['tmp_name'], $savePath);
            $user['cv'] = $file;
            DB::table('users')
                    ->where('id', auth()->user()->id)
                    ->update(['cv'=>$file]);
            die('<script>top.alert("CV saved!");top.location.reload();</script>');
        }
    }
}
