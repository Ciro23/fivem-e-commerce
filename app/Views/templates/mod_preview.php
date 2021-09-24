<div class="flex h-42 shadow-md rounded p-6">
    <div class="flex space-x-6">
        <a href="/mod/<?= $mod->id ?>" class="w-36">
            <img src="/assets/mods_images/<?= $mod->id . "/image." . $mod->image_ext ?>" class="rounded">
        </a>

        <div class="flex flex-col w-3/4 justify-between space-y-5">
            <div>
                <a href="/mod/<?= $mod->id ?>">
                    <h2 class="font-semibold"><?= $mod->name ?></h2>
                </a>
                <p class="text-sm"><?= character_limiter($mod->description, 300) ?></p>
            </div>

            <div class="flex space-x-3 text-sm">
                <p class="px-2.5 py-1.5 rounded shadow">Author: <?= $mod->author_name ?></p>
                <p class="px-2.5 py-1.5 rounded shadow">Price: <?= $mod->price ?>€</p>
                <p class="px-2.5 py-1.5 rounded shadow">Created: <?= date("j M Y, H:i", strtotime($mod->updated_at)) ?></p>
            </div>
        </div>
    </div>
</div>