<div class="container">
    <div class="heading">
        <img src="/public/assets/mods_images/<?= $mod->id ?>/image.<?= $mod->image_ext ?>">
        <h1><?= $mod->name ?></h1>

        <div class="buttons">
            <a href="<?= $mod->id ?>/download">Download</a>
        </div>
    </div>

    <div class="info">
        <div class="description">
            <h3>Description</h3>
            <p><?= $mod->description ?></p>
        </div>

        <div class="about">
            <h4>About this mod</h4>

            <ul>
                <li>    
                    <p>Author:</p>
                    <p><?= $mod->author_name ?></p>
                </li>

                <li>
                    <p>Price:</p>
                    <p><?= $mod->price == 0 ? "Free" : $mod->price . "€"; ?></p>
                </li>

                <li>
                    <p>Uploaded at:</p>
                    <p><?= date("j M, Y", strtotime($mod->created_at)) ?></p>
                </li>

                <li>
                    <p>Last update:</p>
                    <p><?= date("j M, Y", strtotime($mod->updated_at)) ?></p>
                </li>

                <li>
                    <p>Mod size:</p>
                    <p><?= $mod->size ?> bytes</p>
                </li>
            </div>
        </div>
    </div>
</div>
