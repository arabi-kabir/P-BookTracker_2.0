<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table='book_author';
    protected $primaryKey='author_id';
    public $timestamps=false;
}
