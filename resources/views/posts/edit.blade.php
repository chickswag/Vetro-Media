@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header"><b>Edit {{$post['title']}}</b></div>
        <div class="card-body">
            {{ Form::open(array('route' => array('posts.update', $post->id), 'method' => 'post')) }}
            @method('PUT')
            @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Post title" name="post_title" value="{{$post['title']}}" required/>
                    <textarea class="form-control mt-2 mb-2" required name="post_content" placeholder="Start typing..." >{{$post['content']}}</textarea>
                    <button type="submit" class="btn btn-info btn-sm">Save</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Cancel</a>
                </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection

