<div class="container">
    <div>
        <form method="POST">
            <h2>Signup</h2>

            <?php 
            if (isset($errors)) {
                echo $errors;
            }
            ?>

            <div class="form-columns">
                <div>
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email">

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username">
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">

                    <label for="confirm_password">Confirm password</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                </div>
            </div>
            
            <input type="submit" value="Signup">
        </form>
        <a href="/login">Already registered? Login</a>
    </div>
</div>