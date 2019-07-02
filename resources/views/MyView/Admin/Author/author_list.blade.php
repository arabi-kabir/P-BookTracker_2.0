@extends('layouts.site_layout.master')


@section('page_css')
    <link href="{{ asset('public/my_assets/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        td{
            padding: 5px !important;
            padding-top: 8px !important;
        }
    </style>
@endsection


@section('content')

    {{-- Insert Modal --}}
    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Add new author</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('admin.author.insert') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label" for="simpleinput">Author Name</label>
                            <div>
                                <input type="text" id="simpleinput" class="form-control" name="name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label " for="simpleinput">Author Photo</label>
                            <input type="file" class="dropify" data-max-file-size="2M" name="photo" />
                        </div>

                        <button type="submit" class="btn btn-primary float-right">INSERT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

     {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="modalBody">

                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border border-secondary" style="margin-top: 50px;">
        <div class="card">
            <div class="card-header">
                <h4 class="m-0" style="font-weight: 300; display: inline-flex; padding-top: 6px;">Author List</h4>
                <button class="btn btn-purple waves-effect waves-light btn-sm float-right" data-toggle="modal" data-target=".bs-example-modal-center">Add new authoor</button>
            </div>

            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive" style="text-align: center;">
                    <thead>
                    <tr>
                        <th>Author Name</th>
                        <th>Uploader</th>
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

    {{--<script src="{{ asset('public/my_assets/datatable/js/jquery-3.3.1.js') }}"></script>--}}
    <script src="{{ asset('public/my_assets/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/my_assets/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
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
                    "url": "{!! route('admin.author.list.getData') !!}",
                    "type": "POST",
                    data:function (d){
                        d._token="{{csrf_token()}}";
                    },
                },
                columns:
                    [
                        { data: 'author_name', name: 'book_author.author_name' },
                        { data: 'name', name: 'users.name' },

                        {
                            "data": function(data)
                            {
                                return '<button class="btn btn-icon waves-effect waves-light btn-purple btn-sm mr-2" data-panel-id="'+data.author_id+'" onclick="edit_item(this)"><i class="fa fa-cog"></i></button>'+
                                       '<button class="btn btn-icon waves-effect waves-light btn-danger btn-sm" data-panel-id="'+data.author_id+'" onclick="delete_item(this)"><i class="fa fa-trash"></i></button>';
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
                url: "{!! route('admin.author.edit') !!}",
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