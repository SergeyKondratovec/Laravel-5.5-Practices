<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title> @yield('title')</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://v4-alpha.getbootstrap.com/examples/dashboard/dashboard.css">

    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
</head>
<body>
<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
    <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse"
            data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Elasticsearch test</a>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            {{--  <li class="nav-item active">
                  <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">Settings</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">Profile</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">Help</a>
              </li>--}}
        </ul>

        <form class="form-inline mt-2 mt-md-0" onsubmit="Filter.sendData();return false;">
            <input id="searchKeyword" class="form-control mr-sm-2" style="width: 500px" type="text" name="keyword"
                   placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                Search
            </button>
        </form>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <nav id="facets" class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
            @yield('facets')
        </nav>
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
            <h1>@yield('title')</h1>
            @yield('PageContent')
        </main>
    </div>
</div>
</body>
</html>
