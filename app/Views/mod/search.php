<div class="container distance max-w-5xl mx-auto flex flex-col space-y-10">
    <h1 class="font-medium text-xl text-center">Results for "<?= esc($query) ?>"</h1>
    <?php if (empty($mods)) : ?>
        <p class="text-center">wow! such empty :C</p>
    <?php endif ?>

    <?php
    foreach ($mods as $mod) {
        echo view_cell("\App\Libraries\ViewCells::modPreview", ["mod" => $mod]);
    }
    ?>
</div>