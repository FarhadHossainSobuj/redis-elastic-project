@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-4">
                <!-- <h2>Posts List</h2> -->
                <a class="btn btn-info" href="{{ route('posts.index') }}">All Post</a>
                <a class="btn btn-primary" href="{{ route('posts.create') }}">Create New Post</a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('search.posts') }}" method="GET" class="form-inline mb-3">
                <div class="form-group mb-2">
                    <input type="text" name="query" class="form-control" placeholder="Search posts...">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Search</button>
            </form>

            <!-- Display Success Message -->
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif

            <!-- Posts Table -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($post->body, 100) }}</td>
                        <td>
                            <a class="btn btn-info" href="{{ route('posts.show', $post->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('posts.edit', $post->id) }}">Edit</a>

                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
        </div>
    </div>
</div>
@endsection