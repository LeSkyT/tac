<?php

use Phalcon\Mvc\View;
use Phalconon\Mvc\Controller;

class AvatarController extends Controller {

  public function getfaceAction($user) {
    $this->view->setRenderLevel(
      View::LEVEL_ACTION_VIEW
    );
    $avatar = new Skin($user, 48);

    $this->view->image = $avatar->getFace(); 
  }

}
