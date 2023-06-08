<main class="main-container">

    <div class="project-grid">

        <?php foreach($page->children()->listed() as $project): ?>

        <a href="<?= $project->url() ?>" class="project" id="<?= $project->uid() ?>">
            <div class="thumbnail">
                <picture>
                    <?php $thumbnail = $project->images()->sortBy('sort')->first()->thumb(['width' => 500]) ?>
                    <img src="  <?= $thumbnail->url() ?>" alt=" <?= $project->title() ?>"
                        width="<?= $thumbnail->width() ?>" height="<?= $thumbnail->height()?>">
                </picture>

            </div>
            <div class="description vcr-font">
                <p>
                    <?=$project->projecttitle()?><?php if (               $project->subtitle()->isNotEmpty()): ?>,
                    <?=$project->subtitle() ?>
                    <?= $project->location() ?>
                    <?= $project->year() ?>
                    <?php endif ?>
            </div>
        </a>

        <?php endforeach ?>


    </div>

</main>