<?php
require_once("models/url.php");
class Mapping
{
	public $id, $url, $created_by, $created_on, $modified_by, $modified_on, $map, $des;

	public function __construct($id, $url, $map, $created_by, $created_on,
		$modified_by, $modified_on, $des)
	{
        $this->id = $id;
		$this->url = $url;
		$this->created_by = $created_by;
		$this->created_on = $created_on;
		$this->modified_on = $modified_on;
		$this->modified_by = $modified_by;
		$this->map = $map; 	
		$this->des = $des;	
	}
    
    public static function get($url_id) 
    {	
		$con = connectDB("SMC");
		$mappings = array();
		$url_data = URL::find($url_id);
		
		$query = "select * from mapping_def where url_id=$url_data->id";
		$result = mysqli_query($con, $query);
		while($r = mysqli_fetch_assoc($result))
		{
			$map_id = $r['id'];
			$des = $r['description'];
			$query = "select * from mapping_data where map_id=$map_id";
			$res = mysqli_query($con, $query); 	
			$i=0;
			while($m = mysqli_fetch_assoc($res))
			{
				$param_name = URL::param_name($m['param_id']);
				$dept_col = array($param_name,$m['dept'], $m['col_name']);
				$map[$i] = $dept_col;
				$i++;
			}
			array_push($mappings, new Mapping($map_id, $url_data->url, $map, $r['created_by'], $r['created_on'], $r['edited_by'], $r['edited_on'], $des));
		}
		

		mysqli_close($con);
		return $mappings;
    }
    
    
    public static function find($id)
    {
    	// return the mapping object corresponding to this map id
    	$con=connectDB("SMC");
    	$mapping=array();
    	$query="select * from mapping_def where id=$id";
  
    	$result=mysqli_query($con,$query);
    	
  	
  	
		$r=mysqli_fetch_assoc($result);
		$url_data = URL::find($r['url_id']);
		$des = $r['description'];

		$query1="select * from mapping_data where map_id=$id";
		$result1=mysqli_query($con,$query1);
		$i=0;
		while($m=mysqli_fetch_assoc($result1))
		{
				$param_name = URL::param_name($m['param_id']);
				$dept_col = array($param_name,$m['dept'], $m['col_name']);
				$map[$i] = $dept_col;
				$i++;
		} 
		mysqli_close($con); 	
			return new Mapping($id, $url_data->url, $map, $r['created_by'], $r['created_on'], $r['edited_by'], $r['edited_on'], $des);
    	
    }

    public static function use_mapping($map_id)
    {
    	// take map id and get the mapping object. then use it to fetch the data and store in dept db
    	$mapping = Mapping::find($map_id);
    	$data = file_get_contents($mapping->url);
		$data = json_decode($data, true);
		$con=connectDB("dept");
		foreach($mapping->map as $i => $dept_col)
		{
			$dept=$dept_col[1];
			$col=$dept_col[2];
			$count=sizeof($data);
			for($j=0;$j<$count;$j++)
			{
				$d=$data[$j][$dept_col[0]];
				$query="insert into $dept values('$d',NULL,NULL,NULL)";
				//echo $query."<br>";
				mysqli_query($con,$query);
			}
		}
		mysqli_close($con); 

    }

	public static function add($url,$map,$user,$desc)
	{
		$map_id=-1;
		$con = connectDB("SMC");
		$url_data = URL::findByURL($url);
		$query = "insert into mapping_def(url_id,created_by,created_on,edited_by,edited_on,description) 
		values($url_data->id,'$user',now(),'$user',now(),'$desc')";
		$result = mysqli_query($con, $query);
		if($result)
		{
			$map_id = mysqli_insert_id($con);
			var_dump($map);
			foreach ($map as $i => $db_col_name) {
				$param_name=$db_col_name[0];
				$param_id = URL::param_id($param_name, $url);
				$dept = $db_col_name[1];
				$col_name = $db_col_name[2];
				$query = "insert into mapping_data(map_id,param_id,dept,col_name) 
					values($map_id,$param_id,'$dept','$col_name')";
				$result = mysqli_query($con, $query);
				if(!$result)
					return -1;
			}

		}
		else
		{
			mysqli_close($con);
			return -1;
		}
		
	}

}
?>