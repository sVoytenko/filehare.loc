{{ include("header.php") }}
{% for file in files %}
    {%if file.type == 'image/jpeg' %}
    <img src="previews/{{file.realName}}">
    {%endif%}
    <p>Имя файла - {{file.name}}</p>
    <p>Размер файла - {{file.size}} байт</p>
    <p>Тип файла - {{file.type}}</p>
    <p>Авторский комментарий</p>
    <p>{{file.authorComment}}</p>
    <p>Ссылка <a href="/file/{{file.id}}">{{file.realName}}</a></p>
    <hr>
{% endfor %}
{{ include("footer.php") }}
