<?php

namespace App\Http\Controllers\User;

use App\Author;
use App\Book;
use App\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use Yajra\DataTables\DataTables;

class BookUploadController extends Controller
{
    public function book_upload_list(){
        return view('MyView.User.MyBookPanel.uploaded_book_list');
    }

    public function get_book_upload_list(){
        $books = Book::leftJoin('book_author', 'book_author.author_id', 'book.fk_book_author_id')
                     ->leftJoin('book_category', 'book_category.category_id', 'book.fk_book_category_id')
                     ->where('fk_bookinfo_uploader_user_id', Auth::user()->id)
                     ->where('book_deleted_at', null)
                     ->orderBy('book.book_created_at', 'desc');

        $datatables = Datatables::of($books);
        return $datatables->make(true);
    }

    public function book_upload(){

        $category = BookCategory::where('category_deleted_at', null)->get();
        $author = Author::where('author_deleted_at', null)->get();

        return view('MyView.User.MyBookPanel.upload_book')
            ->with('category', $category)
            ->with('author', $author);
    }

    public function book_insert(Request $r){

        $r->validate([
            'bookname' => 'required'
        ]);

        $book = new Book();
        $book->book_name = $r->bookname;
        $book->fk_book_category_id = $r->category;
        $book->fk_book_author_id = $r->author;
        $book->book_description = $r->book_desc;
        $book->fk_bookinfo_uploader_user_id = Auth::user()->id;
        $book->book_publish_year = $r->publish_year;
        $book->book_page = $r->num_page;
        $book->book_status = 'Active';
        $book->book_created_at = date("Y-m-d H:i:s");
        $book->book_updated_at = date("Y-m-d H:i:s");
        $book->save();

        if ($r->hasFile('photo')) {
            $file = $r->file('photo');
            $fileName = $book->book_id . "." . $file->getClientOriginalExtension();
            $destinationPath = public_path('files/book_image');
            $file->move($destinationPath, $fileName);
            $book->book_image = $fileName;
            $book->save();
        }

        Session::flash('success_message', 'Book Uploaded!');

        return redirect()->route('user.book.my_upload_list');
    }

    public function book_edit(Request $r){

        $category = BookCategory::where('category_deleted_at', null)->get();
        $author = Author::where('author_deleted_at', null)->get();

        $book = Book::findOrFail($r->id);
        return view('MyView.User.MyBookPanel.edit_book')->with('book', $book)
            ->with('category', $category)
            ->with('author', $author);
    }

    public function book_update(Request $r){

        $r->validate([
            'bookname' => 'required'
        ]);

        $book = Book::findOrFail($r->id);
        $book->book_name = $r->bookname;
        $book->fk_book_category_id = $r->category;
        $book->fk_book_author_id = $r->author;
        $book->book_description = $r->book_desc;
        $book->book_publish_year = $r->publish_year;
        $book->book_page = $r->num_page;
        $book->book_updated_at = date("Y-m-d H:i:s");
        $book->save();

        if ($r->hasFile('photo')) {
            $file = $r->file('photo');
            $fileName = $book->book_id . "." . $file->getClientOriginalExtension();
            $destinationPath = public_path('files/book_image');
            $file->move($destinationPath, $fileName);
            $book->book_image = $fileName;
            $book->save();
        }

        Session::flash('success_message', 'Book Updated!');

        return redirect()->route('user.book.my_upload_list');
    }

}
