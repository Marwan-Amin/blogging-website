@extends('layouts.app1')
@section('content')


<div class="container">

    <div class="row">
        <div class="col-md-3">
            <!-- User info -->
            @guest 
            @else
            <div class="panel panel-default">
                <div class="panel-body center-vertical">
                    <img src="https://www.shareicon.net/data/2016/05/24/770117_people_512x512.png" width="100px">

                </div>
                <h3 class="text-center">{{ Auth::user()->name }}</h3>
                <h5 class="text-center">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    {{ Auth::user()->email }}
                </h5>
                <h5 class="text-center">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    {{ Auth::user()->mobile_number}}
                </h5>
            </div>
            @endguest
            <!-- /User info-->


            <!-- All Users -->
            <h4 class="text-center">
                <i class="fa fa-users" aria-hidden="true"></i>
                All Users
            </h4>
            <ul class="list-group">
                @foreach($users as $user)
                <li class="list-group-item">
                    <a href="#">
                        <img src="https://www.shareicon.net/data/2016/05/24/770117_people_512x512.png" width="50px" class="img img-circle">
                    </a>
                    <a href="#">
                        {{$user->name}}
                    </a>
                </li>
                @endforeach

            </ul>
            <!-- /All Users -->
        </div>

        <div class="col-md-9">
        @guest 
            @else
            <!-- Create Post -->
            <div class="panel panel-default user-post-panel">
                <div class="panel-heading">
                    <div class="row">
                        <img src="https://www.shareicon.net/data/2016/05/24/770117_people_512x512.png" width="50px" class="img user-avatar img-circle pull-left">

                        <div class="pull-left">
                            <h4 class="user-name ">{{ Auth::user()->name }}</h4>
                            <h6> Online</h6>
                        </div>
                    </div>

                </div>
                <div class="panel-body">
                    <form method="post" action="/" enctype="multipart/form-data">
                    @csrf
                        <textarea name="body" rows="5" class="form-control"></textarea>
                        <br>
                        <input name="post_image" type="file" class="hidden input-image" id="post-image">
                        <button class="btn btn-primary pull-right" type="submit">Post</button>
                    </form>
                </div>
                <div class="panel-footer">
                    <label for="post-image" class="upload-label" title="upload photo">
                        <img data-src="holder.js/50x50?text=Upload" class="img img-rounded img-thumbnail">
                    </label>
                </div>
            </div>
            <!-- /Create Post -->
            @endguest

            @foreach($posts as $post)
            <!-- User Posts -->
            <div class="panel panel-default user-post-panel">

                <div class="panel-heading">
                    <div class="row">
                        <img src="https://www.shareicon.net/data/2016/05/24/770117_people_512x512.png" width="50px" class="img user-avatar img-circle pull-left">

                        <div class="pull-left">
                            <h4 class="user-name ">{{$post->user->name}}</h4>
                            <small class="text-muted">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                {{$post->updated_at->diffForHumans()}}
                            </small>
                        </div>

                        <!-- Post control -->
                        @auth 
                        @if ($post->user_id === Auth::user()->id)
                        <div class="pull-right">
                            <!-- Single button -->
                            <div class="btn-group post-control">
                                <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a data-toggle="modal" href="#modal-id">
                                            <i class="fa fa-edit fa-lg" aria-hidden="true"></i> Edit Post
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                    <form action="/posts/{{$post->id}}" method="POST" style="display:inline-block">
                                     @csrf 
                                    @method('DELETE') 
                                    <button class="btn btn-inverse-danger btn-fw" type=submit onclick="return confirm('Are You Sure You Want To Delete This Record ?')" >
                                    <i class="fa fa-trash fa-lg" aria-hidden="true"></i> Delete Post
                                        </button> 
                                    </form>
                                        
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                        @endauth

                        <!-- Edit Post Form -->
                        <div class="modal fade" id="modal-id">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h4 class="modal-title">Edit Post</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('update',['id'=>$post->id])}}" method="post" id="edit-post-id">
                                        @csrf
                                        @method('PATCH')
                                            <textarea name="body" rows="5" class="form-control">
                                            {{$post->body}}
                                        </textarea>
                                            <br>
                                            <input type="file" class="hidden input-image" id="input-image-edit">
                                            <label for="input-image" class="upload-label" title="upload photo">
                                                <img data-src="holder.js/100x100?text=Upload Photo" class="img img-rounded img-thumbnail">
                                            </label>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" form="edit-post-id" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <!-- Edit Post Form -->

                        <!-- /Post control -->
                    </div>

                </div>
                <!-- Post content-->
                <div class="panel-body">
                    <img src="{{asset($post->blog_image)}}" class="img img-responsive">
                    <br>
                    <p>
                        {{$post->body}}
                    </p>
                </div>
                <!-- /Post content-->

                <div class="panel-footer">
                    <!-- Like Button -->
                    <span class="like-btn">
                        <small class="text-muted likes">20</small>
                        <a href="#" class="btn-btn-primary">
                            <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i>
                        </a>
                    </span>
                    <!-- /Like Button -->

                    <!-- Dislike Button -->
                    <span class="like-btn">
                        <small class="text-muted likes">3</small>
                        <a href="#" class="btn-btn-primary">
                            <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true"></i>
                        </a>
                    </span>
                    <hr>
                    <!-- Dislike comment form -->

                    <!-- Add comment form -->
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object img img-circle"  width="50px" src="https://www.shareicon.net/data/2016/05/24/770117_people_512x512.png" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <form action="">
                                <textarea name="" id="" class="form-control"></textarea>
                                <br>
                                <button class="btn btn-primary pull-right">Comment</button>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
            <!-- /User Posts -->
            @endforeach
        </div>

    </div>
</div>

@endsection('content')