<header class="blog-header py-3">
    <div class="container">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <a class="text-muted" href="{{route('home')}}">Laravel 6.0</a>
            </div>
            <?php if(auth('web')->guest()): ?>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="btn btn-sm btn-outline-secondary" href="{{route('signup')}}" style="margin-right: 5px">注册</a>
                <a class="btn btn-sm btn-outline-secondary" href="{{route('signin')}}">登陆</a>
            </div>
            <?php else: ?>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <span style="margin-right: 5px">您好 {{auth('web')->user()->username}} </span>
                <a class="btn btn-sm btn-outline-secondary" href="{{route('signout')}}">退出登陆</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</header>
