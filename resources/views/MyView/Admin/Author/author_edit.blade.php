
<form method="post" action="{{ route('admin.author.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $author->author_id }}">

    <div class="form-group">
        <label class="col-form-label" for="simpleinput">Author Name</label>
        <div>
            <input type="text" id="simpleinput" class="form-control" value="{{ $author->author_name }}"  name="name" required>
        </div>
    </div>

    <img src="{{ asset('public/files/author_image/'.$author->author_photo) }}" width="100%" height="auto" alt="">

    <div class="form-group">
        <label class="col-form-label" for="simpleinput">Change Author Photo</label>
        <input type="file" class="dropify" data-max-file-size="2M" name="photo" />
    </div>

    <button type="submit" class="btn btn-primary float-right">UPDATE</button>
</form>

<script src="{{ asset('public/assets/js/pages/form-fileupload.init.js') }}"></script>