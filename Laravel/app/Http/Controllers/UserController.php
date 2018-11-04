<?php

namespace App\Http\Controllers;

use App\uniDetails;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function updateDetails(Request $request){

        $user = User::where('uniNameCN', $request->uni_name_cn)->first();
        $uniDetails = uniDetails::where('uniNameCN', $request->uni_name_en)->first(); //returns a collection
        //0 because update method requires object, not collection
        $user->update([
            'address' => request('address'),
            'email' => request('email'),
            'contactNumber' => request('phone')
        ]);

        $uniDetails->update([
            'debateQues1' => request('debateQues1'),
            'debateQues2' => request('debateQues2'),
            'debateQues3' => request('debateQues3'),
        ]);

        return response(uniDetails::where('uniNameCN', $request->uniNameCN)->get(),200);
    }

    public function createDetails(Request $request){
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

        return response()->json($uni,200);
    }


}
