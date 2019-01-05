<?php

namespace App\Http\Controllers;

use App\uniDetails;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WarController extends Controller
{

    //param = region, offStartTime, offEndTime, offPressTime
    public function setOffTime(){

        $users = User::where('region', request('region'))->get(); //get the collection that has the same region

        $offTimeStart = doubleval(strtotime(request('offTimeStart').' '.'Asia/Singapore'))*1000000;
        $offTimeEnd = doubleval(strtotime(request('offTimeEnd').' '.'Asia/Singapore'))*1000000;


        if(count($users) > 0){ //check if there's user in the region
            for($i = 0; $i < count($users); $i++){ //if yes set all the user in that region to same time
                //$uniDetails = $users[$i]->uniDetails;
                $uniNameCN = $users[$i]->uniNameCN;
                // $uniDetails->update([
                //     'offTimeStart' => $offTimeStart,
                //     'offTimeEnd' => $offTimeEnd,
                // ]);
                DB::table('uni_details')
                    ->where('uniNameCN', $uniNameCN)
                    ->update([
                        'offTimeStart' => $offTimeStart,
                        'offTimeEnd' =>$offTimeEnd
                    ]);
            }
            return response()->json([
                'message' => 'Official Start time is updated to '.request('offTimeStart'),
                'offTimeStart' => $offTimeStart,
                'offTimeEnd' => $offTimeEnd,
                'status' => 200
            ]);
        }else{
            return response()->json([
                'message' => 'Not found',
                'status' => 200
            ]);
        }
    }

    public function reset(){
        $region = request('region');
        //$user = User::where('region', $region)->with('uniDetails')->get();
        $start = microtime(true);
        // for($i = 0; $i < count($user); $i++){
        //     $user[$i]->uniDetails->update([
        //         'offTimePress' => doubleval(999999999999999999),
        //         'drawn' => 0,
        //         'offTimeDiff' => doubleval(999999999999999999)
        //     ]);
        // }
        uniDetails::where('region',$region)->update([
            'offTimePress' => doubleval(999999999999999999),
            'drawn' => 0,
            'offTimeDiff' => doubleval(999999999999999999)
        ]);
        $end = microtime(true);
        $diff1 = $end-$start;
        $diff = $end-LARAVEL_START-$diff1;
        return response()->json([
            'message' => 'Users with the region '.$region.' is resetted',
            'diff1' => $diff1,
            'diff' => $diff
        ]);
    }
    //for simulation
    public function setSimTime(){


        //$users = User::where('region', request('region'))->get(); //get the collection that has the same region
        $user = auth()->user();
        //strtotime normally converts to epoch in UTC timezone, by using 'Asia/Singapore' it converts it to GMT+8
        $simTimeStart = strtotime(request('simTimeStart').' '.'Asia/Singapore');
        $simTimeEnd = strtotime(request('simTimeEnd').' '.'Asia/Singapore');

        if(count($user) > 0){
            for($i = 0; $i < count($user); $i++){
                $uniDetails = $user[$i]->uniDetails;
                $uniDetails->update([
                    'simTimeStart' => $simTimeStart*1000,
                    'simTimeEnd' => $simTimeEnd,
                ]);
            }
            return response()->json([
                'message' => 'Simulate Start time is updated to '.request('simTimeStart'),
                'simTimeStart' => $simTimeStart,
                'simTimeEnd' => $simTimeEnd,
                'status' => 200
            ]);
        }else{
            return response()->json([
                'message' => 'Not found',
                'status' => 200
            ]);
        }
    }

    private function  calOffTimeDiff($uniNameCN){

        $uniDetails = uniDetails::where('uniNameCN', $uniNameCN)->first();

        if($uniDetails->offTimeStart !== null && $uniDetails->offTimePress !== null){
            $offTimeDiff = $uniDetails->offTimePress-($uniDetails->offTimeStart);
            $uniDetails->update([
                'offTimeDiff' => $offTimeDiff  //units in milliseconds
            ]);
        }
    }

    private function  calSimTimeDiff($uniNameCN){

        $uniDetails = uniDetails::where('uniNameCN', $uniNameCN)->first();

        if($uniDetails->simTimeStart !== null && $uniDetails->simTimePress !== null){
            $simTimeDiff = $uniDetails->simTimePress-($uniDetails->simTimeStart);
            $uniDetails->update([
                'simTimeDiff' => $simTimeDiff  //units in milliseconds
            ]);
        }
    }

    public function storeSimTimePress(){

        if(auth()->user()->uniDetails->drawn !== 1){ //if player hasn't drawn yet then save it into database

            $uniDetails = auth()->user()->uniDetails;
            $pressTime = microtime(true)*1000; //record the user press time in
            $uniNameCN = $uniDetails->uniNameCN;
            $simTimeStart = $uniDetails->simTimeStart;
            $simTimeEnd = $uniDetails->simTimeEnd;
            //$timeNow = request('timeNow');

            if($pressTime >= $simTimeStart && $pressTime < $simTimeEnd){
                if($uniDetails != null && request('pressed') === 1){
                    $uniDetails->update([
                        'simTimePress' => $pressTime,
                        //'drawn' => 1 //set player to drawn but commented bcoz this is for simulation only
                    ]);
                    $this->calSimTimeDiff($uniNameCN);

                    return response()->json([
                        'message' => "Simulate press time is recorded!",
                        'status' => "200",
                        'time' => date("Y-m-d H:i:s", microtime(true)),
                        'epoch' => $pressTime,
                        'converted' => strtotime(date("Y-m-d H:i:s", microtime(true)))
                    ]);
                }else{
                    return response()->json([
                        'message' => 'Uni details not found, fail!',
                        'status' => '404'
                    ]);
                }
            }else{
                return response()->json([
                    'message' => '还没到报名时间！',
                    'status' => 201
                ]);
            }
        }else{
            return response()->json([
                'message' => 'The player has already drawn!',
                'status' => '304'
            ]);
        }
    }


    public function storeOffTimePress(){ //backend
        $user = auth()->user();
        $uniDetails = $user->uniDetails;
        if($uniDetails->drawn == 0){
            switch($user->region){
                case "Singapore": $offTimeStart = 1544434200000000; $offTimeEnd = 1544445000000000; break;
                case "Malaysia": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
                case "Australia": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
                case "China": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
                case "Hong Kong": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
                case "Taiwan": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
                case "Macau": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
                case "Others": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
                case "Admin": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
                default: $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
            };
            $pressTime = microtime(true)*1000000;
            $timeDiff = $pressTime - $offTimeStart;
            if($timeDiff < 0){ //haven't started
                return response()->json([
                    'message' => "系统还未开放！"
                ]);
            }else if($timeDiff > 10800000000){
                return response()->json([
                    'message' => "报名已经结束了！"
                ]);
            }else{
                $uniDetails->update([
                    'offTimePress' => $pressTime,
                    'offTimeDiff' => $timeDiff,
                    'drawn' => 1
                ]);

                return response()->json([
                    'message' => "成功报名！稍后即可查询成绩！"
                ]);
            }
        }else{
            return response()->json([
                'message' => '队伍已经报名了！'
            ]);
        }
    }

    public function getAllTime(){
        $region = ['Malaysia', 'Singapore', 'Australia', 'China', 'Taiwan', 'Hong Kong', 'Macau', 'Others','Admin'];
        $times = [];
        for($i = 0 ; $i < count($region); $i++){
            $array = $this->getStartTime($region[$i]);
            array_push($times, $array);
        }

        return response()->json($times);
    }

    public function getStartTime(String $region){
        $user = User::where('region', $region)->first();
        if($user === null){
            return array($region,0, 0);
        }
        date_default_timezone_set("Asia/Singapore");
        $offTimeStart = date("Y-m-d H:i:s", $user->uniDetails->offTimeStart/1000000);
        $offTimeEnd = date("Y-m-d H:i:s",$user->uniDetails->offTimeEnd/1000000);

        $array = array($region, $offTimeStart,$offTimeEnd);
        return $array;
    }

    public function getOffStartTime(){
        $offTimeStart = auth()->user()->uniDetails->offTimeStart;
        date_default_timezone_set("Asia/Singapore");
        $offTimeStart1 = date("d/m/Y H:i:s", $offTimeStart/1000000)." SGT";
        $offTimeEnd = auth()->user()->uniDetails->offTimeEnd;
        $offTimeEnd = date("d/m/Y H:i:s", $offTimeEnd/1000000)." SGT";

        if($offTimeStart != null){
            return response()->json([
                'status' => 200,
                'offTimeStart' => $offTimeStart1, //proper timezone
                'offTimeEnd' => $offTimeEnd,
            ]);
        }
    }

    public function getDraw(){
        $drawn = auth()->user()->uniDetails->drawn;

        return response()->json([
            'status' => 200,
            'drawn' => $drawn
        ]);
    }

    public function getOffTimeDiff(){

        $region = auth()->user()->region;

        if($region=='Taiwan' or $region=='Hong Kong'){
        $uniDetails = uniDetails::where('region','Taiwan')->orwhere('region','Hong Kong')->orderBy('offTimeDiff','asc')->get(['uniNameCN','offTimePress','offTimeDiff','qualified','region']);
        return response()->json([
            'data' => $uniDetails,
            'region' => $region,
            'time' => microtime(true)-LARAVEL_START
        ]);}
        else{$uniDetails = uniDetails::where('region',$region)->orderBy('offTimeDiff','asc')->get(['uniNameCN','offTimePress','offTimeDiff','qualified','region']);
            return response()->json([
                'data' => $uniDetails,
                'region' => $region,
                'time' => microtime(true)-LARAVEL_START
            ]);}
    }

    public function decideQualified(){ //decide who wins

        $region = request('region');

        //check with yanjin how many teams are there for each region
        switch($region){
            case "Singapore":
            case "Hong Kong":
            case "Malaysia":
            case "China":
            case "Macao":
            case "Taiwan":
            case "Australia":
        }

    }
}
