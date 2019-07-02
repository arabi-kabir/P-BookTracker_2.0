@extends('layouts.site_layout.master')

@section('page_css')

    <link href="{{ asset('public/my_assets/balloon/balloon.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

    <style>
         .checked{
             color: orange;
         }
    </style>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-4 mb-4">

            <div class="gal-detail thumb">

                <img class="thumb-img" width="100%;" height="auto" src="{{ asset('public/files/book_image/'.$book->book_image) }}" alt="Book image cap">

                <div class="text-center">
                    <h4>{{ $book->book_name }}</h4>

                    {{--<p class="font-13 text-muted mb-2">Natural, Personal</p>--}}

                    {{-- Rating --}}
                    {{--<span class="fa fa-star checked"></span>--}}
                    {{--<span class="fa fa-star checked"></span>--}}
                    {{--<span class="fa fa-star checked"></span>--}}
                    {{--<span class="fa fa-star"></span>--}}
                    {{--<span class="fa fa-star"></span>--}}

                    {{--<div id="rateYo"></div>--}}

                    <br>

                    {{-- Buttons --}}
                    <div class="row mb-2 mt-3">
                        <div class="col-md-6">
                            <button aria-label="Click to change status!" data-balloon-pos="up" style="width: 100%;" class="btn btn-lighten-dark waves-effect waves-dark width-md btn-xs" style="margin: 5px;" onclick="completeBtn()" id="completeBtn" value="uncomplete">ADD TO COMPLETE</button>
                        </div>
                        <div class="col-md-6">
                            <button aria-label="Click to change status" data-balloon-pos="up" style="width: 100%;" class="btn btn-lighten-dark waves-effect waves-dark width-md btn-xs" style="margin: 5px;" onclick="wishlistBtn()" id="wishlistBtn" value="unwish">ADD TO WISH LIST</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <button aria-label="Click to change status" data-balloon-pos="up" style="width: 100%;" class="btn btn-lighten-dark waves-effect waves-dark width-md btn-xs" style="margin: 5px;" onclick="readingBtn()" id="readingBtn" value="unread">ADD TO READING</button>
                        </div>
                        <div class="col-md-6">
                            <button aria-label="Click to change status" data-balloon-pos="up" style="width: 100%;" class="btn btn-lighten-dark waves-effect waves-dark width-md btn-xs" style="margin: 5px;" onclick="collectedBtn()" id="collectedBtn" value="uncollected">ADD TO COLLECTION</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-8">

            {{-- Book Description --}}
            <div class="text-center card-box" style="margin-top: 24px;">
                <div>
                    <p class="text-muted font-13 mb-3">
                        {{ $book->book_description }}
                    </p>

                    <div class="">
                        <table class="table table-hover table-bordered table-sm" style="width: 100%; margin-bottom: 0px;">
                            <tr>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center"><strong>Name</strong></td>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center">{{ $book->book_name }}</td>
                            </tr>

                            <tr>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center"><strong>Category</strong></td>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center">{{ $book->category_name }}</td>
                            </tr>

                            <tr>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center"><strong>Author</strong></td>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center">{{ $book->author_name }}</td>
                            </tr>

                            <tr>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center"><strong>Publish Year</strong></td>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center">{{ $book->book_publish_year }}</td>
                            </tr>

                            <tr>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center"><strong>Number of Pages</strong></td>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center">{{ $book->book_page }}</td>
                            </tr>

                            <tr>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center"><strong>Rating</strong></td>
                                <td style="padding-top: 11px; padding-bottom: 11px; text-align: center">{{ $book->book_rating }}</td>
                            </tr>

                        </table>
                    </div>
                </div>

            </div>

            {{-- Book Review --}}
            <div class="card-box">

                <h4 class="header-title mt-0 mb-3" id="total_review"></h4>

                <div id="all_reviews">

                </div>


                <div class="media">
                    <div class="d-flex mr-3">
                        <a href="#"> <img class="media-object rounded-circle avatar-sm" alt="64x64" src="{{ asset('public/assets/images/users/user-1.jpg') }}"> </a>
                    </div>
                    <div class="media-body">
                        <textarea class="form-control input-sm" id="review" placeholder="Put your review..."></textarea>
                        <button class="btn btn-success btn-xs btn-block" style="float: right; margin-top: 10px;" onclick="insert_review()">Post</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection


