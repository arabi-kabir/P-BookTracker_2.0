@extends('layouts.site_layout.master')

@section('page_css')

@endsection


@section('content')

    <h4 class="page-title">Currently Reading Books</h4>

    {{-- Table --}}
    <div class="card border">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-sm table-hover" style="text-align: center;border: 1px solid #dddede; width: 100%;">
                    <thead>
                        <tr>
                            <th>Book Name</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($readingBooks as $book)
                            <tr>
                                <td><a href="{{ route('book.details', ['id' => $book->book_id]) }}">{{ $book->book_name }}</a> </td>
                                <td>{{ $book->category_name }}</td>
                                <td>{{ $book->author_name }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-lighten-danger waves-effect  width-md waves-danger btn-sm mr-2" data-panel-id="{{ $book->book_id }}" onclick="delete_item(this)"> <i class="fa fa-trash"></i> Remove </button>
                                    <button type="button" class="btn btn-sm btn-lighten-success waves-effect  width-md waves-success btn-sm" data-panel-id="{{ $book->book_id }}" onclick="add_to_complete(this)"> <i class="fa fa-check"></i> Add to Complete </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('page_script')


    <script>

        $(document).ready( function () {

            $('#datatable').DataTable({
                responsive: true,
                processing: true,
                Filter: true,
            });

        } );

        // DELETE
        function delete_item(x) {
            btn = $(x).data('panel-id');

            Swal.fire({
                title: 'Are you sure want to remove from currently reading list?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.value) {

                    id = $(x).data('panel-id');

                    $.ajax({
                        type: 'POST',
                        url: "{!! route('reading.change') !!}",
                        cache: false,
                        data: {
                            _token: "{{csrf_token()}}",
                            'book_id': id,
                            'value': 'read',
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
            })
        }

        function add_to_complete(x) {
            btn = $(x).data('panel-id');

            Swal.fire({
                title: 'Are you sure want to add this book to complete list?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, add it!'
            }).then((result) => {
                if (result.value) {

                    id = $(x).data('panel-id');

                    $.ajax({
                        type: 'POST',
                        url: "{!! route('reading.change2complete') !!}",
                        cache: false,
                        data: {
                            _token: "{{csrf_token()}}",
                            'book_id': id,
                            // 'value': 'wish',
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
            })
        }


    </script>
@endsection