@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('posts.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter title here">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="">Body</label>
                            <textarea name="body" id="" class="form-control" placeholder="Enter text body"></textarea>
                        </div>


                        <div class="form-group mt-3">
                            <button class="btn btn-info">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection