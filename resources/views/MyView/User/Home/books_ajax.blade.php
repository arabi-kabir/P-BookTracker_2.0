
<div class="row">
    @foreach($books as $book)
        <div class="col-sm-4 col-md-3 col-lg-2 mb-2">
            <a href="{{ route('book.details', ['id' => $book->book_id]) }}" target="_blank">
                <div class="card">
                    <div class="card border ">
                        <img class="card-img-top img-fluid" src="{{ asset('public/files/book_image/'.$book->book_image) }}" width="100%" height="100px;" alt="Card image cap">
                        <div class="card-body" style="height:122px; text-align: center; padding-left: 2px;padding-right: 2px">
                            <h4 style="font-weight: 200; font-size: 15px;" class="card-title">{{ $book->book_name }}</h4>
                            <p>{{ $book->author_name }}</p>
                            {{--<a href="#" class="btn btn-primary">Button</a>--}}

                            {{--<div id="rating-div" style="text-align: center;">--}}
                                {{--<span class="fa fa-star checked"></span>--}}
                                {{--<span class="fa fa-star checked"></span>--}}
                                {{--<span class="fa fa-star checked"></span>--}}
                                {{--<span class="fa fa-star"></span>--}}
                                {{--<span class="fa fa-star"></span>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

{!! $books->links() !!}
