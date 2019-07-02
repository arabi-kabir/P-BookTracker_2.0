@extends('layouts.site_layout.master')

@section('page_css')

    <link href="{{ asset('public/assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        td{
            padding: 5px !important;
            padding-top: 8px !important;
        }
    </style>

@endsection


@section('content')

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Book</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="modalBody">

                </div>
            </div>
        </div>
    </div>

    <h4 class="page-title">My Uploaded Books</h4>

    {{-- Table --}}
    <div class="card border">
        <div class="card">
            <div class="card-header">
                <h4 class="m-0" style="font-weight: 300; display: inline-flex; padding-top: 6px;">Book List</h4>
                <a class="btn btn-purple waves-effect waves-light btn-sm float-right" href="{{ route('user.book.upload') }}">ADD NEW BOOK</a>
            </div>

            <div class="card-body">
                <table id="datatable" class="table table-hover table-sm" style="text-align: center;border: 1px solid #dddede; width: 100%;">
                    <thead>
                    <tr>
                        <th>Book Name</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('page_script')

    <script src="{{ asset('public/assets/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/pages/form-fileupload.init.js') }}"></script>

    <script>
        $(document).ready(function() {
            dataTable=  $('#datatable').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(0)'
                },
                responsive: true,
                processing: true,
                serverSide: true,
                Filter: true,
                stateSave: true,
                ordering:false,
                type:"POST",
                "ajax":{
                    "url": "{!! route('user.book.my_upload_list.get') !!}",
                    "type": "POST",
                    data:function (d){
                        d._token="{{csrf_token()}}";
                    },
                },
                columns:
                    [
                        { data: 'book_name', name: 'book.book_name' },
                        { data: 'author_name', name: 'book_author.author_name' },
                        { data: 'category_name', name: 'book_category.category_name' },

                        {
                            "data": function(data)
                            {
                                return '<button class="btn btn-icon waves-effect waves-light btn-purple btn-sm mr-2" data-panel-id="'+data.book_id+'" onclick="edit_item(this)"><i class="fa fa-cog"></i></button>'+
                                       '<button class="btn btn-icon waves-effect waves-light btn-danger btn-sm" data-panel-id="'+data.book_id+'" onclick="delete_item(this)"><i class="fa fa-trash"></i></button>';
                            },
                            "orderable": false, "searchable":false, "name":"selected_rows"
                        },
                    ]
            });
        });

        // EDIT
        function edit_item(x) {
            id = $(x).data('panel-id');
            $.ajax({
                type: 'POST',
                url: "{!! route('user.book.edit') !!}",
                cache: false,
                data: {
                    _token: "{{csrf_token()}}",
                    'id': id,
                },
                success: function (data) {
                    $('#modalBody').html(data);
                    $('#editModal').modal('show');
                }
            });
        }

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

                    $.ajax({
                        type: 'POST',
                        url: "{!! route('admin.category.delete') !!}",
                        cache: false,
                        data: {
                            _token: "{{csrf_token()}}",
                            'id': btn
                        },
                        success: function (data) {
                            Swal.fire(
                                'Deleted!',
                                'Category has been deleted.',
                                'success'
                            )
                            dataTable.ajax.reload();
                        }
                    });
                }
            })
        }

    </script>
@endsection