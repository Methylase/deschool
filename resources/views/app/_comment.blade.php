<li style="margin-left: {{ $level * 20 }}px;">
    <div class="media mb-4">
        <div class="media-body">
        <h6>
            {{$comment->name}} <small><i>{{date('d M. Y', strtotime($comment->created_at))}}</i></small>
        </h6>
        <p>
            {{$comment->content}}
        </p>
        <button id="{{$comment->id}}" class="btn btn-sm btn-light reply">Reply</button>
        </div>
    </div>

    <!-- Comment Form -->
    <div class="bg-light p-5 reply-form" id="reply{{$comment->id}}">
    <h2 class="mb-4">Leave a comment</h2>
    <form action="{{ route('comment') }}" method="POST">
        <input type="hidden" name="blog_id"  value="{{ $blog->id }}">
        <input type="hidden" name="parent_id"  value="{{ $comment->id }}">
        <div class="form-group">
        <label for="name">Name *</label>
        <input type="text" name="name" class="form-control" id="name" />
        @if($errors->has('name'))
            <p class="help-block text-danger">
                {{ $name= $errors->first('name')}}
            </p>
        @else
            {{$name=''}}
        @endif
        </div>
        <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" name="email" class="form-control" id="email" />
        @if($errors->has('email'))
            <p class="help-block text-danger">
                {{ $email= $errors->first('email')}}
            </p>
        @else
            {{$email=''}}
        @endif        
        </div>
        <div class="form-group">
        <label for="message">Message *</label>
        <textarea
            name="content"
            id="message"
            cols="30"
            rows="5"
            class="form-control"
        ></textarea>
        @if($errors->has('message'))
        <p class="help-block text-danger">
            {{ $message= $errors->first('message')}}
        </p>
        @else
            {{$message=''}}
        @endif          
        </div>
        <div class="form-group mb-0">
        <input
            type="submit"
            value="Leave Comment"
            class="btn btn-primary px-3"
        />
        </div>
    </form>
    </div>    
    @foreach ($comment->replies as $reply)
        @include('app._comment', ['comment' => $reply, 'level' => $level + 1])
    @endforeach
</li>


