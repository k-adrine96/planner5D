<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Planner5D</title>
</head>
<body>
    <div>
        <div class="project" style="text-align: center">
            <h1 class="title">{{ $project->title }}</h1>
            <div class="thumbnail">
                <img src="{{ $project->image }}" alt="">
            </div>
            <div class="views">{{ $project->views }} Views</div>
        </div>
    </div>
</body>
</html>
