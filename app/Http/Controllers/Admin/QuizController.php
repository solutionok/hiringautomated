<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
class QuizController extends Controller
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
        $interview = DB::table('interview')->where('id', $request->input('it'))->first();
        $re = DB::table('quiz')->where('interview_id', $request->input('it'))->orderBy('order_val')->get();
        return view('quiz.index',['pageName'=>'interview', 'quizList'=>$re, 'interview'=>$interview, 'qtypes'=>self::$quizTypes]);
    }
    
    public function saveQuiz(Request $request){
        function m2s($m){
            return strtotime("1970-01-01 00:$m UTC");
        }
        
        $data = [
                    'interview_id' => $request->input('it'),
                    'description' => $request->input('description'),
                    'qtype' => $request->input('qtype'),
                    'grade' => $request->input('grade'),
                    'qprepare' => m2s($request->input('qprepare')),
                    'qtime' => m2s($request->input('qtime')),
                ];
        
        if(intval($data['qprepare'])<3){
            $data['qprepare']=0;
        }
        
        if($request->input('qdetail')){
            $data['qdetail'] = $request->input('qdetail');
        }

        if($request->input('quiz_id')){
            $id = $request->input('quiz_id');
            DB::table('quiz')
                    ->where('id', $id)
                    ->update($data);
        }else{
            $data['order_val'] = intval(DB::table('quiz')->where('interview_id', $request->input('it'))->max('order_val'))+1;
            $id = DB::table('quiz')->insertGetId($data);
        }
        
        if ($request->hasFile('attach_media')) {
            if($request->input('quiz_id')){
                $oldImage = DB::table('quiz')->where('id', $id)->value('attach_media');
                if($oldImage){
                    @unlink($oldImage);
                }
            }
            $ext = strtolower(pathinfo($request->attach_media->getClientOriginalName())['extension']);
            $savePath = $request->attach_media->storeAs('app/quiz_media', uniqid().'.'.$ext);
            @chmod(dirname($savePath), 0777);
            @unlink($savePath);
            @rename($request->attach_media->path(), $savePath);
            DB::table('quiz')->where('id', $id)->update(['attach_media'=>$savePath]);
        }
        
        return redirect('admin/quiz?it='.$request->input('it'));
    }
    
    public function getQuiz($quizid){
        return (array) DB::table('quiz')->where('id', $quizid)->first(); 
    }
    
    public function deleteQuiz(Request $request){
        $id = $request->input('id');
        $attachMedia = DB::table('quiz')->where('id', $id)->value('attach_media');
        if($attachMedia){
            @unlink($attachMedia);
        }
        DB::table('quiz')->where('id', $id)->delete();
        die('ok');
    }
    
    public function moveq($id,  Request $request){
        $moveArrow = $id>0 ? -1 : 1;
        $id = abs($id);
        
        $question = Quiz::find($id);
        
        $questionList = Quiz::where('interview_id', $question->interview_id)->orderBy('order_val')->get();
        
        foreach($questionList as $i=>$q){
            $q->order_val = $i+1;
            $q->save();
        }
        
        if(($moveArrow>0&&$question->order_val == count($questionList)) || ($moveArrow<0&&$question->order_val == 1)){
            return redirect()->back();
        }
        
        $questionList = Quiz::where('interview_id', $question->interview_id)->orderBy('order_val')->get();
        
        $question = Quiz::find($id);
        $swap = $questionList[$moveArrow>0 ? $question->order_val : ($question->order_val-2)];
        
        $swap->order_val = $moveArrow>0 ? ($swap->order_val-1) : ($swap->order_val+1);
        $question->order_val = $moveArrow>0 ? ($question->order_val+1) : ($question->order_val-1);
        
        $swap->save();
        $question->save();
        
        return redirect()->back();
    }
}
