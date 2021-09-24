<div class="container distance max-w-5xl mx-auto flex flex-col space-y-10">
    <h1 class="font-medium text-xl text-center">List of all pending mods</h1>
    <?php foreach ($mods as $mod) : ?>


        <div class="flex h-42 shadow-md rounded p-6">
            <div class="flex space-x-6">
                <a href="/mod/<?= esc($mod->id) ?>" class="w-36">
                    <img src="/assets/mods_images/<?= esc($mod->id) . "/image." . esc($mod->image_ext) ?>" class="rounded">
                </a>

                <div class="flex flex-col w-3/4 justify-between space-y-5">
                    <div>
                        <a href="/mod/<?= esc($mod->id) ?>">
                            <h2 class="font-semibold"><?= esc($mod->name) ?></h2>
                        </a>
                        <p class="text-sm"><?= esc(character_limiter($mod->description, 300)) ?></p>
                    </div>

                    <div class="flex space-x-3 text-sm">
                        <p class="px-2.5 py-1.5 rounded shadow">Author: <?= esc($mod->author_name) ?></p>
                        <p class="px-2.5 py-1.5 rounded shadow">Price: <?= esc($mod->price) ?>€</p>
                        <p class="px-2.5 py-1.5 rounded shadow">Created: <?= date("j M Y, H:i", strtotime($mod->updated_at)) ?></p>
                    </div>
                </div>
            </div>

            <div class="ml-auto flex flex-col space-y-3 text-white text-sm text-center">
                <a href="/mod/<?= esc($mod->id) ?>/approve" class="rounded px-3 py-1.5 bg-green-500">Approve</a>
                <a href="/mod/<?= esc($mod->id) ?>/deny" class="rounded px-3 py-1.5 bg-red-500">Deny</a>
            </div>
        </div>
    <?php endforeach ?>
</div>