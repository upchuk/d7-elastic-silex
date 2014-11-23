<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Elasticsearch\Client;

$app = new Application();
$app->register(new TwigServiceProvider());

// Creating service for the connection to Elastic
$app['elasticsearch'] = function() {
  return new Client(array());
};

// Using Twig
$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
  return $twig;
}));
$app['twig.path'] = array(__DIR__.'/../templates');

return $app;
