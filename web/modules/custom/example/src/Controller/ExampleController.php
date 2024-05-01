<?php

namespace Drupal\example\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for the example page.
 */
class ExampleController extends ControllerBase
{

  /**
   * Returns the content for the example page.
   */
  public function content()
  {
    // dd("hi");
    // You can replace this with whatever content you want to display.
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World!'),
    ];
  }
  public function contents()
  {
    // dd("hi");
    // You can replace this with whatever content you want to display.
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Themes in Drupal sites. Themes are what make a Drupal website look the way it does. Themers, or theme developers, use HTML, CSS, JavaScript, and other front-end assets in order to implement a design for their site. Each individual theme is a collection of files that define the presentation layer for your application.'),
    ];
  }

}
