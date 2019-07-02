<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LendBook extends Model
{
    protected $table='lend_book';
    protected $primaryKey='lend_book_id';
    public $timestamps=false;
}
