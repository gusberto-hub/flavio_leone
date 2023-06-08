<?php

return [
'debug' => false,

'routes' => [
    [
        'pattern' => 'sitemap.xml',
        'action'  => function() {
            $pages = site()->pages()->index();
  
            // fetch the pages to ignore from the config settings,
            // if nothing is set, we ignore the error page
            $ignore = kirby()->option('sitemap.ignore', ['error','about','projects/commissions']);
  
            $content = snippet('sitemap', compact('pages', 'ignore'), true);
  
            // return response with correct header type
            return new Kirby\Cms\Response($content, 'application/xml');
        }
      ],
      [
        'pattern' => 'sitemap',
        'action'  => function() {
          return go('sitemap.xml', 301);
        }
    ],
    [
        'pattern' => 'projects/personal/(:all)',
        'action' => function($uid) {
        go($uid);
        }
    ],
    [
        'pattern' => 'projects/commissions/(:all)',
        'action' => function($uid) {
        go($uid);
        }
    ],
    [
        'pattern' => 'projects/index/(:all)',
        'action' => function($uid) {
        go($uid);
        }
    ],
    [
        'pattern' => '(:any)(:all)',
        'action' => function($u1,$u2) {
        $page = page($u1.$u2);
        
        if(!$page) $page = page('projects/personal/' . $u1.$u2);
        if(!$page) $page = page('projects/commissions/' . $u1.$u2);
        if(!$page) $page = page('projects/index/' . $u1.$u2);
        if(!$page) $page = site()->errorPage();
        
        return site()->visit($page);
        }
    ],
  ]

];

?>