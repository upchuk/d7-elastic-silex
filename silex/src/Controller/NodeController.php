<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class NodeController {

  /**
   * Shows a listing of nodes.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function index() {
    return new Response('Here there should be a listing of nodes...');
  }

  /**
   * Shows one node
   *
   * @param $nid
   * @param \Silex\Application $app
   * @return mixed
   */
  public function show($nid, Application $app) {
    $client = $app['elasticsearch'];
    $params = array(
      'index' => 'node',
      'body' => array(
        'query' => array(
          'match' => array(
            'nid' => $nid,
          ),
        ),
      )
    );

    $result = $client->search($params);

    if ($result && $result['hits']['total'] === 0) {
      $app->abort(404, sprintf('Node %s does not exist.', $nid));
    }

    if ($result['hits']['total'] === 1) {
      $node = $result['hits']['hits'];
      return $app['twig']->render('node.html.twig', array('node' => reset($node)));
    }
  }
}