<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/front/main.css">
</head>

<body>
@yield('header',View::make('front.layouts._header'))
<main role="main">

    <div class="container">
        <?php if(\App\Base\Message::has()): ?>
            <?=\App\Base\Message::render(); ?>
        <?php endif; ?>
        @yield('content')
    </div>
</main>
@yield('footer',View::make('front.layouts._footer'))
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
