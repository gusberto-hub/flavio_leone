<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $site->metaDescription() ?>">
    <!-- Für Apple-Geräte -->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon-180x180.png">
    <!-- Für Browser -->
    <link rel="shortcut icon" type="image/x-icon" href="/favicon/favicon-32x32.ico">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <!-- Für Windows Metro -->
    <meta name="msapplication-square310x310logo" content="./favicon/mstile-310x310.png">
    <meta name="msapplication-TileColor" content="[HEXFARBE (z.B. #000000)]">
    <script>
    document.getElementsByTagName("html")[0].className += " js";
    </script>
    <!-- <?= css('assets/css/style.css');?> -->
    <?= Bnomei\Fingerprint::css('assets/css/style.css');?>
    <title><?= $site->title()?>
        <?php e($page->isChildOf('projects/index') || $page->isChildOf('projects/commissions'), ' » '. $page->projecttitle(), '| Photographer & Director') ?>
    </title>
</head>

<body>