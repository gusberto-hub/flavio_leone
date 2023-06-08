<?php snippet('header') ?>
<?php snippet('navigation') ?>

<main class="main-container">
    <div class="main-carousel">
        <?php foreach ($page->layout()->toLayouts() as $layout): ?>

        <?php foreach ($layout->columns() as $column): ?>
        <div class="carousel-cell">
            <div class="cell-ratio">
                <div class="flex-container">
                    <?= $column->blocks() ?>
                </div>
            </div>
        </div>
        <?php endforeach ?>
        <?php endforeach ?>

        <div class="carousel-cell">
            <?php
                function generateRandomProject(){
                     return $randomProject=
                    page('projects/index')
                      ->children()
                      ->listed()
                      ->shuffle()
                      ->first();
                }

                $randomProject = generateRandomProject();
                if ($randomProject == $page ? $randomProject = generateRandomProject() : $randomProject);
            ?>
            <div class="cell-ratio">
                <div class="flex-container">
                    <div class="last-slide vcr-font">
                        <a href="<?= $randomProject->url()?>">
                            <picture>
                                <?php $image = $randomProject->files()->sortBy('sort')->first() ?>
                                <img src="<?=  $image->thumb(['width' => 600])->url() ?>" alt="<?=  $image->alt()?>">
                            </picture>
                            <p>Show random project</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="index-btn">
    <a href="<?= 'projects/index#' . $page->uid() ?>">index</a>

</div>

<?php snippet('footer') ?>