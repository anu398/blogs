<x-app-layout>
     @section('styles')
        <!-- DataTables CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blogs') }}
        </h2>
    </x-slot>
    <style>
        .fixed-card-image {
            height: 180px;
            object-fit: cover; 
            width: 100%;
        }
    </style>
   <div class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4 text-primary text-center fw-bold">Published Blogs</h2>

        @if ($blogs->count())
            <div class="row">
                @foreach ($blogs as $blog)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow rounded border-0 blog-card">
                            @if($blog->image)
                                <img src="{{ asset('storage/blogs/' . $blog->image) }}" class="card-img-top img-fluid" alt="{{ $blog->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/350x200?text=No+Image" class="card-img-top img-fluid" alt="No image" style="height: 200px; object-fit: cover;">
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-semibold text-dark" title="{{ $blog->title }}">{{ \Illuminate\Support\Str::limit($blog->title, 50) }}</h5>
                                <p class="card-text text-muted flex-grow-1" style="font-size: 0.95rem;">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($blog->content), 120) }}
                                </p>
                                <div class="text-center mt-auto">
                                    @if(Auth::guard('web')->check())
                                        <a href="{{ route('blogs.view', $blog->id) }}" class="btn btn-outline-primary btn-sm px-4 shadow-sm">
                                            View More
                                        </a>
                                    @else
                                        <a href="{{ route('admin.blogs.view', $blog->id) }}" class="btn btn-outline-primary btn-sm px-4 shadow-sm">
                                            View More
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center">
                No published blogs available.
            </div>
        @endif
    </div>
</div>

</x-app-layout>
