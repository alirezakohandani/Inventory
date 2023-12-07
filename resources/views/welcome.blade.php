<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body>
<h1 class="text-3xl font-bold underline font-iransans">
    Hello world!
    @livewireScripts
    <livewire:test />
</h1>
</body>
</html>
