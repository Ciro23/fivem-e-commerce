<div class="container">
    <h1>List of all pending mods</h1>
    <?php
    $i = 0;
    foreach ($mods as $mod) :
        // alternates mods with a different background color
        $i++;
        $alternativeColor = "";
        if ($i % 2 == 0) {
            $alternativeColor = "alternative-color";
        }
    ?>


        <div class="mod <?= $alternativeColor ?>">
            <a href="/mod/<?= $mod->id ?>">
                <img src="/public/assets/mods_images/<?= $mod->id . "/image." . $mod->image_ext ?>">
            </a>

            <div class="info">
                <div>
                    <a href="/mod/<?= $mod->id ?>">
                        <h2><?= $mod->name ?></h2>
                    </a>
                    <p><?= character_limiter($mod->description, 500) ?></p>
                </div>

                <div>
                    <p class="author">Author: <?= $mod->author_name ?></p>
                    <p class="price">Price: <?= $mod->price ?>€</p>
                    <p class="creation">Uploaded at: <?= $mod->created_at ?></p>
                </div>
            </div>

            <div class="buttons">
                <a href="/mod/<?= $mod->id ?>/approve">Approve</a>
                <a href="/mod/<?= $mod->id ?>/deny">Deny</a>
            </div>
        </div>
    <?php endforeach ?>
</div>