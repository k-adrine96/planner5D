<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Planner5D</title>
</head>
<body>
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="project">
            <h1 class="title">{{ $project->title }}</h1>
            <div class="thumbnail">
                <img src="{{ $project->image }}" alt="">
            </div>
            <div class="views">{{ $project->views }}</div>
        </div>
    </div>
</body>
</html>
