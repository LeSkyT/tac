<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller {
  
  public function loginAction() {
  
  }

  public function createAction() {
  
  }

  public function registerAction() {
    $this->session->remove('user');
    //eventually tell the user he is logged out :p
    $this->redirect();
  }
}
