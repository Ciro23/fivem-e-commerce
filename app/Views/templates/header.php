<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- common css for all the pages -->
    <link rel="stylesheet" href="/assets/styles/css/compiled.css">

    <title><?= $title ?></title>
</head>

<body>
    <nav class="w-screen bg-white fixed shadow top-0">
        <div class="max-w-5xl mx-auto px-3 py-2 flex justify-between items-center text-sm">
            <a href="/" class="py-1">Home</a>
            <div class="flex space-x-6">
                <?php if (session("is_logged_in") !== true) : ?>
                    <a href="/login" class="rounded-md px-3.5 py-1.5 bg-yellow-400">Login</a>
                <?php else : ?>
                    <a href="/upload-mod"><img src="/assets/icons/upload.svg" class="w-5"></a>
                    <a href="/user/<?= session("uid") ?>">My profile</a>
                <?php endif ?>
            </div>
        </div>
    </nav>