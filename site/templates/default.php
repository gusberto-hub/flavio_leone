<?php snippet('header') ?>

<main id="cover-project" class="cover-project">

    <?php
            $coverproject = page('projects')
            ->children()
            ->children()
            ->listed()
            ->filterBy('cover', true)
            ->shuffle()
            ->first();

            $image = $coverproject->images()->sortBy('sort')->first();
        ?>

    <a class="cover-image" href="<?= page('projects/index')->url()?>">
        <?php if ($image->isLandscape()): ?>
        <picture>
            <source media="(max-width: 420px)" srcset="
                        <?= $image->thumb(['width' => 400])->url() ?>">
            <source media="(min-width: 421px)" srcset="
                        <?= $image->thumb(['width' => 1400])->url() ?>">
            <img src="<?= $image->thumb(['width' => 1400])->url() ?>" width="<?= $image->width() ?>"
                height="<?= $image->height() ?>" alt="<?= $image->alt() ?>" />
        </picture>
        <?php else:?>
        <picture>
            <source media="(max-width: 420px)" srcset="
                        <?= $image->thumb(['width' => 400])->url() ?>">
            <source media="(min-width: 421px)" srcset="
                        <?= $image->thumb(['height' => 1000])->url() ?>">
            <img src="<?= $image->thumb(['height' => 1000])->url() ?>" width="<?= $image->width() ?>"
                height="<?= $image->height() ?>" alt="<?= $image->alt() ?>" />
        </picture>
        <?php endif?>
    </a>

    <nav class="cover-logo">
        <img src="<?= $site->image()->url() ?>" alt="Flavio Leone Logo" width="<?= $site->image()->width() ?>"
            height="<?= $site->image()->height() ?>">

    </nav>
</main>

<?php snippet('footer') ?>