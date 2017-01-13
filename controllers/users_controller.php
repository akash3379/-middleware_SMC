<?php
  class UsersController {
    
    public function show() {
      // we expect a url of form ?controller=posts&action=show&id=x
      // without an id we just redirect to the error page as we need the post id to find it in the database
      $username = $_POST['username'];
      $password = $_POST['password'];
      if (User::check($username, $password))
        return call('urls','index');
      else
        return call('pages', 'home');

    }
  }
?>