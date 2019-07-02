@extends('layouts.site_layout.master')

@section('page_css')

    <link href="{{ asset('public/assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />



@endsection


@section('content')

    {{-- Pending List --}}
    <h4 style="font-weight: 100; margin-top: 20px;">Pending List</h4>
    <div class="row mt-3" id="pendinglist_space"></div>


    <hr style="border-top: 1px solid #e0dbdb;">


    {{-- User List --}}
    <h4 style="font-weight: 100;">User List</h4>
    <div class="row mt-3" id="userlist_space"></div>

@endsection

@section('page_script')

    <script src="{{ asset('public/assets/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/pages/form-fileupload.init.js') }}"></script>

    <script>

    getUselist();
    getPendinglist();

    // SET TIMER TO REFRESH
    setInterval(function () {

        getUselist();
        getPendinglist();

    }, 5000);

    function sendFollow(user_id) {
        $.ajax({
            type: 'POST',
            url: "{!! route('request.insert') !!}",
            cache: false,
            data: {
                _token: "{{csrf_token()}}",
                'user_id': user_id,
            },
            success: function (data) {

                getUselist();
                getPendinglist();

                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Follow Request Sent.',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        });
    }

    function cancelFollow(user_id) {
        $.ajax({
            type: 'POST',
            url: "{!! route('request.cancel') !!}",
            cache: false,
            data: {
                _token: "{{csrf_token()}}",
                'user_id': user_id,
            },
            success: function (data) {

                getUselist();
                getPendinglist();

                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Follow Request Cancelled.',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        });
    }

    // GET USELIST AJAX
    function getUselist(){
        $.ajax({
            type: 'POST',
            url: "{!! route('userlist.getlist') !!}",
            cache: false,
            data: {
                _token: "{{csrf_token()}}",
            },
            success: function (data) {
                $('#userlist_space').html(data);
            }
        });
    }

    // GET PENDING AJAX
    function getPendinglist(){
        $.ajax({
            type: 'POST',
            url: "{!! route('pending.getlist') !!}",
            cache: false,
            data: {
                _token: "{{csrf_token()}}",
            },
            success: function (data) {
                $('#pendinglist_space').html(data);
            }
        });
    }


    // AJAX PAGINATION
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
        $.ajax(
            {
                url: '?page=' + page,
                type: "get",
                datatype: "html",
                data:{
                    _token:'{{csrf_token()}}',
                },
            }).done(function(data)
        {
            $("#userlist_space").empty().html(data);
            location.hash = page;
        }).fail(function(jqXHR, ajaxOptions, thrownError)
        {
            alert('No response from server');
        });
    }





    </script>
@endsection