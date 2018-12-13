<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use App\PasswordReset;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        
        $this->validate(request(),[
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first(); //look for the user with the email

        if (!$user)
            return response()->json([
                'message' => "We can't find a user with that e-mail address."
            ], 404);

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(6)
             ]
        );
        // if ($user && $passwordReset)
        //     $user->notify(
        //         new PasswordResetRequest($passwordReset->token)
        //     );
        return response()->json([
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();

        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);

        if (Carbon::parse($passwordReset->created_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        }

        return response()->json($passwordReset);
    }
     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $this->validate(request(),[
            'email' => 'required|string|email',
            'password' => 'required|string',
            'token' => 'required|string'
        ]);

        $passwordReset = PasswordReset::where([ //check if email and token matches
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset) //if nothing returned means unmatch
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);

        $user = User::where('email', $passwordReset->email)->first(); //otherwise get the user

        if (!$user)
            return response()->json([
                'message' => 'We can\'t find a user with that e-mail address.'
            ], 404);

        $user->password = bcrypt($request->password); //update the password 
        $user->save();
        $passwordReset->delete();
        //$user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json([
            'message' => 'Password has been resetted!'
        ]);
    }

    public function change(Request $request){
        $this->validate(request(),[
            'email' => 'required|string|email',
            'password' => 'required|string',
            'old_password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'message' => '无法搜索到对应账号，请确认正确的邮件已被输入。'
            ],404);
        }

        if(Hash::check($request->old_password, $user->password)){
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                'message' => '密码成功更换!'
            ],200);
        }else{
            return response()->json([
                'message' => '输入了错误的旧密码!'
            ],404);
        }
    }
}