<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $table='book_category';
    protected $primaryKey='category_id';
    public $timestamps=false;
}
