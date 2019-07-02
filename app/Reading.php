<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    protected $table='reading_books';
    protected $primaryKey='reading_books_id';
    public $timestamps=false;
}
