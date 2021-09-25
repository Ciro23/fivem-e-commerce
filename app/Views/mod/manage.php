<?= view_cell("\App\Libraries\ViewCells::header") ?>

<div class="container distance max-w-5xl mx-auto flex flex-col space-y-10">
    <h1 class="font-medium text-xl text-center">List of all pending mods</h1>

    <?php
    foreach ($mods as $mod) {
        echo view_cell("\App\Libraries\ViewCells::modPreview", [
            "mod" => $mod,
            "manage" => true
        ]);
    }
    ?>
</div>

<?= view_cell("\App\Libraries\ViewCells::footer") ?>