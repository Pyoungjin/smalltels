<div class='row'>
    <div class='span12'>
        <div class="navbar navbar-fixed-top navbar-inverse">
            <div class="navbar-inner">
                <ul class='nav pull-right'>
                    @if(Auth::check())
                    <li >
                        <a href="/home/admin">마이페이지</a>
                    </li>
                    <li >
                        <a href="/auth/logout">로그아웃</a>
                    </li>
                    @else
                    <li >
                        <a href="/auth/register">회원가입</a>
                    </li>
                    <li >
                        <a href="/auth/login">로그인</a>
                    </li>
                    @endif
                    
                </ul>
            </div>
        </div>
    </div>
</div>