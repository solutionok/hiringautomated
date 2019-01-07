<?php

function checkInterviewDeadline($interview, $isCandidate = true){
    
    if($isCandidate){
        $f = strtotime($interview->ctf);
        $t = strtotime($interview->ctt);
        $now = strtotime('now');
        
        if(!$f && !$t){
            return 1;
        }else if(!$f && !$t){
            return 1;
        }
    }
}

function getInterviewPageSearchDate($request){
    $ds = [date('Y-m-d', strtotime('-2 months')), date('Y-m-d', strtotime('+1 months'))];
    $settingName = 'admin_interview_page_search_date';
    if(empty($request->input('startd', false)) && empty($request->input('endd', false))){
        $dds = DB::table('settings')->where('setting_name', $settingName)->value('setting_value');
        if($dds){
            $ds = explode(',', $dds);
        }
    }else{
        $ds = [$request->input('startd',''), $request->input('endd','')];
        $row = ['setting_name'=>$settingName, 'setting_value'=>implode(',', $ds)];
        
        if(DB::table('settings')->where('setting_name', $settingName)->count()){
            DB::table('settings')->where('setting_name', $settingName)->update($row);
        }else{
            DB::table('settings')->insert($row);
        }
    }
    return $ds;
}

function getReviewPageSearchDate($request){
    $ds = [date('Y-m-d', strtotime('-1 months')), date('Y-m-d', strtotime('now'))];
    $settingName = 'review_page_search_date_'.auth()->user()->id;
    if(empty($request->input('startd', false)) && empty($request->input('endd', false))){
        $dds = DB::table('settings')->where('setting_name', $settingName)->value('setting_value');
        if($dds){
            $ds = explode(',', $dds);
        }
    }else{
        $ds = [$request->input('startd',''), $request->input('endd','')];
        $row = ['setting_name'=>$settingName, 'setting_value'=>implode(',', $ds)];
        
        if(DB::table('settings')->where('setting_name', $settingName)->count()){
            DB::table('settings')->where('setting_name', $settingName)->update($row);
        }else{
            DB::table('settings')->insert($row);
        }
    }
    return $ds;
}

function getAssesorNames($ids, $ass, $getAll = false){
    if(empty($ids)||empty($ass)){
        return '';
    }
    
    $re = [];
    foreach(explode(',', $ids) as $id){
        $re[] = $ass[$id]->name;
    }
    
    if($getAll){
        return implode(', ', $re);
    }else{
        return count($re)>1 ? ($re[0].' and ' . (count($re)-1) . ' peoples') : $re[0];
    }
}

function deadlineCheck($deadline){
    return strtotime($deadline.' 23:59:59')>=strtotime('now');
}

function _df_($e){
    if(!$e)return '';
    $e = explode('/', $e);
    return sprintf('%04d-%02d-%02d', $e[2], $e[1], $e[0]);
}

function sendMail($to, $title, $content){
    try{
        Mail::send('emailtmp', ['title' => $title, 'content' => $content], function ($message) use ($to)
        {

            $message->from(env('MAIL_USERNAME'), env('APP_NAME'));

            $message->to($to);

        });
        return true;
    }catch(Exception $e){
        return false;
    }
}