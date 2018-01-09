<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //  Table name
    protected $table = 'posts';

    //  Primary key
    public $primaryKey = 'id';

    //  Timestamps (true by default)
    public $timestamps = true;

    //  Tie Post-model to User-model so that Post has a owner (user).
    public function user() {
        return $this->belongsTo('App\User');
    }
}
