<?php /** @var \Kirby\Cms\Block $block */ ?>
<?php  $count = $block->images()->toFiles()->count()  ?>
<?php foreach ($block->images()->toFiles() as $image): ?>

<?php if ($count == 1 && $image->isLandscape() || $image->isSquare()): ?>

<picture>
    <source media="(max-width: 420px)" srcset="
    <?= $image->thumb(['width' => 1000])->url() ?>" data-flickity-lazyload-srcset="
    <?= $image->thumb(['width' => 1000])->url() ?>">
    <source media="(min-width: 421px)" srcset="
    <?= $image->thumb(['width' => 1800])->url() ?>" data-flickity-lazyload-srcset="
    <?= $image->thumb(['width' => 1800])->url() ?>">
    <img src="<?= $image->thumb(['width' => 1800])->url() ?>" width="<?= $image->width() ?>"
        height="<?= $image->height() ?>" alt="<?= $image->alt() ?>" loading="lazy" />
</picture>

<?php elseif ($count == 1 && $image->isPortrait()): ?>

<picture>
    <source media="(max-width: 420px)" srcset="
    <?= $image->thumb(['height' => 1000])->url() ?>" data-flickity-lazyload-srcset="
    <?= $image->thumb(['height' => 1000])->url() ?>">
    <source media="(min-width: 421px)" srcset="
    <?= $image->thumb(['height' => 1200])->url() ?>" data-flickity-lazyload-srcset="
    <?= $image->thumb(['height' => 1200])->url() ?>">
    <img src="<?= $image->thumb(['height' => 1200])->url() ?>" width="<?= $image->width() ?>"
        height="<?= $image->height() ?>" alt="<?= $image->alt() ?>" loading="lazy" />
</picture>

<?php elseif ($count == 2 ): ?>

<picture>
    <source media="(max-width: 420px)" srcset="
    <?= $image->thumb(['width' => 400])->url() ?>" data-flickity-lazyload-srcset="
    <?= $image->thumb(['width' => 400])->url() ?>">
    <source media="(min-width: 421px)" srcset="
    <?= $image->thumb(['width' => 800])->url() ?>" data-flickity-lazyload-srcset="
    <?= $image->thumb(['width' => 800])->url() ?>">
    <img src="<?= $image->thumb(['width' => 800])->url() ?>" width="<?= $image->width() ?>"
        height="<?= $image->height() ?>" alt="<?= $image->alt() ?>" loading="lazy" />
</picture>

<?php elseif ($count > 2 ): ?>

<picture>
    <source media="(max-width: 420px)" srcset="
    <?= $image->thumb(['width' => 300])->url() ?>" data-flickity-lazyload-srcset="
    <?= $image->thumb(['width' => 300])->url() ?>">
    <source media="(min-width: 421px)" srcset="
    <?= $image->thumb(['width' => 500])->url() ?>" data-flickity-lazyload-srcset="
    <?= $image->thumb(['width' => 500])->url() ?>">
    <img src="<?= $image->thumb(['width' => 500])->url() ?>" width="<?= $image->width() ?>"
        height="<?= $image->height() ?>" alt="<?= $image->alt() ?>" loading="lazy" />
</picture>

<?php endif ?>

<?php endforeach ?>