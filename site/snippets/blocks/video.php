<?php /** @var \Kirby\Cms\Block $block */ ?>
<?php if ($block->url()->isNotEmpty()): ?>
<figure class="video">
    <?= video($block->url(),[
    'youtube' => [
      'autoplay' => 1,
      'controls' => 0,
      'mute'     => 1
    ],
    'vimeo' => [
      'autoplay' => false,
      'controls' => false,
      'muted'     => false,
      'dnt' => true,
    ],
  ]) ?>

</figure>

<script src="https://player.vimeo.com/api/player.js"></script>
<script>
var iframe = document.querySelector('iframe');
var player = new Vimeo.Player(iframe);

player.on('play', function() {
    console.log('Played the video');
});
</script>
<?php endif ?>