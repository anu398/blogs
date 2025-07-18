<x-app-layout>
    @section('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Blogs') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('blogs.create') }}" class="mb-4 btn btn-sm btn-primary">
                + New Blog
            </a>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <table id="blogs-table" class="display w-full">
                    <thead>
                        <tr>
                            <th>S. No:</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $index => $blog)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $blog->title }}</td>
                                <td>{{ $blog->content }}</td>
                                <td>
                                @if($blog->status === \App\Models\Blog::STATUS_PENDING)
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($blog->status === \App\Models\Blog::STATUS_PUBLISHED)
                                    <span class="badge bg-success">Published</span>
                                @elseif($blog->status === \App\Models\Blog::STATUS_REJECTED)
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                                <td>
                                    @if ($blog->image)
                                    <img src="{{ asset('storage/blogs/' . $blog->image) }}" alt="Blog Image" style="max-width: 100px; height: auto;">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>{{ $blog->created_at->format('Y-m-d') }}</td>
                                <td>
                                     @if(Auth::guard('web')->check())
                                        @if ($blog->status !== \App\Models\Blog::STATUS_PUBLISHED)
                                            <a href="{{ route('blogs.edit', $blog) }}" class="btn btn-sm btn-primary" title="Edit Blog">
                                                <i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('blogs.destroy', $blog) }}" method="POST" class="inline-block ml-2"
                                                onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mt-1" title="Delete Blog"> <i class="bi bi-trash"></i> </button>
                                            </form>
                                        @endif
                                    @elseif(Auth::guard('admin')->check())
                                     <button type="button" class="btn btn-sm btn-warning" title="Update Blog Status" 
                                        data-bs-toggle="modal" data-bs-target="#update-status-{{$blog->id}}">
                                              Change Status
                                        </button>
                                         <a href="{{ route('admin.blogs.view', $blog->id) }}" class="btn btn-primary btn-sm px-4 shadow-sm">
                                            View More
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <div class="modal fade" id="update-status-{{$blog->id}}"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel"> Update Blog Status</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12 m-1">
                                                        <label class="form-label fw-bold">Status</label>
                                                           <select name="status" id="status-{{$blog->id}}" class="form-select" >
                                                               <option value="{{ \App\Models\Blog::STATUS_PENDING }}" 
                                                                    {{ $blog->status === \App\Models\Blog::STATUS_PENDING ? 'selected' : '' }}>
                                                                    Pending
                                                                </option>
                                                                <option value="{{ \App\Models\Blog::STATUS_PUBLISHED }}" 
                                                                    {{ $blog->status === \App\Models\Blog::STATUS_PUBLISHED ? 'selected' : '' }}>
                                                                    Published
                                                                </option>
                                                                <option value="{{ \App\Models\Blog::STATUS_REJECTED }}" 
                                                                    {{ $blog->status === \App\Models\Blog::STATUS_REJECTED ? 'selected' : '' }}>
                                                                    Rejected
                                                                </option>
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" onclick="updateStatus({{ $blog->id }})">Update</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
        <!-- jQuery & DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#blogs-table').DataTable();
            });
    

        // // Submit form via AJAX
         function updateStatus(blogId){
            let url =  `/admin/blogs/${blogId}/status`;
            let status = $('#status-'+blogId).val();
            
            $('#update-status-'+blogId).modal('hide');
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    id: blogId,
                    status:status,
                    _token: '{{ csrf_token() }}'
                },
                success:function (data) {
                    // var table1 = $('#blogs-table').DataTable();
                    // table1.ajax.reload(null, false);
                        location.reload();
                    alert('Blog Status updated successfully.');

                }
            });
        }

        </script>
    @endsection
</x-app-layout>
