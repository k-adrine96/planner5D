<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Planner5D</title>
{{--        <link href="{{ asset('../css/style.css') }}" rel="stylesheet">--}}
        <style>
            div.projects {
                width: 83%;
                margin: auto;
            }
            div#grid {
                display: flex;
                flex-wrap: wrap;
            }
            div.project {
                width: 23%;
                padding: 0% 1%;
            }
            div.thumbnail > img{
                width:100%;
            }
            div.pagination {
                padding-bottom: 5%;
                text-align: center;
            }
            div.pagination > nav {
                width: 50%;
                margin: auto;
            }
            ul.pagination {
                list-style-type: none;
                display: inline-block;
                /*text-align: -webkit-auto;*/
                padding: 0;
            }
            ul.pagination > li {
                float: left;
                border: 1px solid black;
                padding: 5px 10px;
                border-radius: 10px;
                margin: 0px 10px;
            }
            div.project > a,
            ul.pagination > li > a{
                text-decoration: none;
                color: black;
            }
            ul.pagination > li.page-item.active{
                background-color: #8080806e;
            }
            div.views {
                bottom: 12%;
            }
            div.title {
                top: 11%;
            }
            div.views,
            div.title{
                position: relative;
                background-color: #80808094;
            }
            div.views > h4,
            div.title > h3{
                text-align: center;
                padding: 2% 0%;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="projects">
            <div id="grid" class="justify-center">
                @foreach($projects as $project)
                    <div class="project">
                        <a href="{{ route('project', ['id' => $project->id] ) }}">
                            <div class="title">
                                <h3>{{ $project->title }}</h3>
                            </div>
                            <div class="thumbnail">
                                <img src="{{ $project->image }}" alt="">
                            </div>
                        </a>
                        <div class="views">
                            <h4>{{ $project->views }} Views</h4>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination">
                {{ $projects->links() }}
            </div>
        </div>
    </body>
</html>
