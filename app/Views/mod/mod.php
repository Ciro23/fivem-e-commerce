<div class="container distance max-w-5xl mx-auto flex flex-col space-y-6">
    <?php if ($mod->is_approved === "0") : ?>
        <div class="h-16 rounded p-6 bg-yellow-500 bg-opacity-50 flex flex-wrap content-center">
            <p>This mod is not approved yet. Do you want to approve it?</p>
            <div class="ml-auto space-y-3 text-white text-sm text-center">
                <a href="/approve/mod/<?= $mod->id ?>" class="rounded px-3 py-1.5 bg-green-500">Approve</a>
                <a href="/deny/mod/<?= $mod->id ?>" class="rounded px-3 py-1.5 bg-red-500">Deny</a>
            </div>
        </div>
    <?php endif ?>
    <div class="p-6 shadow rounded-lg flex flex-wrap content-center">
        <div class="flex space-x-4">
            <img src="/assets/mods_images/<?= $mod->id ?>/image.<?= $mod->image_ext ?>" class="w-32 rounded-md">
            <h1 class="font-medium"><?= $mod->name ?></h1>
        </div>

        <div class="ml-auto">
            <a class="px-5 py-2.5 text-sm rounded bg-yellow-500 text-white" href="<?= $mod->id ?>/download">Download</a>
        </div>
    </div>

    <div class="flex justify-between space-x-6">
        <div class="p-6 shadow rounded-lg w-4/6">
            <h3 class="text-lg font-semibold">Description</h3>
            <p><?= $mod->description ?></p>
        </div>

        <div class="p-6 shadow rounded-lg w-1/3">
            <h4 class="text-lg font-semibold">About this mod</h4>

            <ul>
                <li class="flex justify-between">
                    <p>Author:</p>
                    <a href="/user/<?= $mod->author ?>"><?= $mod->author_name ?></a>
                </li>

                <li class="flex justify-between">
                    <p>Price:</p>
                    <p><?= $mod->price == 0 ? "Free" : $mod->price . "€"; ?></p>
                </li>

                <li class="flex justify-between">
                    <p>Uploaded at:</p>
                    <p><?= date("j M, Y", strtotime($mod->created_at)) ?></p>
                </li>

                <li class="flex justify-between">
                    <p>Last update:</p>
                    <p><?= date("j M, Y", strtotime($mod->updated_at)) ?></p>
                </li>

                <li class="flex justify-between">
                    <p>Mod size:</p>
                    <p><?= $mod->size ?> bytes</p>
                </li>
        </div>
    </div>
</div>