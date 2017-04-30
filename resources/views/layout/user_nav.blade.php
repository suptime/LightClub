<div class="userTopic-head">
    <a href="{{ url('space/'.$user->uid) }}" {{ Response::getPathInfo() !== '/space/'.$user->uid }}class="topic-cur">话题</a>
    <a href="{{ url('reply/'.$user->uid) }}">回复</a>
    <a href="{{ url('user/message') }}">私信</a>
</div>