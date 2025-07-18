<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 text-dark">
            {{ __('Edit Blog') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">Edit Blog</div>
                    <div class="card-body">
                        <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $blog->title) }}" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                @if($blog->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/blogs/' . $blog->image) }}" alt="Current Image" class="img-fluid" style="max-height: 200px;">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea name="content" id="content" rows="6" class="form-control" required>{{ old('content', $blog->content) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Blog</button>
                            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
