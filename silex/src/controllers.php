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
$app->get('/node/{nid}', function (Silex\Application $app, $nid) {
  $client = $app['elasticsearch'];
  $params = array(
    'index' => 'node',
  );

  if ($nid !== 'empty') {
    $params['body'] = array(
      'query' => array(
        'match' => array(
          'nid' => $nid,
        ),
      ),
    );
  }

  $result = $client->search($params);

  if ($result && $result['hits']['total'] === 0) {
    $app->abort(404, sprintf('Node %s does not exist.', $nid));
  }

  if ($result['hits']['total'] === 1) {
    $node = $result['hits']['hits'];
    return $app['twig']->render('node.html.twig', array('node' => reset($node)));
  }

  return new Response('Here there should be a listing of nodes...');

})->value('nid', 'empty');
