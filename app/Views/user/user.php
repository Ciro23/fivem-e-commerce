<?= view_cell("\App\Libraries\ViewCells::header") ?>

<div class="container max-w-5xl mx-auto flex space-x-5 justify-center">
    <div class="distance flex flex-col space-y-10">
        <?php if (empty($mods)) : ?>
            <p class="text-center">wow! such empty :C</p>
        <?php endif ?>

        <?php
        foreach ($mods as $mod) {
            echo view_cell("\App\Libraries\ViewCells::modPreview", [
                "mod" => $mod,
            ]);
        }
        ?>
    </div>

    <div class="w-2/5 h-80 distance p-6 shadow rounded-lg flex flex-col justify-between items-center">
        <div class="flex flex-col space-y-2 items-center">
            <img src="/assets/users_propics/image.jpeg" class="w-28 h-28 rounded-full">
            <h4 class="text-lg font-semibold text-center"><?= esc($user->username) ?></h4>
            <p>Created <?= date("j M, Y", strtotime($user->created_at)) ?></p>
            <p><?= esc($user->description) ?></p>
        </div>
        <?php if ($user->id == session("uid")) : ?>
            <a href="<?= $user->id ?>/edit"><img src="/assets/icons/settings.svg"></a>
        <?php endif ?>
    </div>
</div>

<?= view_cell("\App\Libraries\ViewCells::footer") ?>