<div class="container">
    <form method="POST">
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

        <input type="submit" value="Upload mod">
    </form>
</div>