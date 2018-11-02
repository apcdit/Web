<?php

namespace App\Http\Controllers;

use App\uniDetails;
use App\User;
use Illuminate\Http\Request;

class WarController extends Controller
{
    //
    //param = region, offStartTime, offEndTime, offPressTime
    public function setOffTime(){

        $users = User::where('region', request('region'))->get(); //get the collection that has the same region

        $offTimeStart = strtotime(request('offTimeStart').' '.'Asia/Singapore');
        $offTimeEnd = strtotime(request('offTimeEnd').' '.'Asia/Singapore');

        if(count($users) > 0){ //check if there's user in the region
            for($i = 0; $i < count($users); $i++){ //if yes set all the user in that region to same time
                $uniDetails = $users[$i]->uniDetails;
                $uniDetails->update([
                    'offTimeStart' => $offTimeStart,
                    'offTimeEnd' => $offTimeEnd,
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

    //for simulation
    public function setSimTime(){

        
        $users = User::where('region', request('region'))->get(); //get the collection that has the same region

        //strtotime normally converts to epoch in UTC timezone, by using 'Asia/Singapore' it converts it to GMT+8 
        $simTimeStart = strtotime(request('simTimeStart').' '.'Asia/Singapore');
        $simTimeEnd = strtotime(request('simTimeEnd').' '.'Asia/Singapore');

        if(count($users) > 0){
            for($i = 0; $i < count($users); $i++){
                $uniDetails = $users[$i]->uniDetails;
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
                'message' => 'The player has already drawn!',
                'status' => '304'
            ]);
        }

    }

    public function getSimStartTime(){
        $simTimeStart = auth()->user()->uniDetails->simTimeStart;
        $simTimeStart = date("Y-m-d H:i:s", $simTimeStart/1000).' '.'Asia/Singapore';

        if($simTimeStart != null){
            return response()->json([
                'status' => 200,
                'simTimeStart' => $simTimeStart,
            ]);
        }
    }
    //show all the timediff for a certain region
    public function getSimTimeDiff(){

        $region = auth()->user()->region;

        $array = [];

        $uniNameCNs = User::where('region',$region)->pluck('uniNameCN');

        //get all the uni details with only the 3 details
        $filteredDetails = uniDetails::get()->map(function($b){
            return collect($b->toArray())
                ->only(['uniNameCN', 'simTimeDiff', 'qualified'])
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
            $timeDiff = $array[$k]["simTimeDiff"];
            $array[$k]["simTimeDiff"] = $timeDiff/1000; //to get the time in second
        }

        return response()->json([
            'data' => $array,
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
