<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@lang('lang.activation_code')</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body>
    <div class="text-center">
        <h1><b>@lang('lang.You have registered successfully')</b></h1>
    </div>
    <div class="text-center">
        <h3> @lang('lang.Please wait until your account to be activated')</h3>
    </div>

</body>
</html>