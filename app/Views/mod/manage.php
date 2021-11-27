<?= view_cell("\App\Libraries\ViewCells::header") ?>

<div class="container distance max-w-5xl mx-auto flex flex-col space-y-5">
    <h1 class="font-medium text-xl text-center">List of all pending mods</h1>

    <?php
    if (empty($mods)) {
        echo "<p class='text-center'>no mods to approve :C</p>";
    }

    foreach ($mods as $mod) {
        echo view_cell("\App\Libraries\ViewCells::modPreview", [
            "mod" => $mod,
            "manage" => true
        ]);
    }
    ?>
</div>

<?= view_cell("\App\Libraries\ViewCells::footer") ?>