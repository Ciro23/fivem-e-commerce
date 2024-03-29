<?= view_cell("\App\Libraries\ViewCells::header") ?>

<div class="mega-box">
    <form class="form" method="POST" enctype="multipart/form-data">
        <h2>Upload a mod</h2>

        <?php
        if (isset($errors)) {
            echo $errors;
        }
        ?>

        <div class="form-columns">
            <div>
                <label for="name">Name (cannot be changed)*</label>
                <input type="text" id="name" name="name" value="<?= esc($mod->name) ?? "" ?>" placeholder="4-30 chars (a-z, 0-9, spaces)">

                <label for="price">Price in Euros*</label>
                <input type="number" id="price" name="price" value="<?= esc($mod->price) ?? "" ?>" placeholder="9,99" min="0" max="25">
            </div>

            <div>
                <label for="file">File*</label>
                <label for="file" class="file-label">
                    <img src="/assets/icons/upload.svg">
                    Upload file
                </label>
                <input type="file" id="file" name="file">

                <label for="image">Image*</label>
                <label for="image" class="file-label">
                    <img src="/assets/icons/upload.svg">
                    Upload image
                </label>
                <input type="file" id="image" name="image">
            </div>
        </div>

        <label for="description">Description*</label>
        <textarea name="description" id="description" rows="5" placeholder="10-10000 characters" minlength="10" maxlength="10000"><?= esc($mod->description) ?? "" ?></textarea>

        <input type="submit" value="Upload mod">
    </form>
</div>

<?= view_cell("\App\Libraries\ViewCells::footer") ?>