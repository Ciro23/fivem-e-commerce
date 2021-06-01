<div class="container">
    <div>
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
        <a href="/signup">Don't have an account? Signup</a>
    </div>
</div>