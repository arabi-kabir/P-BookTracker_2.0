@extends('layouts.site_layout.master')


@section('page_css')

    <link href="{{ asset('public/assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />

@endsection


@section('content')
    <h4 class="page-title">Upload New Book</h4>

    <div>
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" method="post" action="{{ route('user.book.insert') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-2  col-form-label" for="simpleinput">Name *</label>
                                <div class="col-sm-10">
                                    <input type="text" id="simpleinput" class="form-control" name="bookname" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2  col-form-label" for="example-email">Category</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="category">
                                        <option value="">Select Category</option>
                                        @foreach($category as $c)
                                            <option value="{{ $c->category_id }}">{{ $c->category_name }}</option>
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
                                            <option value="{{ $a->author_id }}">{{ $a->author_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2  col-form-label" for="example-email">Publish Year</label>
                                <div class="col-sm-10">
                                    <input type="number" id="example-email" name="publish_year" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2  col-form-label" for="simpleinput">No. of Page</label>
                                <div class="col-sm-10">
                                    <input type="text" id="simpleinput" class="form-control" name="num_page">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2  col-form-label" for="simpleinput">Book Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" placeholder="Book Description" name="book_desc"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" style="padding-top: 0px;" for="simpleinput">Book Cover Image</label>
                                <div>
                                    <input type="file" class="dropify" data-max-file-size="2M" name="photo" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary float-right" type="submit">Upload Book</button>

                </form>
            </div>
        </div>

    </div>


@endsection


@section('page_script')

    <script src="{{ asset('public/assets/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/pages/form-fileupload.init.js') }}"></script>

@endsection