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
    <div class="container mt-4">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white p-4" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); border-radius: 1rem 1rem 0 0;">
                <h2 class="mb-0 fw-bold">{{ $blog->title }}</h2>
            </div>
            <div class="card-body bg-light p-4 rounded-bottom-4">
                @if($blog->image)
                    <img src="{{ asset('storage/blogs/' . $blog->image) }}" alt="Blog Image" 
                        class="img-fluid rounded mb-4 shadow-sm" 
                        style="max-height: 300px; object-fit: cover; width: 100%;">
                @endif

                <p class="fs-5 text-secondary" style="white-space: pre-line;">{!! e($blog->content) !!}</p>
                @if(Auth::guard('web')->check())
                    <a href="{{ route('blogs.index') }}" class="btn btn-gradient btn-lg mt-4 text-white" 
                    style="background: linear-gradient(90deg, #ff7e5f, #feb47b); border: none; box-shadow: 0 4px 15px rgba(255, 126, 95, 0.4);">
                        ← Back to Blogs
                    </a>
                @else
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-gradient btn-lg mt-4 text-white" 
                    style="background: linear-gradient(90deg, #ff7e5f, #feb47b); border: none; box-shadow: 0 4px 15px rgba(255, 126, 95, 0.4);">
                        ← Back to Blogs
                    </a>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>

