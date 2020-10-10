<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'cjw的小站')">

    <title>cjw的小站-@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    <div id="app">
        @include('layouts._header')

        <main class="py-4">
            @include('shared._messages')
            @yield('content')
        </main>

        @include('layouts._footer')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        $(function() {
            $('[data-fn="confirm"]').on('click', function(e) {
                e.preventDefault();

                let title = $(this).data('title'),
                    $form = $(this).closest('form');

                if($form.length === 0) {
                    $form = $(this).siblings('form:first');
                }

                swal({
                    title: title ? title : '确定执行此操作',
                    icon: 'warning',
                    buttons: ['取消', '确认'],
                    dangerMode: true
                })
                .then(confirmed => {
                    if(confirmed) {
                        if($form.length > 0) {
                            $form.submit();
                        }
                    }
                });
            });
        });

        $(function() {
            $('#footer-link-me').tooltip();
        });
    </script>
    @stack('scripts')
</body>
</html>
