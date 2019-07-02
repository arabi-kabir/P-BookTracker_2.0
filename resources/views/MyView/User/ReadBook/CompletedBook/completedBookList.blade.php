@extends('layouts.site_layout.master')

@section('page_css')

    <style>
        .btn-group-sm > .btn, .btn-sm {
            line-height: 0.5 !important;
        }
        .img-fluid {
             max-width: 100px !important;
             height: 100px !important;
         }

    </style>

@endsection


@section('content')

    <h4 class="page-title">My Completed Books</h4>

    {{-- Table --}}
    <div class="card border">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-sm table-hover" style="text-align: center;border: 1px solid #dddede; width: 100%;">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Book Cover</th>
                            <th>Book Name</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completeBooks as $book)
                            <tr id="make-center">
                                <td style="text-align: left;">
                                    <img class="card-img-top img-fluid" src="{{ asset('public/files/book_image/'.$book->book_image) }}" width="100%" height="100px;" alt="Card image cap">
                                </td>
                                <td class="align-middle"><a href="{{ route('book.details', ['id' => $book->book_id]) }}">{{ $book->book_name }}</a> </td>
                                <td class="align-middle">{{ $book->category_name }}</td>
                                <td class="align-middle">{{ $book->author_name }}</td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-lighten-danger waves-effect  width-md waves-danger btn-sm" data-panel-id="{{ $book->book_id }}" onclick="delete_item(this)"> <i class="fa fa-trash"></i> Remove </button>
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

        $("#make-center").css({"vertical-align": "center"});

        // DELETE
        function delete_item(x) {
            btn = $(x).data('panel-id');

            Swal.fire({
                title: 'Are you sure want to delete?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {

                    id = $(x).data('panel-id');

                    $.ajax({
                        type: 'POST',
                        url: "{!! route('complete.change') !!}",
                        cache: false,
                        data: {
                            _token: "{{csrf_token()}}",
                            'book_id': id,
                            'value': 'complete',
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