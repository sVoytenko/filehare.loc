{{ include("header.php") }}
<div class="contentWrapper">
    <form class="form" name="upload" action="/" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
    	<p>Выберите файл для загрузки</p>
        <input class="" type="file" name="file">
        <input class="" type="text" name="authorComment">
     <input type="submit">
</form>
</div>
{{ include("footer.php")}}