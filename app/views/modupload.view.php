<?php include_once __DIR__ . "/../included/header.included.php" ?>

    <!-- this page's css -->
    <link rel="stylesheet" href="/assets/styles/css/login.style.css">

    <title>Upload mod - <?= $_ENV['site_name'] ?></title>
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