<div class='row'>
    <div class='span12'>
        <ul class="nav nav-tabs">
            <li class="{{(Request::is('home')||Request::is('home/*'))?'active':''}}">
                <a href="/home">HOME</a>
            </li>
            @foreach ( (User::info('office_list')) as $val)
            <li class="{{(Request::is('office/'.$val['id'].'/*'))?'active':''}}">
                <a href='/office/{{$val["id"]}}/board'>{{$val["name"]}}</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>