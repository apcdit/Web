<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class uniDetails extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'id','uniNameCN','debateQues1','debateQues2','debateQues3','simTimeStart',
        'simTimeEnd','simTimeDiff','simTimePress', 'offTimePress', 'offTimeStart','offTimeEnd','offTimeDiff','drawn','qualified'
    ];

    public function User(){
        return $this->belongsTo('App\User','uniNameCN','uniNameCN');
    }
}
