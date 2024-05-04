<?php

namespace Drupal\drupal_form\Controller;

use Drupal\Core\Controller\ControllerBase;

class Drupal_FormController extends ControllerBase
{

  public function content()
  {
   
    // Define the content type you want to load.
    $content_type = 'students';

    // Load nodes of the specified content type.
    $query = \Drupal::entityQuery('node')
      ->condition('type', $content_type);
    $nids = $query->execute();

    // Load nodes using the node storage.
    $nodes['nodes'] = \Drupal\node\Entity\Node::loadMultiple($nids);

    // Add your custom form.
    $build['form'] = $this->formBuilder()->getForm('Drupal\drupal_form\Form\DrupalForm');
    $build['table'] = [
      '#theme' => 'drupal_table',
      '#data' => $nodes,

    ];
    // dd($build['form']);

    return $build;

  }
  
  
}

