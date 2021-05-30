<div class="login-signup">
    <form method="POST">
        <h2>Login</h2>

        <?php 
        if (isset($errors)) {
            echo $errors;
        }
        ?>

        <label for="email">Email</label>
        <input type="text" id="email" name="email">

        <label for="password">Password</label>
        <input type="password" id="password" name="password">
        
        <input type="submit" value="Login">
    </form>
</div>