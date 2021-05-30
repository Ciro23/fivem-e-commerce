<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- common css for all the pages -->
    <link rel="stylesheet" href="/assets/styles/css/common.css">
    <link rel="stylesheet" href="/assets/styles/css/nav-bar.css">

    <!-- specific css for the loaded page. $styles[] contains all the css files names needed  -->
    <?php
    foreach ($styles as $style) {
        echo "<link rel='stylesheet' href='/assets/styles/css/" . $style . ".css'>";
    }
    ?>
</head>
<body>
    <div class="mega-box">
        <nav class="nav-bar">
            <div>
                <a href="/">Home</a>
            </div>
        </nav>