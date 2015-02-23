<?php

use Symfony\Component\HttpFoundation\Response;

/**
 * Error handler
 */
$app->error(function (\Exception $e, $code) {
  switch ($code) {
    case 404:
      $message = $e->getMessage();
      break;
    default:
      $message = 'We are sorry, but something went terribly wrong. ' . $e->getMessage();
  }

  return new Response($message);
});

/**
 * Route for /node
 */
$app->get("/node", "Controller\\NodeController::index");

/**
 * Route /node/{nid} where {nid} is a node id
 */
$app->get("/node/{nid}", "Controller\\NodeController::show");