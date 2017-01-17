<?php

class MappingsController{

    public function use_mapping($id)
    {   
        if(isset($_GET['id'])&&$_GET['id']!='')
            $id = $_GET['id'];

        Mapping::use_mapping($id);
        $mapping_data = Mapping::find($id);
        $url_data = URL::findByURL($mapping_data->url);
        
        return call('urls','show',$url_data->id);
    }

    public function add()
    {
        $params = $_POST['para'];
        $vals = $_POST['table'];
        $total = count($params);
        
        
        for($i = 0; $i < $total; $i++)
        {
            $map[$i] = array($params[$i],$vals[$i], "Col1");
        }
        
        $url = $_POST['url'];
        
        $user = "test_user_vasu";
        $desc = "Test Desc"; 
        Mapping::add($url,$map,$user,$desc);
        $url_data = URL::findByURL($url);
        return call('urls','show',$url_data->id);

    }
}

?>