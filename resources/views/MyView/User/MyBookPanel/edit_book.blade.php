<form class="form-horizontal" role="form" method="post" action="{{ route('user.book.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{ $book->book_id }}" name="id">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group row">
                <label class="col-sm-2  col-form-label" for="simpleinput">Name *</label>
                <div class="col-sm-10">
                    <input type="text" id="simpleinput" class="form-control" name="bookname" value="{{ $book->book_name }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2  col-form-label" for="example-email">Category</label>
                <div class="col-sm-10">
                    <select class="form-control" name="category">
                        <option value="">Select Category</option>
                        @foreach($category as $c)
                            <option value="{{ $c->category_id }}" @if($c->category_id == $book->fk_book_category_id) selected @endif>{{ $c->category_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2  col-form-label" for="simpleinput">Author</label>
                <div class="col-sm-10">
                    <select class="form-control" name="author">
                        <option value="">Select Author</option>
                        @foreach($author as $a)
                            <option value="{{ $a->author_id }}" @if($a->author_id == $book->fk_book_author_id) selected @endif>{{ $a->author_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2  col-form-label" for="example-email">Publish Year</label>
                <div class="col-sm-10">
                    <input type="number" id="example-email" name="publish_year" value="{{ $book->book_publish_year }}" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2  col-form-label" for="simpleinput">No. of Page</label>
                <div class="col-sm-10">
                    <input type="text" id="simpleinput" class="form-control" value="{{ $book->book_page }}" name="num_page">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2  col-form-label" for="simpleinput">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" placeholder="Book Description" rows="4" name="book_desc">{{ $book->book_description }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-form-label" for="simpleinput">Change Book Cover Image</label>
                <div>
                    <input type="file" class="dropify" data-max-file-size="2M" name="photo" />
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <img src="{{ asset('public/files/book_image/'. $book->book_image) }}" width="100%" height="auto" alt="">
        </div>

    </div>

    <button class="btn btn-primary float-right" type="submit">SAVE CHANGES</button>

</form>

<script src="{{ asset('public/assets/libs/dropify/dropify.min.js') }}"></script>
<script src="{{ asset('public/assets/js/pages/form-fileupload.init.js') }}"></script>

@section('page_css')

    <link href="{{ asset('public/assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />

@endsection