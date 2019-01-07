<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\AgentMail;
use App\Http\Controllers\Controller;
use App\User;

class InterviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        $ds = getInterviewPageSearchDate($request);
        
        $assessors = [];
        $candidates = [];
        foreach(DB::table('users')->get() as $u){
            if($u->isadmin==0){
                $candidates[$u->id] = $u;
            }
            if($u->isadmin==2){
                $assessors[$u->id] = $u;
            }
        }
        $re = DB::table('interview as a')
                ->select('a.*', 
                        DB::raw('count(distinct b.id) as ac'), 
                        DB::raw('group_concat(distinct b.assessor_id) as ass'), 
                        DB::raw('count(distinct c.candidate_id) as cc'),
                        DB::raw('group_concat(distinct c.candidate_id) as cids'))
                ->leftJoin('interview_assessor as b','b.interview_id', '=', 'a.id')
                ->leftJoin('interview_candidate as c','c.interview_id', '=', 'a.id')
                ->whereRaw(DB::raw('date(a.ctt) between date("'.$ds[0].'") and date("'.$ds[1].'")'))
                ->groupBy('a.id')
                ->orderBy('a.id', 'desc')
                ->get();
        foreach($re as &$r){
            $r->assessorListTxt = implode(', ', User::whereIn('id', $r->ass?explode(',', $r->ass):[-1])->pluck('name')->toArray());
            $r->candidateListTxt = implode(', ', User::whereIn('id', $r->cids?explode(',', $r->cids):[-1])->pluck('name')->toArray());
        }
        
        return view('interview.index',['pageName'=>'interview', 'interviewList'=>$re, 'assessors'=>$assessors, 'candidates'=>$candidates, 'searchDateRange'=>$ds]);
    }
    
    public function saveInterview(Request $request){
        if($request->input('interview_id')){
            $id = $request->input('interview_id');
            DB::table('interview')
                    ->where('id', $id)
                    ->update([
                        'name' => $request->input('name'),
                        'description' => $request->input('description'),
                        'ctt' => ($request->input('ctt')),
                        'att' => ($request->input('att')),
                        'change_date' => now(),
                        'change_user' => 'admin',
                    ]);
        }else{
            $id = DB::table('interview')->insertGetId([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'change_date' => now(),
                'ctt' => ($request->input('ctt')),
                'att' => ($request->input('att')),
                'change_user' => 'admin',
                'active_status' => 1,
            ]);
        }
        
        if ($request->hasFile('preview_image')) {
            if($request->input('interview_id')){
                $oldImage = DB::table('interview')->where('id', $id)->value('preview_image');
                if($oldImage){
                    @unlink($oldImage);
                }
            }
            
            $savePath = $request->preview_image->store('app/interview_image');
            @unlink($savePath);
            @chmod(dirname($savePath), 0777);
            @rename($request->preview_image->path(), $savePath);
            DB::table('interview')->where('id', $id)->update(['preview_image'=>$savePath]);
        }
        
        DB::table('interview_assessor')->where('interview_id', $id)->delete();
        foreach($request->input('assessor', []) as $a){
            if(empty($a))continue;
            DB::table('interview_assessor')->insert(['interview_id'=>$id, 'assessor_id'=>$a]);
        }
        
        return redirect('admin/interview')->with('success', 'Interview ' . ($request->input('interview_id')?'Updated':'Created'));
    }
    
    public function deleteInterview(Request $request){
        $id = $request->input('id');
        $oldImage = DB::table('interview')->where('id', $id)->value('preview_image');
        if($oldImage){
            @unlink($oldImage);
        }
        DB::table('interview')->where('id', $id)->delete();
        die('ok');
    }
    
    public function toggle(Request $request){
        $id = $request->input('it');
        $active = DB::table('interview')->where('id', $id)->value('active_status');
        DB::table('interview')->where('id', $id)->update(['active_status'=>$active?0:1]);
        return redirect('admin/interview');
    }
    
}
