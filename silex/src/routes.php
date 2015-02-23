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
 * Callback for node route /node/{nid} where {nid} is an optional node id
 */
$app->get("/node", "Controller\\NodeController::index");
$app->get("/node/{nid}", "Controller\\NodeController::show");