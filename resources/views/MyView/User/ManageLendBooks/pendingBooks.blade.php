@extends('layouts.site_layout.master')

@section('page_css')
    <link href="{{ asset('public/assets/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')

    {{-- Lend Book Modal --}}
    <div class="modal fade" id="lendModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Lend Someone Book</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="modalBody">
                    <form class="form-horizontal" role="form" method="post" action="{{ route('lend.insert') }}">
                        @csrf

                        <div class="form-group">
                            <select class="form-control" name="book_id" required>
                                <option value="">Select Book *</option>
                                @foreach($availableBooks as $book)
                                    <option value="{{ $book->book_id }}">{{ $book->book_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group ">
                            <input type="text" class="form-control" name="lentToName" placeholder="Lend To (Type Name) *" required>
                        </div>

                        <div class="form-group ">
                            <div class="input-group">
                                <input type="text" class="form-control" id="datepicker-autoclose" name="lendDate" placeholder="Select Lend Date" autocomplete="off">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="input-group">
                                <input type="text" class="form-control" id="datepicker-autoclose2" name="returnDate" placeholder="Select Expected Return Date" autocomplete="off">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-outline-purple btn-sm float-right" type="submit">Lend Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Returned Modal --}}
    <div class="modal fade" id="returnedModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Lend Someone Book</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="modalBody">
                    <form class="form-horizontal" role="form" method="post" action="{{ route('lend.return') }}">
                        @csrf

                        <input type="hidden" name="book_id" value="">

                        <p>Are yoy sure <b><span id="friend"></span></b> returned <b>[ <span id="bookName"></span> ]</b> </p>

                        <div class="form-group ">
                            <div class="input-group">
                                <input type="text" class="form-control" id="datepicker-autoclose3" name="returnDate" placeholder="Select Return Date" autocomplete="off" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-outline-purple btn-sm float-right" type="submit">Yes Returned</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border mt-3">
        <div class="card">
            <div class="card-header">
                <h4 style="display: inline-flex; font-weight: 100;">Lend Book [ Pending ]</h4>
                <button class="btn btn-purple btn-sm" style="float: right;" href="" data-toggle="modal" data-target="#lendModal">Lend Someone Book</button>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-sm table-hover" style="text-align: center;border: 1px solid #dddede; width: 100%;">
                    <thead>
                    <tr>
                        <th>Book Name</th>
                        <th>Lent To</th>
                        <th>Return Date</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lendBooks as $book)
                        <tr>
                            <td><a href="{{ route('book.details', ['id' => $book->book_id]) }}">{{ $book->book_name }}</a> </td>
                            <td>{{ $book->lent_to }}</td>
                            <td>{{ $book->expected_return_date }}</td>
                            <td>{{ $book->category_name }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-lighten-success waves-effect  width-md waves-success btn-sm" data-panel-id="{{ $book }}" onclick="add_to_returned(this)"> <i class="fa fa-check"></i> Returned </button>
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

            $('#datepicker-autoclose').datepicker({
                format: 'mm/dd/yyyy',
                orientation: "top left",
                autoclose: true,
                todayHighlight: true,
            });

            $('#datepicker-autoclose2').datepicker({
                format: 'mm/dd/yyyy',
                orientation: "top left",
                autoclose: true,
                todayHighlight: true,
            });

            $('#datepicker-autoclose3').datepicker({
                format: 'mm/dd/yyyy',
                orientation: "top left",
                autoclose: true,
                todayHighlight: true,
            });

        } );

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
                        url: "{!! route('wishlist.change') !!}",
                        cache: false,
                        data: {
                            _token: "{{csrf_token()}}",
                            'book_id': id,
                            'value': 'wish',
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
            })
        }

        function add_to_returned(x) {
            book = $(x).data('panel-id');

            $('input[name="book_id"]').val(book.book_id);

            $('#friend').html(book.lent_to);
            $('#bookName').html(book.book_name);

            $('#returnedModal').modal('show');
        }

    </script>
@endsection