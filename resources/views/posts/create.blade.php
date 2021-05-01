@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-header"><b>Add new post</b></div>
        <div class="card-body">
            <form method="post" action="{{ route('posts.store') }}">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Post title" name="post_title" required/>
                    <textarea class="form-control mt-2 mb-2" rows="15" required name="post_content" placeholder="Start typing..." ></textarea>
                    <button type="submit" class="btn btn-info btn-sm">Save</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Cancel</a>
                </div>
            </form>
        </div>
    </div>

@endsection