@section('page_script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

    <script>

        {{-- Rating --}}
        // $("#rateYo").rateYo({
        //     rating: 0,
        // });

        $(function () {

            var $rateYo = $("#rateYo").rateYo();

            $("#getRating").click(function () {

                /* get rating */
                var rating = $rateYo.rateYo("rating");

                window.alert("Its " + rating + " Yo!");
            });

            $("#setRating").click(function () {

                /* set rating */
                var rating = getRandomRating();
                $rateYo.rateYo("rating", rating);
            });
        });

        load_review();
        total_review();

        function load_review() {
            $.ajax({
                type: 'POST',
                url: "{!! route('book.load.review') !!}",
                cache: false,
                data: {
                    _token: "{{csrf_token()}}",
                    'id': '{{ $book->book_id }}',
                },
                success: function (data) {
                    $('#all_reviews').html(data);
                }
            });
            $('#review').val("");
        }

        function total_review() {
            $.ajax({
                type: 'POST',
                url: "{!! route('book.total.review') !!}",
                cache: false,
                data: {
                    _token: "{{csrf_token()}}",
                    'id': '{{ $book->book_id }}',
                },
                success: function (data) {
                    $('#total_review').html(data);
                }
            });
        }

        function insert_review() {
            $.ajax({
                type: 'POST',
                url: "{!! route('book.insert.review') !!}",
                cache: false,
                data: {
                    _token: "{{csrf_token()}}",
                    'book_id': '{{ $book->book_id }}',
                    'review': $('#review').val(),
                },
                success: function (data) {
                    $('#review').val("");
                    load_review();
                    total_review();
                }
            });
        }

        // CALL INSERT FUNCTION WHEN ENTER IS PRESSED
        var review = document.getElementById("review");
        review.addEventListener("keydown", function (e) {
            if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
                insert_review()
            }
        });



        // COMPLETE FUNCTION
        function completeBtn(x) {
            value = $("#completeBtn").val();

            id = $(x).data('panel-id');
            $.ajax({
                type: 'POST',
                url: "{!! route('complete.change') !!}",
                cache: false,
                data: {
                    _token: "{{csrf_token()}}",
                    'book_id': '{{ $book->book_id }}',
                    'value': value,
                },
                success: function (data) {
                    if(value == 'uncomplete')
                    {
                        $("#completeBtn").val('complete');
                        $("#completeBtn").html('COMPLETED');

                        // CHANGE BUTTON CLASS
                        $("#completeBtn").removeClass("btn-lighten-dark")
                        $("#completeBtn").removeClass("waves-dark")
                        $("#completeBtn").addClass("btn-lighten-success")
                        $("#completeBtn").addClass("waves-success")

                        // Toast message
                        toastr.options.timeOut = 4000;
                        toastr.options.closeButton = false;
                        toastr.options.progressBar = false;
                        toastr.options.positionClass = "toast-top-center";
                        toastr.success("Added to complete list.", {timeOut: 4000})
                    }
                    else
                    {
                        $("#completeBtn").val('uncomplete');
                        $("#completeBtn").html('ADD TO COMPLETE');

                        // CHANGE BUTTON CLASS
                        $("#completeBtn").removeClass("btn-lighten-success")
                        $("#completeBtn").removeClass("waves-success")
                        $("#completeBtn").addClass("btn-lighten-dark")
                        $("#completeBtn").addClass("waves-dark")

                        // Toast message
                        toastr.options.timeOut = 4000;
                        toastr.options.closeButton = false;
                        toastr.options.progressBar = false;
                        toastr.options.positionClass = "toast-top-center";
                        toastr.success("Removed from complete list.", {timeOut: 4000})
                    }
                }
            });
        }

        // CHECK FOR COMPLETE
        $.ajax({
            type: 'POST',
            url: "{!! route('complete.check') !!}",
            cache: false,
            data: {
                _token: "{{csrf_token()}}",
                'book_id': '{{ $book->book_id }}',
            },
            success: function (data) {
                if(data == "complete")
                {
                    $("#completeBtn").val('complete');
                    $("#completeBtn").html('COMPLETED');

                    // CHANGE BUTTON CLASS
                    $("#completeBtn").removeClass("btn-lighten-dark")
                    $("#completeBtn").removeClass("waves-dark")
                    $("#completeBtn").addClass("btn-lighten-success")
                    $("#completeBtn").addClass("waves-success")
                }
            }
        });



        // WISHLIST FUNCTION
        function wishlistBtn(x) {
            value = $("#wishlistBtn").val();

            id = $(x).data('panel-id');
            $.ajax({
                type: 'POST',
                url: "{!! route('wishlist.change') !!}",
                cache: false,
                data: {
                    _token: "{{csrf_token()}}",
                    'book_id': '{{ $book->book_id }}',
                    'value': value,
                },
                success: function (data) {
                    if(value == 'unwish')
                    {
                        $("#wishlistBtn").val('wish');
                        $("#wishlistBtn").html('IN MY WISHLIST');

                        // CHANGE BUTTON CLASS
                        $("#wishlistBtn").removeClass("btn-lighten-dark")
                        $("#wishlistBtn").removeClass("waves-info")
                        $("#wishlistBtn").addClass("btn-lighten-success")
                        $("#wishlistBtn").addClass("waves-success")

                        // Toast message
                        toastr.options.timeOut = 4000;
                        toastr.options.closeButton = false;
                        toastr.options.progressBar = false;
                        toastr.options.positionClass = "toast-top-center";
                        toastr.success("Added to wish list.", {timeOut: 4000})
                    }
                    else
                    {
                        $("#wishlistBtn").val('unwish');
                        $("#wishlistBtn").html('ADD TO WISHLIST');

                        // CHANGE BUTTON CLASS
                        $("#wishlistBtn").removeClass("btn-lighten-success")
                        $("#wishlistBtn").removeClass("waves-success")
                        $("#wishlistBtn").addClass("btn-lighten-dark")
                        $("#wishlistBtn").addClass("waves-dark")

                        // Toast message
                        toastr.options.timeOut = 4000;
                        toastr.options.closeButton = false;
                        toastr.options.progressBar = false;
                        toastr.options.positionClass = "toast-top-center";
                        toastr.success("Removed from wish list.", {timeOut: 4000})
                    }
                }
            });
        }

        // CHECK FOR WISHLIST
        $.ajax({
            type: 'POST',
            url: "{!! route('wishlist.check') !!}",
            cache: false,
            data: {
                _token: "{{csrf_token()}}",
                'book_id': '{{ $book->book_id }}',
            },
            success: function (data) {
                if(data == "wish")
                {
                    $("#wishlistBtn").val('wish');
                    $("#wishlistBtn").html('IN MY WISHLIST');

                    // CHANGE BUTTON CLASS
                    $("#wishlistBtn").removeClass("btn-lighten-dark")
                    $("#wishlistBtn").removeClass("waves-dark")
                    $("#wishlistBtn").addClass("btn-lighten-success")
                    $("#wishlistBtn").addClass("waves-success")
                }
            }
        });



        // READING FUNCTION
        function readingBtn(x) {
            value = $("#readingBtn").val();

            id = $(x).data('panel-id');
            $.ajax({
                type: 'POST',
                url: "{!! route('reading.change') !!}",
                cache: false,
                data: {
                    _token: "{{csrf_token()}}",
                    'book_id': '{{ $book->book_id }}',
                    'value': value,
                },
                success: function (data) {
                    if(value == 'unread')
                    {
                        $("#readingBtn").val('read');
                        $("#readingBtn").html('CURRENTLY READING');

                        // CHANGE BUTTON CLASS
                        $("#readingBtn").removeClass("btn-lighten-dark")
                        $("#readingBtn").removeClass("waves-info")
                        $("#readingBtn").addClass("btn-lighten-success")
                        $("#readingBtn").addClass("waves-success")

                        // Toast message
                        toastr.options.timeOut = 4000;
                        toastr.options.closeButton = false;
                        toastr.options.progressBar = false;
                        toastr.options.positionClass = "toast-top-center";
                        toastr.success("Added to currently reading list.", {timeOut: 4000})
                    }
                    else
                    {
                        $("#readingBtn").val('unread');
                        $("#readingBtn").html('ADD TO READING');

                        // CHANGE BUTTON CLASS
                        $("#readingBtn").removeClass("btn-lighten-success")
                        $("#readingBtn").removeClass("waves-success")
                        $("#readingBtn").addClass("btn-lighten-dark")
                        $("#readingBtn").addClass("waves-dark")

                        // Toast message
                        toastr.options.timeOut = 4000;
                        toastr.options.closeButton = false;
                        toastr.options.progressBar = false;
                        toastr.options.positionClass = "toast-top-center";
                        toastr.success("Removed from currently reading list.", {timeOut: 4000})
                    }
                }
            });
        }

        // CHECK FOR READING LIST
        $.ajax({
            type: 'POST',
            url: "{!! route('reading.check') !!}",
            cache: false,
            data: {
                _token: "{{csrf_token()}}",
                'book_id': '{{ $book->book_id }}',
            },
            success: function (data) {
                if(data == "read")
                {
                    $("#readingBtn").val('read');
                    $("#readingBtn").html('CURRENTLY READING');

                    // CHANGE BUTTON CLASS
                    $("#readingBtn").removeClass("btn-lighten-dark")
                    $("#readingBtn").removeClass("waves-dark")
                    $("#readingBtn").addClass("btn-lighten-success")
                    $("#readingBtn").addClass("waves-success")
                }
            }
        });


        // COLLECTED FUNCTION
        function collectedBtn(x) {
            value = $("#collectedBtn").val();

            id = $(x).data('panel-id');
            $.ajax({
                type: 'POST',
                url: "{!! route('collected.change') !!}",
                cache: false,
                data: {
                    _token: "{{csrf_token()}}",
                    'book_id': '{{ $book->book_id }}',
                    'value': value,
                },
                success: function (data) {
                    if(value == 'uncollected')
                    {
                        $("#collectedBtn").val('collected');
                        $("#collectedBtn").html('IN MY COLLECTION');

                        // CHANGE BUTTON CLASS
                        $("#collectedBtn").removeClass("btn-lighten-dark")
                        $("#collectedBtn").removeClass("waves-info")
                        $("#collectedBtn").addClass("btn-lighten-success")
                        $("#collectedBtn").addClass("waves-success")

                        // Toast message
                        toastr.options.timeOut = 4000;
                        toastr.options.closeButton = false;
                        toastr.options.progressBar = false;
                        toastr.options.positionClass = "toast-top-center";
                        toastr.success("Added to my collection list.", {timeOut: 4000})
                    }
                    else
                    {
                        $("#collectedBtn").val('uncollected');
                        $("#collectedBtn").html('ADD TO COLLECTION');

                        // CHANGE BUTTON CLASS
                        $("#collectedBtn").removeClass("btn-lighten-success")
                        $("#collectedBtn").removeClass("waves-success")
                        $("#collectedBtn").addClass("btn-lighten-dark")
                        $("#collectedBtn").addClass("waves-dark")

                        // Toast message
                        toastr.options.timeOut = 4000;
                        toastr.options.closeButton = false;
                        toastr.options.progressBar = false;
                        toastr.options.positionClass = "toast-top-center";
                        toastr.success("Removed from my collected list.", {timeOut: 4000})
                    }
                }
            });
        }

        // CHECK FOR COLLECTED LIST
        $.ajax({
            type: 'POST',
            url: "{!! route('collected.check') !!}",
            cache: false,
            data: {
                _token: "{{csrf_token()}}",
                'book_id': '{{ $book->book_id }}',
            },
            success: function (data) {
                if(data == "collected")
                {
                    $("#collectedBtn").val('read');
                    $("#collectedBtn").html('IN MY COLLECTION');

                    // CHANGE BUTTON CLASS
                    $("#collectedBtn").removeClass("btn-lighten-dark")
                    $("#collectedBtn").removeClass("waves-dark")
                    $("#collectedBtn").addClass("btn-lighten-success")
                    $("#collectedBtn").addClass("waves-success")
                }
            }
        });

    </script>
@endsection