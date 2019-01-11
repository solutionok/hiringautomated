<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\InterviewCandidate;
use App\Models\InterviewAssessor;
use App\Models\InterviewHistory;
use App\Models\Interview;
use App\User;
use Response;


class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $interview_id = $request->input('search-select', '');
        $interviews = DB::table('interview')->get();
        
        if($interview_id){
            $re = DB::table('interview_candidate')
                    ->select('users.*')
                    ->join('users', 'interview_candidate.candidate_id','=','users.id')
                    ->where('interview_candidate.interview_id', $interview_id)
                    ->whereRaw($request->input('search-what','') 
                            ? ('(users.name like "%'.$request->input('search-what').'%" OR users.email like "%'.$request->input('search-what').'%" OR users.phone like "%'.$request->input('search-what').'%")')
                            : ('users.id>0'))
                    ->groupBy('interview_candidate.candidate_id')
                    ->get();
        }else{
            $re = DB::table('users')
                    ->select('users.*')
                    ->where('users.isadmin',0)
                    ->whereRaw($request->input('search-what','') 
                            ? ('(users.name like "%'.$request->input('search-what').'%" OR users.email like "%'.$request->input('search-what').'%" OR users.phone like "%'.$request->input('search-what').'%")')
                            : ('users.id>0'))
                    ->get();
        }
        
        foreach($re as &$r){
            $itIds = DB::table('interview_candidate')
                    ->where('candidate_id',$r->id)
                    ->pluck('interview_id')
                    ->toArray();
            
            array_push($itIds, -1);
            
            $interviewList = DB::table('interview as a')
                    ->leftJoin('interview_history as b', function($join) use ($r){
                        return $join->on('a.id', '=', 'b.interview_id')
                                ->where('b.candidate_id', $r->id);
                    })
                    ->leftJoin('interview_candidate as c', function($join) use ($r){
                        return $join->on('a.id', '=', 'c.interview_id')
                                ->where('c.candidate_id', $r->id);
                    })
                    ->whereIn('a.id',$itIds)
                    ->groupBy('a.id')
                    ->select('a.name','b.*','c.assessor_id as as_ids')
                    ->get();
            
            $r->interviewList = $interviewList;
        }
        
        $searchSelect = '<select name="search-select" class="form-control" style="width:300px;" onchange="this.form.submit()">';
        $searchSelect .= '<option value=""> -- Search by interview -- </option>';
        foreach($interviews as $it){
            $searchSelect .= '<option value="'.$it->id.'" '.($interview_id==$it->id?'selected':'').'>'.$it->name.'</option>';
        }
        $searchSelect .= '</select>';
        
        $assesors=DB::table('users')->where('isadmin',2)->get()->keyBy('id') ;
        return view('candidate.index',[
            'pageName'=>'candidate', 
            'searchFormAction'=>'/admin/candidate', 
            'searchWhat'=>$request->input('search-what'), 
            'searchPlaceholder'=>'Search by name, email, phone', 
            'searchSelect'=>$searchSelect, 
            'list'=>$re, 
            'interviews'=>$interviews, 
            'assesors'=>$assesors, 
            'interview_id'=>$interview_id]);
    }
    
    public function view(Request $request){
        $id= $request->input('id', false); 
        $re = false;
        $interviewIds = [];
        $histories = [];
        
        if($id){
            $re = DB::table('users')->where('id', $id)->first();
            $interviewIds=InterviewCandidate::where('candidate_id', $id)->pluck('interview_id')->toArray();
            $histories=DB::table('interview as a')
                    ->leftJoin('interview_candidate as c', 'a.id', '=', 'c.interview_id')
                    ->leftJoin('interview_history as b', function($join) use ($id){
                        return $join->on('a.id', '=', 'b.interview_id')
                                ->where('b.candidate_id', $id);
                    })
                    ->where('c.candidate_id', $id)
                    ->select('a.*', 'b.id as hid', 'b.rundate', 'b.availgrade', 'b.grade')
                    ->get();
        }
        
        $interviews = DB::table('interview')->whereRaw('date(ctt)>=date("'.date('Y-m-d').'")')->get();
        
        return view('candidate.view',['pageName'=>'candidate', 'user'=>$re, 'interviewIds'=>$interviewIds, 'interviews'=>$interviews, 'histories'=>$histories]);
    }
    
    public function remove(Request $request){
        $ids = $request->input('id');
        if(!is_array($ids)){
            $ids = (array)$ids;
        }
        foreach($ids as $id){
            if(!$id)continue;
            $user = DB::table('users')->where('id', $id)->first();

            if(isset($user->photo)){
                @unlink(public_path().'/'.$user->photo);
            }

            DB::table('users')->where('id', $id)->delete();
        }
        die('ok');
    }
    
    public function save(Request $request){
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
            'created_at' => now(),
            'updated_at' => now(),
            'isadmin' => 0,
            'summary' => $data['summary'],
            'employee_history' => json_encode($employee_history),
            'education_history' => json_encode($education_history),
            'skill_grade' => json_encode($skill_grade),
        ];
        
        if($data['new_password']||!$request->input('candidate_id')){
            $setPassword = $data['new_password']?$data['new_password']:($user['phone']);
            $user['password'] = Hash::make($setPassword);
            
            /////////////////////
            $title = env('APP_NAME');
            $content = "Hello, ".$user['name']."! Your password is " . $setPassword;

            sendMail($user['email'], $title, $content);
            /////////////////////////////
        }
        
        if (isset($_FILES['preview_image'])&&!$_FILES['preview_image']['error']) {
            $ext = strtolower(pathinfo($_FILES['preview_image']['name'])['extension']);
            $file = 'app/candidate/'.uniqid().'.'.$ext;
            
            
            $savePath = public_path().'/'.$file;
            
            if(!is_dir(dirname($savePath))){
                @mkdir(dirname($savePath));
                @chmod(dirname($savePath), 0777);
            }
            @chmod(dirname($savePath), 0777);
            @unlink($savePath);
            rename($_FILES['preview_image']['tmp_name'], $savePath);
            $user['photo'] = $file;
        }
        
        
        if($request->input('candidate_id')){
            $id = $request->input('candidate_id');
            DB::table('users')
                    ->where('id', $id)
                    ->update($user);
        }else{
            $id = DB::table('users')->insertGetId($user);
        }
        
        //interview candidate
        $assignedInterviewIds = array_filter(array_unique(explode(',', $request->input('assigned_interview_ids', ''))));
        if(count($assignedInterviewIds)){
            
            DB::table('interview_candidate')->where('candidate_id', $id)->whereNotIn('interview_id',$assignedInterviewIds)->delete();

            /////////////////////
            $title = env('APP_NAME');
            $content = "Welcome ".$user['name']."! You are invited the " . $title . " interview.";

            sendMail($user['email'], $title, $content);
            /////////////////////////////
            foreach($assignedInterviewIds as $it){
                $row = InterviewCandidate::firstOrNew(['interview_id'=>$it, 'candidate_id'=>$id]);
                $row->save();
            }
        }
        
        return redirect('admin/candidate');
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
    
    public function bulkadd(Request $request){
        if($request->hasFile('bulkadd')&&$request->file('bulkadd')->isValid()){
            $csv = @array_map('str_getcsv', file($request->bulkadd->path()));
            if(empty($csv)){
                die('<script>top.bulkResult("Invalid template!")</script>');
            }
            
            $count = 0;
            $bads = [];
            $status = 'ok';
            
            foreach($csv as $i=>$f){
                filter_var($f);
                if($i==0 || empty($f) || count($f)<3) continue;
                
                if(!filter_var($f[2],FILTER_VALIDATE_EMAIL)){
                    $bads[] = 'Incorrect email (' . $f[2] . ')';
                    $status = 'error';
                    continue;
                }
                
                if(DB::table('users')->where('email',$f[2])->count()){
                    $bads[] = 'Exists aleady (' . $f[2] . ')';
                    $status = 'error';
                    continue;
                }
                
                $password = ($f[3]);
                
                $userId = DB::table('users')->insertGetId([
                    'name' => $f[1],
                    'email' => $f[2],
                    'phone' => $f[3],
                    'password' => Hash::make($password),
                    'summary' => @$f[4],
                    'created_at' => now(),
                    'updated_at' => now(),
                    'isadmin' => 0,
                ]);
                
                if($request->input('interview_id')){
                    
                    DB::table('interview_candidate')->insert(['interview_id'=>$request->input('interview_id'), 'candidate_id'=>$userId]);
                }
                
                $count++;
                
                $user = ['email' => $f[2],'name' => $f[1]];
                
                /////////////////////
                $setPassword = base64_encode($user['email']);
                $title = env('APP_NAME');
                $content = "Hello, ".$user['name']."! Your password is " . $setPassword;

                sendMail($user['email'], $title, $content);
                /////////////////////////////
            }
            
            $msg = !$count
                    ?('Occurred some errors<br>'.implode('<br>', $bads))
                    :($count.' candidates imported successfully!');
            
            die('<script>top.bulkResult("'.($msg).'")</script>');
        }
        
        die('<script>top.bulkResult("Failed upload!")</script>');
    }
    
    public function assignInterview(Request $request){
        $interviewId = $request->interviewId;
        $assessorId = $request->assessorId;
        
        InterviewAssessor::firstOrNew(['interview_id'=>$interviewId, 'assessor_id'=>$assessorId])->save();
        
        foreach($request->candidateIds as $cid){
            InterviewCandidate::where(['interview_id'=>$interviewId, 'candidate_id'=>$cid])->delete();
            InterviewCandidate::insert(['interview_id'=>$interviewId, 'candidate_id'=>$cid, 'assessor_id'=>$assessorId]);
            
            /////////////////////
            $user = DB::table('users')->where('id',$cid)->first();
            $interviewN = DB::table('interview')->where('id',$interviewId)->value('name');
            $title = env('APP_NAME');
            $content = "Welcome ".$user->name."! You are invited the " . $interviewN . " interview.";

            sendMail($user->email, $title, $content);
            /////////////////////////////
        }
        die;
    }
    
    public function uploadcv(Request $request){
        if (isset($_FILES['cv-file'])&&!$_FILES['cv-file']['error']) {
            $ext = strtolower(pathinfo($_FILES['cv-file']['name'])['extension']);
            $file = 'app/cv/'.uniqid().'.'.$ext;
            $savePath = public_path().'/'.$file;
            
            if(!is_dir(dirname($savePath))){
                @mkdir(dirname($savePath));
                @chmod(dirname($savePath), 0777);
            }
            
            @chmod(dirname($savePath), 0777);
            @unlink($savePath);
            @rename($_FILES['cv-file']['tmp_name'], $savePath);
            DB::table('users')
                    ->where('id', $request->input('candidate_id'))
                    ->update(['cv'=>$file]);
            die('<script>top.alert("CV saved!");top.location.reload();</script>');
        }
    }
    
    public function assessors($interviewId, Request $request){
        if(!$interviewId)echo '[]';
        $assessorIds = Interview::find($interviewId)->assessors->pluck('assessor_id');
        $assessorIds[]=-1;
        $assessors = User::find($assessorIds)->toArray();
        echo json_encode($assessors);
    }
    
    public function downcsv(Request $request){
        $ids = explode(',', $request->input('ids','-1'));
        
        $select = DB::table('users as a')
                ->leftJoin('interview_candidate as b', 'b.candidate_id','=','a.id')
                ->where('isadmin',0)
                ->whereIn('a.id', $ids)
                ->groupBy('a.id')
                ;
        
        $filename = "Candidates.csv";
        @unlink($filename);
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('S.No', 'Name', 'E-mail', 'Phone'));

        foreach($select->get() as $i=>$row) {
            fputcsv($handle, array($i+1, $row->name, $row->email, $row->phone));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download(public_path().'/'. $filename, $filename, $headers);
    }
}
