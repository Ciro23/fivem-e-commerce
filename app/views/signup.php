<?php include_once __DIR__ . "/../included/header.included.php" ?>

    <!-- this page's css -->
    <link rel="stylesheet" href="/assets/styles/css/login-signup.style.css">

    <title>Signup - <?= $_ENV['site_name'] ?></title>
</head>
<body>
    <?php include_once __DIR__ . "/../included/navbar.included.php" ?>
    
    <div class="login-signup">
        <form action="/signup/action" method="POST">
            <input type="text" placeholder="email" name="email">
            <input type="text" placeholder="username" name="username">
            <input type="password" placeholder="password" name="password">
            <input type="password" placeholder="confirm password" name="rePassword">
            <input type="submit" value="signup">
        </form>
    </div>
</body>
</html>