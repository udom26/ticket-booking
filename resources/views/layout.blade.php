<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ticket Booking')</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f6fd;
        }
        .page-wrapper {
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        header {
            text-align: center;
            padding: 20px 0;
            background-color: #2563eb;
            color: #fff;
            font-size: 1.5em;
            font-weight: bold;
        }
        main.content {
            flex: 1;
            padding: 20px;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #2563eb;
            color: #fff;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <header>
            Ticket Booking System
        </header>

        <main class="content">
            @yield('content')
        </main>

        <footer>
            © 2025 Ticket Booking System
        </footer>
    </div>
</body>
</html>
