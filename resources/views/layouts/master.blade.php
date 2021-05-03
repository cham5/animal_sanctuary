<!-- Basic master template that the landing page extends. -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewpoint" content="width-device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="/css/main.css" rel="stylesheet">
    </head>
    <body>
        @yield('content')
        <footer>
            <p>Copyright 2021. All Rights Reserved.</p>
        </footer>
    </body>
</html>