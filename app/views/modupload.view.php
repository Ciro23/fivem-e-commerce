<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/mod/upload/action" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="name" value="<?= $data['form']['name'] ?>">
        <input type="text" name="description" placeholder="description" value="<?= $data['form']['description'] ?>">
        <input type="text" name="version" placeholder="version" value="<?= $data['form']['version'] ?>">
        <input type="file" name="file" placeholder="file">
        <input type="file" name="image" placeholder="image">
        <input type="submit" value="upload">
    </form>
</body>
</html>