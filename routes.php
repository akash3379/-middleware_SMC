<?php
  function call($controller, $action,...$params) {
    // require the file that matches the controller name
    require_once('controllers/' . $controller . '_controller.php');

    // create a new instance of the needed controller
    switch($controller) {
      case 'pages':
        $controller = new PagesController();
      break;
      case 'urls':
        require_once('models/url.php');
        $controller = new URLsController();
        break;
      case 'mappings':
        require_once('models/mapping.php');
        $controller = new MappingsController();
        break;
      case 'users':
        require_once('models/user.php');
        $controller = new UsersController();
        break;
    }

    // call the action
    $controller->{ $action }($params);
  }

  // just a list of the controllers we have and their actions
  // we consider those "allowed" values
  $controllers = array('pages' => ['home', 'error'], 
                        'urls' => ['index','show','add'], 
                        'mappings' => ['index','show','use_mapping','add'],
                        'users' => ['show']);

  // check that the requested controller and action are both allowed
  // if someone tries to access something else he will be redirected to the error action of the pages controller
  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
?>