<?= view_cell("\App\Libraries\ViewCells::header") ?>

<div class="mega-box">
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
                    <input type="text" id="email" name="email" placeholder="example@gmail.com">

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="4-20 chars (a-z, 0-9)">
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="6-72 characters">

                    <label for="confirm_password">Confirm password</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                </div>
            </div>

            <input type="submit" value="Signup">
        </form>
        <a href="/login">Already registered? Login</a>
    </div>
</div>

<?= view_cell("\App\Libraries\ViewCells::footer") ?>