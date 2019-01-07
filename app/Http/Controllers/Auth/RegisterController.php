<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $employee_history = [];
        $education_history = [];
        $skill_grade = [];
        
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
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'isadmin' => 0,
            'summary' => $data['summary'],
            'employee_history' => json_encode($employee_history),
            'education_history' => json_encode($education_history),
            'skill_grade' => json_encode($skill_grade),
        ];
        
        
        if (isset($_FILES['photo'])&&!$_FILES['photo']['error']) {
            $ext = strtolower(pathinfo($_FILES['photo']['name'])['extension']);
            $file = '/app/candidate/'.uniqid().'.'.$ext;
            $savePath = public_path().$file;
            @chmod(dirname($savePath), 0777);
            @unlink($savePath);
            rename($_FILES['photo']['tmp_name'], $savePath);
            $user['photo'] = $file;
        }
        return User::create($user);
    }

    public function mailchk($email){
        $count = DB::table('users')->where('email', $email)->count();
        return $count?'exists':'ok';
    }
    
}
