<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Intervention\Image\Facades\Image;  
use Illuminate\Support\Facades\Storage;
 


class HomeController extends Controller           
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {       $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $user = Auth::user();
        // $posts = Post::latest()->get();    
        //  return view('home',compact('user','posts'));  
        $posts = Post::whereIn('user_id', function($query)
        {       
            $query->select('follower_id')
                    ->from('followers')
                    ->where('following_id', Auth::user()->id);
        })->orWhere('user_id', Auth::user()->id)
            ->with('user')
            ->orderBy('updated_at', 'DESC')->get();

        return view('home',compact('user','posts'));   
    } 

    function save_likedislike(Request $request){
        $data=new LikeDislike;
        $data->post_id=$request->post;
        if($request->type=='like'){
            $data->like=1;
        }else{
            $data->dislike=1;
        }
        $data->save();
        return response()->json([
            'bool'=>true
        ]);
    }

    // public function pressLike(Request $request)
    // {
    //     $post = Post::find($request->post_id);
    //     dd($post);
    //     if($post->like->contains('user_id',auth()->id())){
    //         $post->like()->where('user_id',auth()->id()->delete());                          
    //     }else{
    //         $post->like()->create(['user_id'=>auth()->id()]);
    //     }
    //     return response()->json(['like'=>$post->like()->count()]);
    // }  
 
}
