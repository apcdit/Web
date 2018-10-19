<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    //

    public $fillable = [
        'postTitle', 'postPic', 'postDec', 'postContent', 'created_at','updated_at'
    ];
}
