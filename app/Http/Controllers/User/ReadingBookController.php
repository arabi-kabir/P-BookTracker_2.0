<?php

namespace App\Http\Controllers\User;

use App\CompleteBook;
use App\Reading;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class ReadingBookController extends Controller
{
    // CHANGE COMPLETE STATUS
    public function changeReadingStatus(Request $r){

        if($r->value == 'unread')
        {
            $readingBook = new Reading();
            $readingBook->fk_book_id = $r->book_id;
            $readingBook->fk_user_id = Auth::user()->id;
            $readingBook->save();

            return back();
        }
        else
        {
            Reading::where('fk_book_id', $r->book_id)
                ->where('fk_user_id', Auth::user()->id)
                ->first()
                ->delete();

            return back();
        }
    }

    // CHECK IF BOOK IS IN COMPLETED LIST
    public function checkReadingStatus(Request $r){
        $readingStatus = Reading::where('fk_book_id', $r->book_id)
            ->where('fk_user_id', Auth::user()->id)
            ->first();

        if($readingStatus)
        {
            return "read";
        }
    }

    public function showReadingBooks(){
        $readingBooks = Reading::leftJoin('book', 'book.book_id', 'reading_books.fk_book_id')
            ->leftJoin('book_author', 'book_author.author_id', 'book.fk_book_author_id')
            ->leftJoin('book_category', 'book_category.category_id', 'book.fk_book_category_id')
            ->where('reading_books.fk_user_id', Auth::user()->id)
            ->get();

        return view('MyView.User.ReadBook.ReadingBook.readingBookList')->with('readingBooks',$readingBooks);
    }

    public function change2complete(Request $r){

        $completeList = CompleteBook::where('fk_book_id', $r->book_id)
            ->where('fk_user_id', Auth::user()->id)
            ->first();

        if($completeList)
        {
            Session::flash('error_message', 'This book is already in your complete list!');
        }
        else
        {
            // FIRST DELETE FROM READING LIST
            Reading::where('fk_book_id', $r->book_id)
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
