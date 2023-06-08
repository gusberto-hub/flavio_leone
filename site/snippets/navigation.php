    <header class="fixed-container <?php e($page->isChildOf(page('projects/index')), 'solid-bg') ?>">

        <div class="logo">
            <a href="<?= $site->url() ?>" class=''>
                <?php $logoImage = $site->file('Flavio_Leone_Logo.svg')?>
                <img src=" <?= $logoImage->url()
            
                ?>" alt="Flavio Leone Logo" width="<?= $logoImage->width() ?>" height="<?= $logoImage->height() ?>">

            </a>
        </div>

        <div class="menu-btn">
            <button class="header-text" type="button">
                Menu
            </button>
        </div>

        <nav class="navigation">
            <div class="nav-overlay">
            </div>

            <div class="nav-items">
                <a class="header-text" href="<?= '#' . e($page->isChildOf('projects/index'), page('projects/index') . '#' . $page->uid())
                  ?>">Index</a>
            </div>
            <div class="nav-footer">
                <div class="nav-contact">
                    <div class="header-text">
                        <nobr> <a href="tel:<?= $site->phone_mobile()?>"> <?= $site->phone_mobile()?></a></nobr>
                    </div>
                    <div>
                        <nobr> <a href="mailto:<?= $site->email()?>"> <?= $site->email()?></a></nobr>
                    </div>
                    <div>
                        <nobr> <a href="<?= $site->instagram()?>" target='_blank' rel="noopener"> instagram</a> </nobr>
                    </div>
                </div>
                <div class="nav-imprint vcr-font">
                    <p>concept/design: <a href="https://kuba.studio" rel="noopener">kuba creative services</a> </p>
                    <p>code: <a href="https://vonwilhelm.ch" rel="noopener">vonwilhelm</a> </p>
                </div>
            </div>
        </nav>

        <?php if ($page->isChildOf('projects')): ?>

        <?php elseif ($page->isDescendantOf('projects')): ?>

        <div class="project-title hideOnLastSlide">
            <h1 class="header-text"><?= $page->projecttitle() ?> </h1>
            <h2 class="header-text">
                <?php if ($page->subtitle()->isNotEmpty()): ?>
                <?=' ', $page->subtitle(),', ' ?>
                <?php endif ?>
                <?= $page->year()?>
            </h2>
        </div>

        <div class='project-toggle hideOnLastSlide'>
            <button class='vcr-font'>info</button>
            <div class="slides-counter">
                [<span class=acutalSlide>1</span>/<span class=totalSlides>1</span>]
            </div>
        </div>
        <div class="project-text vcr-font">
            <?= $page->projectinfo()->kirbytext()?>
        </div>
        <?php endif ?>

    </header>