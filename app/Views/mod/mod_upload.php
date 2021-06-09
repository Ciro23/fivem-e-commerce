<div class="container">
    <form method="POST" enctype="multipart/form-data">
        <h2>Upload a mod</h2>

        <?php
        if (isset($errors)) {
            echo $errors;
        }
        ?>

        <div class="form-columns">
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name">

                <label for="price">Price</label>
                <input type="number" id="price" name="price">

                <label for="version">Version</label>
                <input type="text" id="version" name="version">
            </div>

            <div>
                <label for="file">File</label>
                <input type="file" id="file" name="file">

                <label for="image">Image</label>
                <input type="file" id="image" name="image">
            </div>
        </div>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="5"></textarea>

        <input type="submit" value="Upload mod">
    </form>
</div>