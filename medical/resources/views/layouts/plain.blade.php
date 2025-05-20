<!-- filepath: resources/views/layouts/plain.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Feedback')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body style="background:#f5f6fa;">
    @yield('content')
</body>
</html>