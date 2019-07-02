<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompleteBook extends Model
{
    protected $table='complete_books';
    protected $primaryKey='complete_books_id';
    public $timestamps=false;
}
