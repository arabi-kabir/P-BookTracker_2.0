@extends('layouts.site_layout.master')

@section('page_css')

    <link href="{{ asset('public/assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />

@endsection


@section('content')

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Update Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="modalBody">
                    <form class="form-horizontal" role="form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="" name="id">
                        <div class="row">
                            <div class="container-fluid" style="max-width: 97%;">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> <i class="fas fa-user"></i> </span>
                                    </div>
                                    <input name="name" value="{{ $profile->name }}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Name">
                                </div>

                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> <i class="fa fa-sms"></i> </span>
                                    </div>
                                    <input name="email" value="{{ $profile->email }}" type="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Email">
                                </div>

                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> <i class="fas fa-address-card"></i> </span>
                                    </div>
                                    <input value="{{ $profile->designation }}" name="designation" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Designation">
                                </div>

                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> <i class="fas fa-biohazard"></i> </span>
                                    </div>
                                    <input name="Password" type="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Set New Password">
                                </div>

                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> <i class="fas fa-biohazard"></i> </span>
                                    </div>
                                    <input name="Confirm_Password" type="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Confirm Password">
                                </div>

                                <div class="input-group input-group-sm mb-3">
                                    <textarea class="form-control" placeholder="Your Short Description" rows="4" name="profile_desc">{{ $profile->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Change Profile Image</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file" class="dropify" data-max-file-size="2M" name="photo" />
                                        </div>
                                        <div class="col-md-6">
                                            @if($profile->profile_image)
                                                <img src="{{ asset('public/files/profileImage/'. $profile->profile_image) }}" class="img-thumbnail" src="" width="100%" height="auto" alt="Old Profile Photo">
                                            @else
                                                <img src="{{ asset('public/files/profileImage/avatar.png') }}" class="img-thumbnail" src="" width="100%" height="auto" alt="Old Profile Photo">
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-outline-dark btn-xs btn-block float-right" type="submit">SAVE CHANGES</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <div class="bg-picture card-box">
            <div class="row">
                <div class="col-md-6">
                    <div class="profile-info-name">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset('public/files/profileImage/'. $profile->profile_image) }}" class="img-thumbnail mb-2" alt="profile-image" style="width: 100%;" width="100%;">

                                <button class="btn btn-xs btn-outline-purple btn-block" data-toggle="modal" data-target="#editModal">Update Profile</button>

                            </div>

                            <div class="col-md-8">
                                <div class="profile-info-detail overflow-hidden">
                                    <h4 class="m-0">{{ $profile->name }}</h4>
                                    <p class="text-muted mt-2"><i></i>{{ $profile->designation }}</p>
                                    <p class="font-13">{{ $profile->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <table class="table table-bordered table-sm table-hover">
                        <tr>
                            <th>My Uploaded Books</th>
                            <td style="text-align: center;">{{ $Uploadedbooks }}</td>
                        </tr>
                        <tr>
                            <th>Collected Books</th>
                            <td style="text-align: center;">{{ $collectedBooks }}</td>
                        </tr>
                        <tr>
                            <th>Completed Books</th>
                            <td style="text-align: center;">{{ $completeBooks }}</td>
                        </tr>
                        <tr>
                            <th>Wishlist</th>
                            <td style="text-align: center;">{{ $wishlistBooks }}</td>
                        </tr>
                        <tr>
                            <th>Currently Reading</th>
                            <td style="text-align: center;">{{ $readingBooks }}</td>
                        </tr>
                        <tr>
                            <th>lend Pending</th>
                            <td style="text-align: center;">{{ $lendBook }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('page_script')

    <script src="{{ asset('public/assets/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/pages/form-fileupload.init.js') }}"></script>

    <script>



    </script>
@endsection