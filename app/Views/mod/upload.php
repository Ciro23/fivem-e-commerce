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
                <input type="text" id="name" name="name" placeholder="4-30 chars (a-z, 0-9, spaces)">

                <label for="price">Price in Euros</label>
                <input type="number" id="price" name="price" placeholder="9,99">
            </div>

            <div>
                <label for="file">File</label>
                <input type="file" id="file" name="file">

                <label for="image">Image</label>
                <input type="file" id="image" name="image">
            </div>
        </div>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="5" placeholder="10-3000 characters"></textarea>

        <input type="submit" value="Upload mod">
    </form>
</div>