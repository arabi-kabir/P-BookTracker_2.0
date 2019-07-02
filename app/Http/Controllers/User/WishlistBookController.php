<?php

namespace App\Http\Controllers\User;

use App\CompleteBook;
use App\WishListBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class WishlistBookController extends Controller
{
    // CHANGE COMPLETE STATUS
    public function changeWishlistStatus(Request $r){

        if($r->value == 'unwish')
        {
            $wishlistBook = new WishListBook();
            $wishlistBook->fk_book_id = $r->book_id;
            $wishlistBook->fk_user_id = Auth::user()->id;
            $wishlistBook->wishlist_added_date = date("Y-m-d");
            $wishlistBook->save();

            return back();
        }
        else
        {
            WishListBook::where('fk_book_id', $r->book_id)
                ->where('fk_user_id', Auth::user()->id)
                ->first()
                ->delete();

            return back();
        }
    }

    // CHECK IF BOOK IS IN COMPLETED LIST
    public function checkWishlistStatus(Request $r){
        $wishlistStatus = WishListBook::where('fk_book_id', $r->book_id)
            ->where('fk_user_id', Auth::user()->id)
            ->first();

        if($wishlistStatus)
        {
            return "wish";
        }
    }

    public function showWishlistBooks(){
        $wishlistBooks = WishListBook::leftJoin('book', 'book.book_id', 'wishlist_books.fk_book_id')
            ->leftJoin('book_author', 'book_author.author_id', 'book.fk_book_author_id')
            ->leftJoin('book_category', 'book_category.category_id', 'book.fk_book_category_id')
            ->where('wishlist_books.fk_user_id', Auth::user()->id)
            ->get();

        return view('MyView.User.ReadBook.WishlistBook.wishlistBookList')->with('wishlistBooks',$wishlistBooks);
    }

    public function chage2wishlist(Request $r){

        $completeList = CompleteBook::where('fk_book_id', $r->book_id)
            ->where('fk_user_id', Auth::user()->id)
            ->first();

        if($completeList)
        {
            Session::flash('error_message', 'This book is already in your complete list!');
        }
        else
        {
            // FIRST DELETE FROM WISHLIST
            WishListBook::where('fk_book_id', $r->book_id)
                ->where('fk_user_id', Auth::user()->id)
                ->first()
                ->delete();

            // THEN ADD TO WISHLIST
            $completeBook = new CompleteBook();
            $completeBook->fk_book_id = $r->book_id;
            $completeBook->fk_user_id = Auth::user()->id;
            $completeBook->save();

            Session::flash('success_message', 'Added to complete list!');

            return back();
        }
    }
}
