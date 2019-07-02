<?php

namespace App\Http\Controllers\User;

use App\Book;
use App\BookCategory;
use App\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Author;

class BrowseBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function books_all(Request $r)
    {
        $books = Book::leftJoin('book_author', 'book_author.author_id', 'book.fk_book_author_id')
            ->where('book_deleted_at', null)
            ->paginate(6);

        if ($r->filter['filterCategory'] != null){
            $books = $books->where('fk_book_category_id',$r->filter['filterCategory']);
        }
        if ($r->filter['filterAuthor'] != null){
            $books = $books->where('fk_book_author_id',$r->filter['filterAuthor']);
        }
        if ($r->filter['searchtext'] != null){
            $books = $books->orWhere('book.book_name',$r->filter['searchtext'])
                ->orWhere('book_author.author_name', $r->filter['searchtext'])
                ->orWhere('book_category.category_name', $r->filter['searchtext']);
        }

        $categories = BookCategory::where('category_deleted_at', null)->get();
        $authors = Author::where('author_deleted_at', null)->get();

        if ($r->ajax()) {
            return view('MyView.User.Home.books_ajax', compact('books', 'categories', 'authors'));
        }

        return view('MyView.User.Home.books', compact(['books', 'categories', 'authors']));
    }

    public function books_filter(Request $r){

        $books = Book::leftJoin('book_author', 'book_author.author_id', 'book.fk_book_author_id')
                     ->leftJoin('book_category', 'book_category.category_id', 'book.fk_book_category_id')
                     ->where('book_deleted_at', null);

        if ($r->filter['filterCategory'] != null){
            $books = $books->where('book.fk_book_category_id',$r->filter['filterCategory']);
        }
        if ($r->filter['filterAuthor'] != null){
            $books = $books->where('book.fk_book_author_id',$r->filter['filterAuthor']);
        }
        if ($r->filter['searchtext'] != null){
            $books = $books->where('book.book_name', 'like', '%' . $r->filter['searchtext'] . '%')
                            ->orWhere('book_author.author_name', 'like', '%' . $r->filter['searchtext'] . '%')
                            ->orWhere('book_category.category_name', 'like', '%' . $r->filter['searchtext'] . '%');
        }

        $books = $books->paginate(6);

        $categories = BookCategory::where('category_deleted_at', null)->get();
        $authors = Author::where('author_deleted_at', null)->get();



        return view('MyView.User.Home.books_ajax', compact('books', 'categories', 'authors'));
    }

    public function book_details($id){
        $book = Book::leftJoin('book_author', 'book.fk_book_author_id', 'book_author.author_id')
                    ->leftJoin('book_category', 'book.fk_book_category_id', 'book_category.category_id')
                    ->where('book_id', $id)
                    ->first();

        return view("MyView.User.Home.book_details", compact(['book']));
    }

    public function load_review(Request $r){
        $reviews = Review::leftJoin('users', 'users.id', 'book_review.fk_reviewer_user_id')
                         ->where('fk_book_id', $r->id)
                         ->get();

        return view('MyView.User.Home.book_reviews', compact(['reviews']));
    }

    public function total_review(Request $r){
        $reviews = Review::leftJoin('users', 'users.id', 'book_review.fk_reviewer_user_id')
            ->where('fk_book_id', $r->id)
            ->count();

        return view('MyView.User.Home.total_review', compact(['reviews']));
    }

    public function insert_review(Request $r){
        $review = new Review();
        $review->fk_book_id = $r->book_id;
        $review->fk_reviewer_user_id = Auth::user()->id;
        $review->review = $r->review;
        $review->created_at = date("Y-m-d H:i:s");
        $review->updated_at = date("Y-m-d H:i:s");
        $review->save();

        return back();
    }




}
