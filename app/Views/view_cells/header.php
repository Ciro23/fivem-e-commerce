<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- common css for all the pages -->
    <link rel="stylesheet" href="/assets/styles/css/compiled.css">

    <title><?= esc($title) ?></title>
</head>

<body>
    <nav class="w-screen bg-white fixed shadow top-0">
        <div class="max-w-5xl mx-auto px-3 py-2 flex justify-between items-center text-sm">
            <a href="/" class="py-1">Home</a>

            <input type="text" placeholder="search mod" id="mod-search-input" class="px-3 py-1.5 w-64 border rounded">

            <div class="flex space-x-6">

                <?php if (session("is_logged_in") === true) : ?>
                    <a href="/upload-mod"><img src="/assets/icons/upload.svg" class="w-5"></a>
                    <div class="relative cursor-pointer select-none">
                        <p href="/user/<?= session("uid") ?>" class="pl-4 pr-8" id="dropdown">My profile</p>
                        <div class="hidden absolute mt-6 shadow bg-white flex-col rounded" id="dropdown-content">
                            <a href="/user/<?= session("uid") ?>" class="pl-4 pr-8 py-3 hover:bg-gray-100">Profile</a>
                            <a href="/user/<?= session("uid") ?>/settings" class="pl-4 pr-8 py-3 hover:bg-gray-100">Settings</a>
                            <a href="/logout" class="pl-4 pr-8 py-3 hover:bg-gray-100 text-red-500">Logout</a>
                        </div>
                    </div>
                <?php else : ?>
                    <a href="/login" class="rounded-md px-3.5 py-1.5 bg-yellow-400">Login</a>
                <?php endif ?>
            </div>
        </div>
    </nav>