@extends('layouts.site_layout.master')

@section('page_css')

    <style>
        .img-fluid{
            height: 180px !important;
        }
        .checked{
            color: orange;
        }
    </style>

@endsection

@section('content')
    {{--<h4 class="page-title">Home</h4>--}}

    <div class="row" style="margin-top: 30px;">
        <div class="col-md-3 col-lg-2">
            <div class="card-box">
                <h4>Filter</h4>
                <select class="custom-select mt-2" id="filterCategory" onchange="filterBooks()">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>

                <select class="custom-select mt-3" id="filterAuthor" onchange="filterBooks()">
                    <option value="">Select Author</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->author_id }}">{{ $author->author_name }}</option>
                    @endforeach
                </select>

                {{--<select class="custom-select mt-3">--}}
                    {{--<option selected>Select Rating</option>--}}
                    {{--<option value="1">One</option>--}}
                    {{--<option value="2">Two</option>--}}
                    {{--<option value="3">Three</option>--}}
                {{--</select>--}}
            </div>
        </div>

        <div class="col-md-9 col-lg-10">
            <div class="card-box">
                <h3 style="margin-bottom: 20px;">Browse books</h3>
                <input style="margin-bottom: 20px;" type="text" class="form-control" placeholder="Search" onkeyup="filterBooks()" id="searchBookText">

                <div id="tag_container">
                    @include('MyView.User.Home.books_ajax')
                </div>

            </div>
        </div>
    </div>
@endsection


@section('page_script')

    <script>
        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                }else{
                    getData(page);
                }
            }
        });

        $(document).ready(function()
        {
            $(document).on('click', '.pagination a',function(event)
            {
                event.preventDefault();
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                var myurl = $(this).attr('href');
                var page=$(this).attr('href').split('page=')[1];
                getData(page);
            });
        });

        function getData(page){
            var data = {};

            data['filterCategory'] = $("#filterCategory").val();
            data['filterAuthor']   = $("#filterAuthor").val();
            data['searchtext'] = $("#searchBookText").val();

            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html",
                    data:{
                        filter:data,
                        _token:'{{csrf_token()}}',
                    },
                }).done(function(data)
            {
                $("#tag_container").empty().html(data);
                location.hash = page;
            }).fail(function(jqXHR, ajaxOptions, thrownError)
            {
                alert('No response from server');
            });
        }

        // FILTER BOOKS
        function filterBooks(){
            var data = {};

            data['filterCategory'] = $("#filterCategory").val();
            data['filterAuthor']   = $("#filterAuthor").val();
            data['searchtext'] = $("#searchBookText").val();

            // console.log(data['filterCategory']);

            $.ajax({
                type:'POST',
                url:'{{route('books.filter')}}',
                data:{
                    filter:data,
                    _token:'{{csrf_token()}}'},
                cache: false,
                success:function(data) {
                    $("#tag_container").empty().html(data);
                }
            });
        }
    </script>

@endsection