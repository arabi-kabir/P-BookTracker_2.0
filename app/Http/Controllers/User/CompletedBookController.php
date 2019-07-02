<?php

namespace App\Http\Controllers\User;

use App\CompleteBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompletedBookController extends Controller
{
    // CHANGE COMPLETE STATUS
    public function changeCompleteStatus(Request $r){

        if($r->value == 'uncomplete')
        {
            $completeBook = new CompleteBook();
            $completeBook->fk_book_id = $r->book_id;
            $completeBook->fk_user_id = Auth::user()->id;
            $completeBook->save();

            return back();
        }
        else
        {
            CompleteBook::where('fk_book_id', $r->book_id)
                ->where('fk_user_id', Auth::user()->id)
                ->first()
                ->delete();

            return back();
        }
    }

    // CHECK IF BOOK IS IN COMPLETED LIST
    public function checkCompleteStatus(Request $r){
        $completeStatus = CompleteBook::where('fk_book_id', $r->book_id)
            ->where('fk_user_id', Auth::user()->id)
            ->first();

        if($completeStatus)
        {
            return "complete";
        }
    }

    public function showCollectedBooks(){
        $completeBooks = CompleteBook::leftJoin('book', 'book.book_id', 'complete_books.fk_book_id')
                                      ->leftJoin('book_author', 'book_author.author_id', 'book.fk_book_author_id')
                                      ->leftJoin('book_category', 'book_category.category_id', 'book.fk_book_category_id')
                                      ->where('complete_books.fk_user_id', Auth::user()->id)
                                       ->get();

        return view('MyView.User.ReadBook.CompletedBook.completedBookList')->with('completeBooks',$completeBooks);
    }
}
