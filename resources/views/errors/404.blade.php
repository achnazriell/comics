<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="bg-gray-100 text-center">
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold">404</h1>
        <p class="mt-4 text-lg">Page Not Found</p>
        <a href="{{ url('/') }}" class="text-blue-500 underline">Go Back Home</a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>
</body>
</html>
