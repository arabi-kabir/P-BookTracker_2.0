
@foreach($reviews as $review)

    <div class="media mb-3">
        <div class="d-flex mr-3">
            <a href="#"> <img class="media-object rounded-circle avatar-sm" alt="64x64" src="{{ asset('public/assets/images/users/user-1.jpg') }}"> </a>
        </div>
        <div class="media-body">
            <h5 class="mt-0">{{ $review->name }}</h5>
            <p class="font-13 text-muted mb-0">
                {{ $review->review }}
            </p>
        </div>
    </div>

@endforeach