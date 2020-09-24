<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            @include('includes.navbar')
            
            @include('includes.sidebar')

            <main>
                @yield('content')
            </main>

                    
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2020
                <div class="bullet"></div>
                </div>
                <div class="footer-right">Crafted</div>
            </footer>
        </div>
    </div>
    

    @include('includes.footer')

    
</body>



</html>