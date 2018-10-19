<?php

namespace App\Http\Controllers;

use App\uniDetails;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use phpseclib\Crypt\Hash;



class AuthController extends Controller
{
    //

    function showRegistration(){
        return view('register.create');
    }

    function createUser(Request $request){

        $user = null;

        $this->validate(request(),[
            'uniNameCN' => 'required',
            'uniNameEN' => 'required',
            'region' => 'required',
            'nameEn' => 'required',
            'nameCn' => 'required',
            'address' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'contactNumber' => 'required'
        ]);

        try{
            $user = User::create([
                'uniNameCN' => request('uniNameCN'),
                'uniNameEN' => request('uniNameEN'),
                'region' => request('region'),
                'nameEn' => request('nameEn'),
                'nameCn' => request('nameCn'),
                'address' => request('address'),
                'password' => bcrypt(request('password')),
                'email' => request('email'),
                'contactNumber' => request('contactNumber')
            ]);

            $uni = uniDetails::create([
                'uniNameCN' => request('uniNameCN'),
                'debateQues1' => null,
                'debateQues2' => null,
                'debateQues3' => null,
                'simTimeStart' => null,
                'simTimeEnd' => null,
                'simTimeDiff' => null,
                'offTimeStart' => null,
                'offTimeEnd' => null,
                'offTimeDiff' => null,
                'drawn' => 0,
                'qualified' => 0
            ]);
        }catch(\Exception $exception){ //this part is to catch uniDetails error
            //if user is created but error found in uniDetails, delete the created user to avoid errors
            if($user != null){
                User::destroy('uniNameCN', request('uniNameCN'));
            }
            return response()->json([
                'status' => 201,
                'message' => "Duplicate Entry!"
            ]);
        }




        return response()->json([
            'status' => 201,
            'message' => 'Successfully registered!',
            'user' => $user,
            'uni' => $uni,
        ]);
    }


    function showLogin(){
        return view('login.create');
    }

    function doLogin(Request $request)
    {

        $user = User::where('email',$request->input('username',$request->input('email')))->first();

        if(!$user){
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422
            ], 422);
        }

//        if($user->password != Hash::make(request('password'))){
//        return response()->json([
//            'message' => 'Wrong email or password',
//            'status' => 422
//        ], 422);
//    }

        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        //params for oauth api call
        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $user->email,
            'password' => request('password'),
        ];

        //internal api call
        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);

        if ($response->getStatusCode() != 200) {
            return $response;
        }

        $data = json_decode($response->getContent());


        return response()->json([
            'token' => $data->access_token,
            'user' => $user,
            'status' => 200,
        ]);
    }

    function logout(){
        $accessToken = auth()->user()->token();

        //stop refreshing the accesstoken
        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        return response()->json([
            'message' => "Logged out successfully",
            'status' => 200
        ]);
    }
}
