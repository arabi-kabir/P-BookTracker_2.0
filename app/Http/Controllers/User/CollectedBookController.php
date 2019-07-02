<?php

namespace App\Http\Controllers\User;

use App\CollectedBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class CollectedBookController extends Controller
{
    // CHANGE COMPLETE STATUS
    public function changeCollectedStatus(Request $r){

        if($r->value == 'uncollected')
        {
            $collectedBook = new CollectedBook();
            $collectedBook->fk_book_id = $r->book_id;
            $collectedBook->fk_user_id = Auth::user()->id;
            $collectedBook->availability = 1;
            $collectedBook->save();

            return back();
        }
        else
        {
            CollectedBook::where('fk_book_id', $r->book_id)
                ->where('fk_user_id', Auth::user()->id)
                ->first()
                ->delete();

            return back();
        }
    }

    // CHECK IF BOOK IS IN COLLECTED LIST
    public function checkCollectedStatus(Request $r){
        $collectedStatus = CollectedBook::where('fk_book_id', $r->book_id)
            ->where('fk_user_id', Auth::user()->id)
            ->first();

        if($collectedStatus)
        {
            return "collected";
        }
    }

    public function showCollectedBooks(){
        $collectedBooks = CollectedBook::leftJoin('book', 'book.book_id', 'collected_books.fk_book_id')
            ->leftJoin('book_author', 'book_author.author_id', 'book.fk_book_author_id')
            ->leftJoin('book_category', 'book_category.category_id', 'book.fk_book_category_id')
            ->where('collected_books.fk_user_id', Auth::user()->id)
            ->get();

        return view('MyView.User.MyCollectedBook.collectedBookList')->with('collectedBooks',$collectedBooks);
    }

}
