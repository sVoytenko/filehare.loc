{{ include("header.php") }}
<div class="contentWrapper">
    {%if file.type == 'image/jpeg' %}
    <img src="/previews/{{file.realName}}">
    {%endif%}
    <p> Ссылка на скачивание <a href="/download/{{file.id}}">{{file.name}}</a></p>
    <p>Имя файла - {{file.name}}</p>
    <p>Размер файла - {{file.size}} байт</p>
    <p>Тип файла - {{file.type}}</p>
    <p>Авторский комментарий</p>
    <p>{{file.authorComment}}</p>
    <hr>
    <form name="comment" action="/file/{{file.id}}" method="post" accept-charset="utf-8">
        <input class="" type="text" name="text">
     <input type="submit">
    </form>
    
</div>
{{ include("footer.php") }}
