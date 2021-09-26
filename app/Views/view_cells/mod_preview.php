<div class="flex h-42 shadow-md rounded p-6">
    <div class="flex w-5/6 space-x-6">
        <a href="/mod/<?= esc($mod->id) ?>" class="w-1/6">
            <img src="/assets/mods_images/<?= esc($mod->id) . "/image." . esc($mod->image_ext) ?>" class="rounded">
        </a>

        <div class="flex flex-col w-5/6 justify-between space-y-5">
            <div>
                <a href="/mod/<?= esc($mod->id) ?>">
                    <h2 class="font-semibold"><?= $mod->name ?></h2>
                </a>
                <p class="text-sm"><?= character_limiter(esc($mod->description), 180) ?></p>
            </div>

            <div class="flex space-x-3 text-sm">
                <p class="px-2.5 py-1.5 rounded shadow">Author: <?= esc($mod->author_name) ?></p>
                <p class="px-2.5 py-1.5 rounded shadow">Price: <?= esc($mod->price) ?>€</p>
                <p class="px-2.5 py-1.5 rounded shadow">Created: <?= date("j M Y, H:i", strtotime($mod->updated_at)) ?></p>
            </div>
        </div>
    </div>

    <?php if ($manage ?? false) : ?>
        <div class="ml-auto flex flex-col space-y-3 text-white text-sm text-center">
            <a href="/mod/<?= esc($mod->id) ?>/approve" class="rounded px-3 py-1.5 bg-green-500">Approve</a>
            <a href="/mod/<?= esc($mod->id) ?>/deny" class="rounded px-3 py-1.5 bg-red-500">Deny</a>
        </div>
    <?php endif ?>

    <?php if (session("uid") == $mod->author ?? false) : ?>
        <div class="ml-auto flex flex-col space-y-3 text-white text-sm text-center">
            <a href="/mod/<?= esc($mod->id) ?>/edit" class="rounded px-3 py-1.5">
                <img src="/assets/icons/edit.svg" class="w-5">
            </a>
        </div>
    <?php endif ?>
</div>