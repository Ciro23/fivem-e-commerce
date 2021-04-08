<?php include_once __DIR__ . "/../included/header.included.php" ?>

    <!-- this page's css -->
    <link rel="stylesheet" href="/assets/styles/css/login-signup.style.css">

    <title>Login - <?= $_ENV['site_name'] ?></title>
</head>
<body>
    <?php include_once __DIR__ . "/../included/navbar.included.php" ?>
    
    <div class="login-signup">
        <form action="/login/action" method="POST">
            <h2>Login on <?= $_ENV['site_name'] ?></h2>
            <input type="text" placeholder="email" name="email">
            <input type="password" placeholder="password" name="password">
            <input type="submit" value="login">
        </form>
    </div>
</body>
</html>