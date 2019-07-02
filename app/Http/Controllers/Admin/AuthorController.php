<?php

namespace App\Http\Controllers\Admin;

use App\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use Yajra\DataTables\DataTables;

class AuthorController extends Controller
{
    public function author_list(){
        return view('MyView.Admin.Author.author_list');
    }

    public function get_author_list(){
        $authors = Author::leftJoin('users', 'users.id', 'book_author.fk_author_info_uploader_user_id')
                         ->where('author_deleted_at', null)
                         ->orderBy('author_created_at', 'desc')
                         ->get();

        $datatables = Datatables::of($authors);
        return $datatables->make(true);
    }

    public function insert_author(Request $r){
        $author = new Author();
        $author->author_name = $r->name;
        $author->fk_author_info_uploader_user_id = Auth::user()->id;
        $author->author_created_at = date("Y-m-d H:i:s");
        $author->author_updated_at = date("Y-m-d H:i:s");
        $author->save();

        if ($r->hasFile('photo')) {
            $file = $r->file('photo');
            $fileName = $author->author_id . "." . $file->getClientOriginalExtension();
            $destinationPath = public_path('files/author_image');
            $file->move($destinationPath, $fileName);
            $author->author_photo=$fileName;
            $author->save();
        }

        Session::flash('success_message', 'Author Inserted!');

        return back();
    }

    public function edit_author(Request $r){
        $author = Author::findOrFail($r->id);
        return view('MyView.Admin.Author.author_edit')->with('author', $author);
    }

    public function update_author(Request $r){
        $author = Author::findOrFail($r->id);
        $author->author_name = $r->name;

        if ($r->hasFile('photo')) {
            $file = $r->file('photo');
            $fileName = $author->author_id . "." . $file->getClientOriginalExtension();
            $destinationPath = public_path('files/author_image');
            $file->move($destinationPath, $fileName);
            $author->author_photo = $fileName;
        }
        $author->save();

        Session::flash('success_message', 'Author Information Updated!');

        return back();
    }

    public function delete_author(Request $r){
        $category = BookCategory::findOrFail($r->id);
        $category->category_deleted_at = date("Y-m-d H:i:s");
        $category->save();

        return back();
    }
}
