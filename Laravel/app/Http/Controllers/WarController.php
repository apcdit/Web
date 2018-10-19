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

        if(count($users) > 0){ //check if there's user in the region
            for($i = 0; $i < count($users); $i++){ //if yes set all the user in that region to same time
                $uniDetails = $users[$i]->uniDetails;
                $uniDetails->update([
                    'offTimeStart' => request('offTimeStart'),
                    'offTimeEnd' => request('offTimeEnd'),
                ]);
            }
            return response()->json([
                'message' => 'Official Start time is updated to '.request('offTimeStart'),
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

        if(count($users) > 0){
            for($i = 0; $i < count($users); $i++){
                $uniDetails = $users[$i]->uniDetails;
                $uniDetails->update([
                    'simTimeStart' => request('simTimeStart'),
                    'simTimeEnd' => request('simTimeEnd'),
                ]);
            }
            return response()->json([
                'message' => 'Simulate Start time is updated to '.request('offTimeStart'),
                'status' => 200
            ]);
        }else{
            return response()->json([
                'message' => 'Not found',
                'status' => 200
            ]);
        }
    }

    //am i calculating all of them at once? or should I just calculate one
    private function  calSimTimeDiff($uniNameCN){

        $uniDetails = uniDetails::where('uniNameCN', $uniNameCN)->first();

        if($uniDetails->simTimeStart !== null && $uniDetails->simTimePress !== null){
            $simTimeDiff = $uniDetails->simTimePress-($uniDetails->simTimeStart)*1000;
            //$simTimeDiff = date("Y-m-d H:i:s", $simTimeDiff);
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
                    'drawn' => 1 //set player to drawn
                ]);
                $this->calSimTimeDiff($uniNameCN);

                return response()->json([
                    'message' => "Simulate press time is recorded!",
                    'status' => "200",
                    'time' => $pressTime
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


    }
}
