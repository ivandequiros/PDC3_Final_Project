<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | School Supply System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">


        <div
            class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white shadow-2xl overflow-hidden sm:rounded-3xl border border-gray-100">
            @yield('content') </div>

        <p class="mt-8 text-sm text-gray-400">© 2026 PD3 Final Project</p>
    </div>
</body>

</html>