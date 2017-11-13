<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class MinecraftController extends Controller {
  public function statusAction() {
  	$this->view->disable();
  	$this->response->setContentType('application/json', 'UTF-8');
  	
    $status = array();
    $server = new Query("192.168.1.26");

    if ($server->connect()) {
      $info= $server->get_info();
      $status['online'] = True;
      
      $status['playerInfo'] = array();
      $status['playerInfo']['max'] = $info['maxplayers'];
      $status['playerInfo']['count'] = $info['numplayers'];
      $status['playerInfo']['list'] = $info['players'];
    } else {
    	$status['online'] = False;
    }
    
    $this->response->setContent(json_encode($status));
    
    return $this->response;
  }

  public function getfaceAction($user) {
    $this->view->setRenderLevel(
      View::LEVEL_ACTION_VIEW
    );
    $avatar = new Skin($user, 48);

    $this->view->image = $avatar->getFace(); 
  }

}

