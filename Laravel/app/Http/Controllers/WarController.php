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
        $user = User::where('region', $region)->get();
        for($i = 0; $i < count($user); $i++){
            $user[$i]->uniDetails->update([
                'offTimePress' => doubleval(999999999999999999),
                'drawn' => 0,
                'offTimeDiff' => doubleval(999999999999999999)
            ]);
        }
        return response()->json([
            'message' => 'Users with the region '.$region.' is resetted'
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

        if(auth()->user()->uniDetails->drawn !== 1){ //if player hasn't drawn yet then save it into database

            $uniDetails = auth()->user()->uniDetails;
            $pressTime = microtime(true)*1000; //record the user press time in
            $uniNameCN = $uniDetails->uniNameCN;
            $offTimeStart = $uniDetails->offTimeStart;
            $offTimeEnd = $uniDetails->offTimeEnd;
            $timeDiffed = $uniDetails->offTimeDiff; //will be 999999999999 in the first press
            $timeDiff = $pressTime - $offTimeStart; //incoming new time
            //$timeNow = request('timeNow');

            if($timeDiff > $timeDiffed){ //first try must be smaller than 9999999999
                return response()->json([
                    'message' => '已经按过了!'
                ]);
            }
            
            if($pressTime >= $offTimeStart){
                if($pressTime < $offTimeEnd){
                    if($uniDetails != null && request('pressed') === 1){
                        $uniDetails->offTimeDiff = $timeDiff;
                        $uniDetails->drawn = 1;
                        $uniDetails->save();
                        // $uniDetails->update([
                        //     'offTimePress' => $pressTime,
                        //     'drawn' => 1 //set player to drawn but commented bcoz this is for simulation only
                        // ]);
                        //$this->calOffTimeDiff($uniNameCN);
    
                        return response()->json([
                            'message' => "Official press time is recorded!",
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
                        'message' => '报名已截止！'
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

        if($offTimeStart != null){
            return response()->json([
                'status' => 200,
                'offTimeStart' => $offTimeStart1, //proper timezone
                'offTimeStart2' => $offTimeStart //epoch
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

        $array = [];

        $uniNameCNs = User::where('region',$region)->pluck('uniNameCN');

        //get all the uni details with only the 3 details
        $filteredDetails = uniDetails::get()->map(function($b){
            return collect($b->toArray())
                ->only(['uniNameCN', 'offTimeDiff', 'qualified'])
                ->all();
        });

        //filter with the region i want
        for($i = 0; $i < count($uniNameCNs); $i++){
            for($j = 0; $j < count($filteredDetails); $j++){
                if($uniNameCNs[$i] === $filteredDetails[$j]["uniNameCN"]){
                    array_push($array, $filteredDetails[$j]);
                }
            }
        }

        for($k = 0 ; $k < count($array); $k++){
            $timeDiff = $array[$k]["offTimeDiff"];
            $array[$k]["offTimeDiff"] = $timeDiff; //get the time in microsecond// /1000; //to get the time in second
        }

        return response()->json([
            'data' => $array,
            'region' => $region
        ]);
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
