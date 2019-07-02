
@foreach($users as $user)
    <div class="col-xl-3 col-md-6">
        <div class="card-box" style="padding: 10px;">
            <div class="row">
                <div class="col-md-5">
                    <img src="{{ asset('public/files/profileImage/'. $user->profile_image) }}" class="img-fluid img-thumbnail" alt="user" style="width: 150px; height: 112px;">
                </div>
                <div class="col-md-7">
                    <h5 class="mt-0">{{ $user->name }}</h5>
                    <p class="text-muted mb-1 font-13 text-truncate">{{ $user->email }}</p>
                    @if($user->designation != "")
                        <small class="text-info"><b>{{ $user->designation }}</b></small>
                    @else
                        <div style="margin-top: 40px;"></div>
                    @endif
                    <button class="btn btn-xs btn-purple btn-block mt-2" onclick="sendFollow({{ $user->id }})" id="{{ $user->id }}">Sent Follow Request</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{--{!! $users->links() !!}--}}