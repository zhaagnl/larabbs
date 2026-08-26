<ul class="list-unstyled">
  @foreach($replies as $index => $reply)
    <li class="d-flex" name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
      <div class="media-left">
        <a href="{{ route('users.show', [$reply->user_id]) }}">
          <img  alt="{{ $reply->user->name }}" class="media-object img-thumbnail mr-3" style="width:48px;height:48px;"
            @if($reply->user->avatar)
            src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $reply->user->name }}"
            @else
            src="{{ $reply->user->avatar }}"
            @endif >
        </a>
      </div>

      <div class="flex-grow-1 ms-2">
        <div class="medai-heading mt-0 mb-1 text-secondary">
          <a class="text-decoration-none" href="{{ route('users.show', [$reply->user_id]) }}" title="{{ $reply->user->name }}">
              {{ $reply->user->name }}
          </a>
          <sapn class="text-secondary"> • </sapn>
          <span class="meta text-secondary" title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</span>

          {{-- 回复删除按钮 --}}
          <span class="meta float-end">
            <a title="删除回复">
              <i class="far fa-trash-alt"></i>
            </a>
          </span>
        </div>
        <div class="reply-content text-secondary">
          {!! $reply->content !!}
        </div>
      </div>
    </li>

    @if(! $loop->last)
      <hr>
    @endif

  @endforeach
</ul>
