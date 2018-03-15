<?php

class Loader {

  public function view($view, $data = []) {
    foreach ($data as $key=>$value) $$key = $value;
    include "views/${view}.php";
  }

  public function load($view = null, $data = []) {
    $this->define_helper();
    $this->view('header', $data);
    if ($view!==null) $this->view($view, $data);
    $this->view('footer', $data);
  }

  public function define_helper() {
    function set_value($name) {
  return isset($_POST[$name])?htmlentities($_POST[$name]):'';
}
  }
}
