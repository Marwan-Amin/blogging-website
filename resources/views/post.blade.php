@extends('layouts.app1')
@section('content')

<div class="container">

    <div class="panel panel-default user-post-panel">

        <div class="panel-heading">
            <div class="row">
                <img src="https://www.shareicon.net/data/2016/05/24/770117_people_512x512.png" width="50px" class="img user-avatar img-circle pull-left">

                <div class="pull-left">
                    <h4 class="user-name ">{{$post->user->name}}</h4>
                    <small class="text-muted">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        {{$post->created_at->diffForHumans()}} / 
                                <i class="fa  fa-eye"></i>
                                Total views : {{views($post)->unique()->count()}} /
                                <i class="fa fa-thumbs-up"></i> 
                                 {{count($post->upvoters()->get())}} -
                                 <i class="fa fa-thumbs-down"></i> 
                                 {{count($post->downvoters()->get())}}
                    </small>
                </div>

                <!-- Post control -->
                @auth
                @if ($post->user_id === Auth::user()->id)
                <div class="pull-right">
                    <!-- Single button -->
                    <div class="btn-group post-control">
                        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                    <button class="btn btn-inverse-danger btn-fw" type=submit onclick="return confirm('Are You Sure You Want To Delete This Record ?')">
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
                {!! \Michelf\Markdown::defaultTransform($post->body) !!}
            </p>
        </div>
        <!-- /Post content-->

        <div class="panel-footer">

            <!-- Like Button -->
            <span class="like-btn">
                <small class="text-muted likes"></small>
                <a href="/post/{{$post->id}}/like" class="btn-btn-primary">
                    <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true">{{count($post->upvoters()->get())}}</i>
                </a>
            </span>
            <!-- /Like Button -->

            <!-- Dislike Button -->
            <span class="like-btn">
                <small class="text-muted likes"></small>
                <a href="/post/{{$post->id}}/dislike" class="btn-btn-primary">
                    <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true">{{count($post->downvoters()->get())}}</i>
                </a>
            </span>
        </div>
    </div>
</div>
@endsection('content')