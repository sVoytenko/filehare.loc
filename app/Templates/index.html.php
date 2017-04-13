{{ include("header.php") }}
<div class="container-fluid">
    <form name="upload" action="/" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        <input class="" type="file" name="file">
        <input class="" type="text" name="authorComment">
     <input type="submit">
</form>
</div>
{{ include("footer.php")}}