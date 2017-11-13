<?php

class IndexController extends ControllerBase
{
    public function indexAction()
    {
	$this->view->serverName = $_SERVER['SERVER_NAME'];
    }
}
