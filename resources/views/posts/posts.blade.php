@extends('layouts.app')
@section('content')
                    <div class="card">
                        <div class="card-header"><b>List Posts</b></div>
                        @if(Auth::id())
                        <div class="card-body">
                            create new post
                            <a class="btn btn-primary btn-sm" href="{{ route('posts.create')}}" ><i class="fa fa-plus"></i></a>
                        </div>
                        @endif
                        @if($posts->count())
                            @foreach($posts as $post)
                                <div class="card p-2 m-2">
                                    <div class="card-header">{{ $post->title }}</div>
                                    <div class="card-body">
                                        <div class="card-text">
                                            {{ $post->content }}
                                        </div>
                                        <div class="text-black-50 float-right font-italic">

                                            <blockquote>created by <u>{{$post->getUserName->name }}</u><br/>
                                                {{$post->created_at->format("Y m d ") }}
                                            </blockquote>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-16">This post has {{$post->average_rating}} votes</div>
                                            @if(Auth::id())
                                                @if(Auth::id() && $post->created_by != Auth::id())
                                                <div class="col-16 d-flex justify-content-start flex-wrap">
                                                        @for($index = 0; $index < 5; $index ++)
                                                            <form method="post" action="{{ route('rating') }}">
                                                                @csrf
                                                                <button type="submit" name="post_id" value="{{$post->id}}" class="btn btn-outline-dark" title="RATE"><i class="fa fa-star " style="color: #091b3e; font-size: 10px"></i></button>
                                                                <input type="hidden" name="rating" value="{{$index+1}}"/>
                                                            </form>
                                                        @endfor
                                                </div>

                                                @endif

                                            @else
                                                <div> <a href="{{route('login')}}" class="btn" title="LOGIN TO RATE POST">
                                                        {{$post->average_rating}}</a>
                                                </div>


                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-start flex-wrap table-dark ">

                                            @if ($post->created_by == Auth::id())
                                                <div class="p-2">
                                                    <a href="{{ route('posts.edit',$post->id) }}" class="btn btn-success btn-sm">Edit</a>
                                                </div>
                                                <div class="p-2">
                                                    {{ Form::open(array('route' => array('posts.destroy', $post->id), 'method' => 'delete')) }}
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                    {{ Form::close() }}
                                                </div>
                                            @endif


                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        @else
                            <div class="card-body">Posts no found</div>
                        @endif
                        {{ $posts->links() }}
                    </div>
                </div>
@endsection
