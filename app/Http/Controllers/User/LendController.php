<?php

namespace App\Http\Controllers\User;

use App\CollectedBook;
use App\LendBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class LendController extends Controller
{
    public function pendingBook(){

        $availableBooks = CollectedBook::leftJoin('book', 'book.book_id', 'collected_books.fk_book_id')
                                        ->where('fk_user_id', Auth::user()->id)
                                        ->where('availability', 1)
                                        ->get();

        $lendBook = LendBook::leftJoin('book', 'book.book_id', 'lend_book.fk_book_id')
                            ->leftJoin('book_category', 'book.fk_book_category_id', 'book_category.category_id')
                            ->where('fk_user_id', Auth::user()->id)
                            ->where('lend_status', 1)
                            ->get();

        return view('MyView.User.ManageLendBooks.pendingBooks')->with('availableBooks', $availableBooks)
                                                                    ->with('lendBooks', $lendBook);
    }

    public function lendBook(Request $r){

        $lendBook = new LendBook();
        $lendBook->fk_book_id = $r->book_id;
        $lendBook->fk_user_id = Auth::user()->id;
        $lendBook->lend_date = Carbon::parse($r->lendDate)->format('Y-m-d');
        $lendBook->expected_return_date = Carbon::parse($r->returnDate)->format('Y-m-d');
        $lendBook->lend_status = 1;
        $lendBook->lent_to = $r->lentToName;
        $lendBook->created_at = date("Y-m-d H:i:s");
        $lendBook->save();

        // UPDATE AVAILABILITY
        $collectedBook = CollectedBook::where('fk_book_id', $r->book_id)
                                      ->where('fk_user_id', Auth::user()->id)
                                      ->first();
        $collectedBook->availability = 0;
        $collectedBook->save();

        Session::flash('success_message', 'Book lend information inserted!');

        return back();
    }

    public function returnBook(Request $r){

        $lendBook = LendBook::where('fk_user_id', Auth::user()->id)
                            ->where('fk_book_id', $r->book_id)
                            ->first();

        $lendBook->lend_status = 0;
        $lendBook->returned_date = Carbon::parse($r->returnDate)->format('Y-m-d');
        $lendBook->save();

        // UPDATE AVAILABILITY
        $collectedBook = CollectedBook::where('fk_book_id', $r->book_id)
                                      ->where('fk_user_id', Auth::user()->id)
                                      ->first();
        $collectedBook->availability = 1;
        $collectedBook->save();

        return back();
    }

    public function lentHistory(){
        $lentHistory = LendBook::leftJoin('book', 'book.book_id', 'lend_book.fk_book_id')
                               ->leftJoin('book_category', 'book.fk_book_category_id', 'book_category.category_id')
                               ->where('fk_user_id', Auth::user()->id)
                               ->where('lend_status', '0')
                               ->get();

        return view('MyView.User.ManageLendBooks.lentHistory')->with('lentBooks', $lentHistory);
    }

    public function setPending(Request $r){
        $lendBook = LendBook::where('fk_user_id', Auth::user()->id)
            ->where('fk_book_id', $r->book_id)
            ->first();

        $lendBook->lend_status = 1;
        $lendBook->returned_date = null;
        $lendBook->save();

        // UPDATE AVAILABILITY
        $collectedBook = CollectedBook::where('fk_book_id', $r->book_id)
            ->where('fk_user_id', Auth::user()->id)
            ->first();
        $collectedBook->availability = 0;
        $collectedBook->save();

        Session::flash('success_message', 'Book lend information updated!');

        return back();
    }

}
