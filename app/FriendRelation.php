<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendRelation extends Model
{
    protected $table='friend_relation';
    protected $primaryKey='friend_relation_id';
    public $timestamps=false;
}
