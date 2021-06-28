<div>
    <ul>
        <?php foreach ($errors as $error) : ?>
            <li class="text-red-600 text-center"><?= esc($error) ?></li>
        <?php endforeach ?>
    </ul>
</div>