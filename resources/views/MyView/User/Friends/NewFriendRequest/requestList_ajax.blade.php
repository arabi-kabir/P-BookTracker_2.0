@if($pendingFriends->count() > 0 )
    @foreach($pendingFriends as $user)
        <div class="col-xl-2 col-md-3">
            <div class="card-box" style="padding: 10px;">
                <div class="">
                    <div class="col-md-12">
                        <img src="{{ asset('public/files/profileImage/'. $user->profile_image) }}" class="img-fluid img-thumbnail" alt="user" style="width: 100%; height: auto;">
                    </div>
                    <div class="col-md-12" style="text-align: center">
                        <h5 class="mt-2">{{ $user->name }}</h5>
                        <p class="text-muted mb-1 font-13 text-truncate">{{ $user->email }}</p>
                        @if($user->designation != "")
                            <small class="text-info"><b>{{ $user->designation }}</b></small>
                        @else
                            <div style="margin-top: 40px;"></div>
                        @endif
                    </div>

                    <div class="container-fluid" style="padding-right: 0px; padding-left: 0px;">
                        <button class="btn btn-xs btn-success btn-block mt-2" onclick="acceptFollow({{ $user->id }})" id="{{ $user->id }}">Accept Request</button>
                        <button class="btn btn-xs btn-danger btn-block mt-2" onclick="cancelFollow({{ $user->id }})" id="{{ $user->id }}">Reject Request</button>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="alert alert-info btn-block">
        No New Request.
    </div>
@endif