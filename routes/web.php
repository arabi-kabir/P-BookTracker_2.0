<?php


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

/*
 * --------------------------------------------------------------------------------------
 *                                      ADMIN ROUTES
 * --------------------------------------------------------------------------------------
 */

//================================== DashboardController ================================
Route::get('/admin/dashboard', 'Admin\DashboardController@dashboard')->name('admin.dashboard');


//================================== CategoryController ================================
Route::get ('/admin/category',        'Admin\CategoryController@category_list')     ->name('admin.category.list');
Route::post('/admin/category/get',    'Admin\CategoryController@get_category_list') ->name('admin.category.list.getData');
Route::post('/admin/category/insert', 'Admin\CategoryController@insert_category')   ->name('admin.category.insert');
Route::post('/admin/category/edit',   'Admin\CategoryController@edit_category')     ->name('admin.category.edit');
Route::post('/admin/category/update', 'Admin\CategoryController@update_category')   ->name('admin.category.update');
Route::post('/admin/category/delete', 'Admin\CategoryController@delete_category')   ->name('admin.category.delete');

//================================== AuthorController ================================
Route::get ('/admin/author',        'Admin\AuthorController@author_list')     ->name('admin.author.list');
Route::post('/admin/author/get',    'Admin\AuthorController@get_author_list') ->name('admin.author.list.getData');
Route::post('/admin/author/insert', 'Admin\AuthorController@insert_author')   ->name('admin.author.insert');
Route::post('/admin/author/edit',   'Admin\AuthorController@edit_author')     ->name('admin.author.edit');
Route::post('/admin/author/update', 'Admin\AuthorController@update_author')   ->name('admin.author.update');
Route::post('/admin/author/delete', 'Admin\AuthorController@delete_author')   ->name('admin.author.delete');












/*
 * --------------------------------------------------------------------------------------
 *                                      USER ROUTES
 * --------------------------------------------------------------------------------------
 */
//================================== DashboardController ================================
Route::get ('/my-uploaded-books',     'User\BookUploadController@book_upload_list')     ->name('user.book.my_upload_list');
Route::post('/my-uploaded-books-get', 'User\BookUploadController@get_book_upload_list') ->name('user.book.my_upload_list.get');

//================================== BookUploadController ================================
Route::get ('/upload-books',      'User\BookUploadController@book_upload') ->name('user.book.upload');
Route::post('/insert-books',      'User\BookUploadController@book_insert') ->name('user.book.insert');
Route::post('/edit-books',        'User\BookUploadController@book_edit')   ->name('user.book.edit');
Route::post('/update-books',      'User\BookUploadController@book_update') ->name('user.book.update');

//================================== BrowseBookController ================================
Route::get ('/home',             'User\BrowseBookController@books_all')     ->name('home');
Route::post('books-filter',      'User\BrowseBookController@books_filter')  ->name('books.filter');
Route::get ('/book/{id}',        'User\BrowseBookController@book_details')  ->name('book.details');
Route::post('/load-review',      'User\BrowseBookController@load_review')   ->name('book.load.review');
Route::post('/total-review',     'User\BrowseBookController@total_review')  ->name('book.total.review');
Route::post('/insert-review',    'User\BrowseBookController@insert_review') ->name('book.insert.review');



//================================== CompletedBookController ============================
Route::post('/change-complete-status',   'User\CompletedBookController@changeCompleteStatus') ->name('complete.change');
Route::post('/check-complete-status',    'User\CompletedBookController@checkCompleteStatus')  ->name('complete.check');
Route::get ('/completed-books',           'User\CompletedBookController@showCollectedBooks')   ->name('complete.show.list');

//================================== WishlistBookController ============================
Route::post('/change-wishlist-status',   'User\WishlistBookController@changeWishlistStatus') ->name('wishlist.change');
Route::post('/check-wishlist-status',    'User\WishlistBookController@checkWishlistStatus')  ->name('wishlist.check');
Route::get ('/wishlist-books',           'User\WishlistBookController@showWishlistBooks')    ->name('wishlist.show.list');
Route::post('/wishlist-2-complete-list', 'User\WishlistBookController@chage2wishlist')       ->name('wishlist.change2complete');


//================================== ReadingBookController ============================
Route::post('/change-reading-status',   'User\ReadingBookController@changeReadingStatus') ->name('reading.change');
Route::post('/check-reading-status',    'User\ReadingBookController@checkReadingStatus')  ->name('reading.check');
Route::get ('/reading-books',           'User\ReadingBookController@showReadingBooks')    ->name('reading.show.list');
Route::post('/reading-2-complete-list', 'User\ReadingBookController@change2complete')      ->name('reading.change2complete');

//================================== CollectedBookController ============================
Route::post('/change-collected-status',   'User\CollectedBookController@changeCollectedStatus') ->name('collected.change');
Route::post('/check-collected-status',    'User\CollectedBookController@checkCollectedStatus')  ->name('collected.check');
Route::get ('/collected-books',           'User\CollectedBookController@showCollectedBooks')    ->name('collected.show.list');


//================================== LendController ============================
Route::get ('/lend-books',          'User\LendController@pendingBook') ->name('lend.pending');
Route::post('/lend-books-insert',   'User\LendController@lendBook')    ->name('lend.insert');
Route::post('/lend-books-returned', 'User\LendController@returnBook')  ->name('lend.return');
Route::get ('/lent-history',        'User\LendController@lentHistory') ->name('lend.history');
Route::post('/lent-book-pending',   'User\LendController@setPending')  ->name('lend.setPending');

//Route::post('/check-collected-status',    'User\CollectedBookController@checkCollectedStatus')  ->name('collected.check');
//Route::get ('/collected-books',           'User\CollectedBookController@showCollectedBooks')    ->name('collected.show.list');


//================================== ProfileController ============================
Route::get ('/profiles',          'User\ProfileController@profile')        ->name('profile.show');
Route::post('/profile-update',    'User\ProfileController@update_profile') ->name('profile.update');


//================================== FriendController ============================
Route::get ('/users',          'User\FriendController@users')          ->name('users.show');
Route::post('/sent-request',   'User\FriendController@sentRequest')    ->name('request.insert');
Route::post('/check-request',  'User\FriendController@checkRequest')   ->name('request.check');
Route::post('/userlist-get',   'User\FriendController@getUserlist')    ->name('userlist.getlist');
Route::post('/pending-get',    'User\FriendController@getPendinglist') ->name('pending.getlist');
Route::post('/cancel-request', 'User\FriendController@cancelRequest')  ->name('request.cancel');


Route::get ('/new-requests', 'User\FriendController@newRequestList')  ->name('new.request.show');
Route::post('/new-requests-get', 'User\FriendController@newRequestListGet')  ->name('new.request.get');
Route::post('/new-requests-accept', 'User\FriendController@newRequestListAccept')  ->name('new.request.accept');
Route::post('/new-requests-reject', 'User\FriendController@newRequestListReject')  ->name('new.request.reject');

Route::get ('/my-friends', 'User\FriendController@friendslist')  ->name('friends.list');
Route::post('/my-friends-get', 'User\FriendController@friendslistGet')  ->name('friends.list.get');
Route::post('/my-friends-unfriend', 'User\FriendController@unfriend')  ->name('friend.unfollow');

