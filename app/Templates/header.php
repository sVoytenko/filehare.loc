<!DOCTYPE html>
<html>
<head>
    <title>{{title}}</title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="navbar-left">
        <ul class="nav navbar-nav">
            <li> <a href="/filelist">Список файлов</a></li>
            <li> <a href="/">Загрузка</a></li> 
        </ul>
        <form class="navbar-form navbar-left" action="search" method="GET">
        <div class="form-group">
            <input type="text" class="form-control" name="s">
        </div>
             <input type="submit" class="btn btn-default" value="поиск">
      </form>
    </div>
</nav>
