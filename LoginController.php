<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\User;
 
class LoginController extends Controller
{
    /**
     * Index login controller
     *
     * When user success login will retrive callback as api_token
     */
    public function index(Request $request)
    {
        try{

        
        $hasher = app()->make('hash');
 
        $id = $request->input('student_Id');
        $password = $request->input('Password');
        $login = User::where('student_Id', $id)->first();

       // $login = Student::where('student_Id', $id)->first();
 
        if ( ! $login) {
            $res['success'] = false;
            $res['message'] = 'Your email or password incorrect!';
            return response($res);
        } else {
            if ($hasher->check($password, $login->Password)) {
                $api_token = sha1(time());
                $create_token = User::where('student_Id', $login->student_Id)->update(['api_token' => $api_token]);
                if ($create_token) {
                    $res['success'] = true;
                    $res['api_token'] = $api_token;
                    $res['message'] = $login;
                    return response($res);
                }
            } else {
                $res['success'] = true;
                $res['message'] = 'You email or password incorrect!';
                return response($res);
            }
        }
    }catch (Exception $e){
        $message = [
            'status' => 'failed'
        ];
        return json_encode($message);
    }
   
    }
}