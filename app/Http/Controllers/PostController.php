<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use App\Models\RatingModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = PostModel::paginate(2);
        $index = 0;
        $rating_color =[1=>"#091b3e",2=>"#0f6674;",3=>"#8d0404",4=>"#1aaa3b",5=>"#e5c712"];
        return view('posts.posts',compact('posts','index','rating_color'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if(Auth::check())
        {
            return view('posts.create');
        }
        else{
            return redirect()->back()->with('error', 'You are not authorised to view this page');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Auth::check())
        {

            request()->validate(['post_content' => 'required|unique:posts,content',
                                'post_title' => 'required|unique:posts,title']);
            $post_data =  $request->all();
            $post = new PostModel();
            $post->title = $post_data['post_title'];
            $post->content = $post_data['post_content'];
            $post->created_by = Auth::id();
            $post->save();
            return redirect('/posts')->with('success', 'Post Created!');
        }
        else{
            return redirect()->back()->with('error', 'You are not authorised to view this page');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()) {
            $post = PostModel::find($id);
            if(Auth::id() == $post['created_by']){
                return view('posts.edit', compact('post'));
            }
            else{
                return redirect('posts')->with('error', 'You are not the owner of this post');
            }

        }
        else
        {
            return redirect()->back()->with('error', 'Access denied');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::check()) {
            request()->validate(['post_content' => 'required',
                'post_title' => 'required']);
            $post_data =  $request->all();
            $post = PostModel::find($id);
            $post->title = $post_data['post_title'];
            $post->content = $post_data['post_content'];
            $post->save();
            return redirect('/posts')->with('success', 'Post Updated Successfully!');
        }
        else
        {
            return redirect()->back()->with('error', 'Access denied');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()) {
            $post = PostModel::find($id);
            if(Auth::id() == $post['created_by']){
                PostModel::destroy($id);
                return redirect('/posts')->with('success', 'Post deleted!');
            }
            else{
                return redirect('posts')->with('error', 'You are not the owner of this post');
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Access denied');
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postRate(Request $request){
        if(Auth::check()) {
            $data = $request->all();
            $post_id = (int)$data['post_id'];
            $rating = (int)$data['rating'];

            $rating_post = new RatingModel();
            $rating_post->comment = "hello";
            $rating_post->rating = $rating;
            $rating_post->user_id = auth()->user()->id;
            $rating_post->post_id = $post_id;
            $rating_post->save();

            $captured = RatingModel::where(['post_id' =>$post_id])->get();
            $total_voters = $captured->groupBy('user_id')->count();
            $total_ratings = $captured->sum('rating');
            $average = $total_ratings/$total_voters;

            PostModel::find($post_id)->update(['average_rating'=> $average]);

            return redirect('/posts')->with('success', 'Comment with rating posted');
        }
        else{
            return redirect()->back()->with('error', 'Access denied');
        }
    }
}
