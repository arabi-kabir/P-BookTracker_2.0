<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishListBook extends Model
{
    protected $table='wishlist_books';
    protected $primaryKey='wishlist_books_id';
    public $timestamps=false;
}
