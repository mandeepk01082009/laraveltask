@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="/storage/{{ $user->profile->image }}" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-5">    
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                    <div class="h4"> {{ $user->username}}</div>
                    @if(Auth::check() && Auth::id() !== $user->id)
                    <button class="btn btn-primary ms-4">Follow</button>
                    @endif
                </div>   
                
                 @can ('update', $user->profile)
                <a href="/p/create">Add New Post</a>
                @endcan    
            </div>

                @can ('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
                @endcan

            <div class="d-flex">
                <div class="px-1"><strong>{{ $user->posts->count() }}</strong> posts</div>
                <div class="px-5"><strong>132K</strong> followers</div>
                <div class="px-3"><strong>386</strong> following</div>
            </div>
            <div class="pt-4"><b>{{ $user->profile->title }}</b></div>
            <div>{{ $user->profile->description }}
            <div><a href="#">{{ $user->profile->url }}</a></div>
            </div>
        </div>
    </div>

    <div class="row pt-5">
        @foreach($user->posts as $post)
        <!-- <div id="post_container_{{$post->id}}" data-id="{{$post->id}}" class="row waypoint">
    </div> -->
        <div class="col-4 pb-4">
            <a href="/p/{{$post->id}}">
                <img src = "{{asset('storage/' . $post->image) }}" class="w-100" style="max-width:400; height:400px;"> 
            </a>
        </div>
        @endforeach

    </div>
    <div class="row pt-5">
        @foreach($user->posts as $post)
        <div class="col-4 pb-4">
            <a href="/p/{{$post->id}}">
                <video controls src = "{{asset('storage/' . $post->video) }}" class="w-100" style="max-width:400; height:500px;" ></video>  
            </a>
        </div>
        @endforeach

    </div>
</div>
@endsection
