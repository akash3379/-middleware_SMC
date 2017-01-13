<?php
  class URLsController {

    public function index() {
      // we store all the posts in a variable
      $urls = URL::all();
      require_once('views/urls/index.php');
    }

    public function show($id) {
      // we expect a url of form ?controller=posts&action=show&id=x
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if(sizeof($id)>0)
        $id = $id[0];
        else if(isset($_GET['id'])&&$_GET['id']!='')
            $id = $_GET['id'];
      else            
            return call('pages','home');
          
         
        $url_data = URL::find($id);
        $param_list = URL::param_list($url_data->url);
        $table_list = URL::table_list("Dept");
        
        foreach ($table_list as $var) {
          $column_list[$var] = URL::col_list("Dept",$var);
        } 
        
        $mappings = URL::get_mappings($url_data->id);
        
        require_once('views/urls/show.php');
      
    }

    public function add()
    {
        $url = $_POST['url'];
        $des = $_POST['description'];
        $shortname = $_POST['shortname'];
        if(URL::findByURL($url))
        {   
            return call('urls', 'show', $url);
        }
        else
        {
            $id = URL::add($url, $des, $shortname);
            URL::add_params($url);
            return call('urls', 'show', $id);
        }
    }
  }
  //http://localhost/middleware_mvc/?controller=mappings&action=use_mapping&id=1
  //http://localhost/middleware_mvc/?controller=mappings&action=use_mapping&id=2
?>