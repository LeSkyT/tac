<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class BackgroundController extends Controller {
  public function getAction($dimensions) {
    $return = array();
    
    $this->view->setRenderLevel(
      View::LEVEL_ACTION_VIEW
    );

    list($x, $y) = explode("x", $dimensions, 2);

    $background = new BgCreate($x,$y);

    $url = $background->saveImg();
    
    $return["url"] = $url;

    $this->view->backgroundUrl = $return;
  }
}

