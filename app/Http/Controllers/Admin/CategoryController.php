<?php

namespace App\Http\Controllers\Admin;

use App\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function category_list(){
        return view('MyView.Admin.Category.category_list');
    }

    public function get_category_list(){
        $categories = BookCategory::leftJoin('users', 'users.id', 'book_category.fk_creator_user_id')
                                  ->where('category_deleted_at', null)
                                  ->orderBy('category_created_at', 'desc');

        $datatables = Datatables::of($categories);
        return $datatables->make(true);
    }

    public function insert_category(Request $r){
        $category = new BookCategory();
        $category->category_name = $r->name;
        $category->fk_creator_user_id = Auth::user()->id;
        $category->category_created_at = date("Y-m-d H:i:s");
        $category->category_updated_at = date("Y-m-d H:i:s");
        $category->save();

        Session::flash('success_message', 'Category Inserted!');

        return back();
    }

    public function edit_category(Request $r){
        $category = BookCategory::findOrFail($r->id);

        return view('MyView.Admin.Category.category_edit')->with('category', $category);
    }

    public function update_category(Request $r){
        $category = BookCategory::findOrFail($r->id);
        $category->category_name = $r->name;
        $category->save();

        Session::flash('success_message', 'Category Updated!');

        return back();
    }

    public function delete_category(Request $r){
        $category = BookCategory::findOrFail($r->id);
        $category->category_deleted_at = date("Y-m-d H:i:s");
        $category->save();

        return back();
    }
}
