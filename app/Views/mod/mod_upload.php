<div class="container">
    <form method="POST" enctype="multipart/form-data">
        <h2>Upload a mod</h2>

        <?php
        if (isset($errors)) {
            echo $errors;
        }
        ?>

        <label for="name">Name</label>
        <input type="text" id="name" name="name">

        <label for="description">description</label>
        <input type="text" id="description" name="description">

        <label for="version">Version</label>
        <input type="text" id="version" name="version">

        <label for="file">File</label>
        <input type="file" id="file" name="file">

        <label for="image">Image</label>
        <input type="file" id="image" name="image">

        <input type="submit" value="Upload mod">
    </form>
</div>