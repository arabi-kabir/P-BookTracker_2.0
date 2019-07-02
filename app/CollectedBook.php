<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectedBook extends Model
{
    protected $table='collected_books';
    protected $primaryKey='collected_books_id';
    public $timestamps=false;
}
