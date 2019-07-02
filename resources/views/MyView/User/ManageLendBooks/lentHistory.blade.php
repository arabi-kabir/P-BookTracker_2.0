@extends('layouts.site_layout.master')

@section('page_css')
    <link href="{{ asset('public/assets/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')


    {{-- Table --}}
    <div class="card border mt-3">
        <div class="card">
            <div class="card-header">
                <h4 style="display: inline-flex; font-weight: 100;">Lend Book [ History ]</h4>
                {{--<button class="btn btn-purple btn-sm" style="float: right;" href="" data-toggle="modal" data-target="#lendModal">Lend Someone Book</button>--}}
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-sm table-hover" style="text-align: center;border: 1px solid #dddede; width: 100%;">
                    <thead>
                    <tr>
                        <th>Book Name</th>
                        <th>Lent To</th>
                        <th>Expected Return Date</th>
                        <th>Returned Date</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lentBooks as $book)
                        <tr>
                            <td><a href="{{ route('book.details', ['id' => $book->book_id]) }}">{{ $book->book_name }}</a> </td>
                            <td>{{ $book->lent_to }}</td>
                            <td>{{ $book->expected_return_date }}</td>
                            <td>{{ $book->returned_date }}</td>
                            <td>{{ $book->category_name }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-lighten-danger waves-effect width-md waves-danger btn-sm" data-panel-id="{{ $book->book_id }}" onclick="add_to_pending(this)"> <i class="fa fa-check"></i> Set Pending </button>
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

    <script src="{{ asset('public/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>


    <script>

        $(document).ready( function () {

            $('#datatable').DataTable({
                responsive: true,
                processing: true,
                Filter: true,
            });

            // $('#datepicker-autoclose').datepicker({
            //     format: 'mm/dd/yyyy',
            //     orientation: "bottom left",
            //     // setDate: new Date(),
            //     autoclose: true,
            //     todayHighlight: true,
            // });
            //
            // $('#datepicker-autoclose2').datepicker({
            //     format: 'mm/dd/yyyy',
            //     orientation: "bottom left",
            //     // setDate: new Date(),
            //     autoclose: true,
            //     todayHighlight: true,
            // });

        } );

        // DELETE
        function add_to_pending(x) {
            btn = $(x).data('panel-id');

            Swal.fire({
                title: 'Are you sure want to set it as Pending?',
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
                        url: "{!! route('lend.setPending') !!}",
                        cache: false,
                        data: {
                            _token: "{{csrf_token()}}",
                            'book_id': id,
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