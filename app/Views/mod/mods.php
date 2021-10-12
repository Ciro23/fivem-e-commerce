<?= view_cell("\App\Libraries\ViewCells::header") ?>

<div class="container distance max-w-5xl mx-auto flex flex-col space-y-5">
    <div class="self-end flex space-x-3 items-center">
        <form action="">
            <label for="order">Order by</label>

            <select id="order" name="order" class="border rounded px-2 py-1">
                <option value="newer">Newer</option>
                <option value="older">Older</option>
            </select>
        </form>
    </div>

    <?php if (empty($mods)) : ?>
        <p class="text-center">wow! such empty :C</p>
    <?php endif ?>

    <?php
    foreach ($mods as $mod) {
        echo view_cell("\App\Libraries\ViewCells::modPreview", ["mod" => $mod]);
    }
    ?>
</div>

<?= view_cell("\App\Libraries\ViewCells::footer") ?>