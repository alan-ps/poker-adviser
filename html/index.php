<?php

require_once 'autoload.php';

// Use the Twig template engine in order to render a page.
$loader = new Twig_Loader_Filesystem(getcwd() . '/templates');
$twig = new Twig_Environment($loader, [
  'cache' => 'twig_compilation_cache',
  // For testing purposes only.
  'auto_reload' => true,
  'debug' => true,
]);

$twig->addExtension(new Twig_Extension_Debug());
echo $twig->render('index.html');
