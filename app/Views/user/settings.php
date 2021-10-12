<?= view_cell("\App\Libraries\ViewCells::header") ?>

<div class="mega-box">
    <form class="form" method="POST" enctype="multipart/form-data">
        <h2>User settings</h2>

        <?php
        if (isset($errors)) {
            echo $errors;
        }
        ?>

        <div class="form-columns">
            <div>
                <label for="name">Username</label>
                <input class="cursor-not-allowed bg-gray-200" readonly type="text" id="name" name="name" value="<?= $user->username ?>" placeholder="4-30 chars (a-z, 0-9, spaces)">
            </div>

            <div>
                <label for="avatar">Avatar</label>
                <input type="file" id="avatar" name="avatar">
            </div>
        </div>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="5" placeholder="0-200 characters" minlength="10" maxlength="200"><?= $user->description ?></textarea>

        <input type="submit" value="Save settings">
    </form>
</div>

<?= view_cell("\App\Libraries\ViewCells::footer") ?>