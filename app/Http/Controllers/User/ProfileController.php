<?php

namespace App\Http\Controllers\User;

use App\Book;
use App\CollectedBook;
use App\CompleteBook;
use App\LendBook;
use App\Reading;
use App\User;
use App\WishListBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use App\ImageModel;
use Image;

class ProfileController extends Controller
{
    public function profile(){
        $profile = User::where('id', Auth::user()->id)->first();

        $collectedBooks = CollectedBook::where('collected_books.fk_user_id', Auth::user()->id)->count();
        $completeBooks =  CompleteBook::where('complete_books.fk_user_id', Auth::user()->id)->count();
        $lendBook = LendBook::where('lend_book.fk_user_id', Auth::user()->id)->count();
        $readingBooks = Reading::where('reading_books.fk_user_id', Auth::user()->id)->count();
        $wishlistBooks = WishListBook::where('wishlist_books.fk_user_id', Auth::user()->id)->count();
        $Uploadedbooks = Book::where('fk_bookinfo_uploader_user_id', Auth::user()->id)->count();

        return view('MyView.User.Profile.profile')->with('profile', $profile)
                                                       ->with('collectedBooks', $collectedBooks)
                                                       ->with('completeBooks', $completeBooks)
                                                       ->with('lendBook', $lendBook)
                                                       ->with('readingBooks', $readingBooks)
                                                       ->with('Uploadedbooks', $Uploadedbooks)
                                                       ->with('wishlistBooks', $wishlistBooks);
    }

    public function update_profile(Request $r){
        $profile = User::findOrFail(Auth::user()->id);

        $profile->name = $r->name;
        $profile->description = $r->profile_desc;
        $profile->email = $r->email;
        $profile->designation = $r->designation;

        if($r->Password)
        {
            $r->validate([
                'Password' => 'required|same:Confirm_Password'
            ]);
        }

        if($r->Password)
        {
            $profile->password = Hash::make($r->Password);
        }

        $profile->save();

        if ($r->hasFile('photo')) {
            $file = $r->file('photo');
            $fileName = Auth::user()->id . "." . $file->getClientOriginalExtension();
            $destinationPath = public_path('files/profileImage');
            $file->move($destinationPath, $fileName);
            $profile->profile_image=$fileName;
            $profile->save();
        }

        Session::flash('success_message', 'Profile Updated!');

        return back();

    }
}
