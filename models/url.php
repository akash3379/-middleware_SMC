<?php
require_once("models/mapping.php");
class URL
{
	public $id, $url, $des, $shortname;

	public function __construct($id, $url, $des, $shortname)
	{
        $this->id = $id; 
		$this->url = $url;
		$this->des = $des;
		$this->shortname = $shortname;
	}

    public static function all()
    {
        $urls = array();
		$con = connectDB("SMC");
		$query = "select * from urls";
		$result = mysqli_query($con, $query);
		mysqli_close($con);
		while($url_data=mysqli_fetch_assoc($result))
		{
            $id = $url_data['id'];
			$url = $url_data['url'];
			$des = $url_data['description'];
			$shortname = $url_data['shortname'];
			array_push($urls, new URL($id, $url, $des, $shortname));
		}
		return $urls;
    }
    public static function find($id) 
    {
		
		$con = connectDB("SMC");
		$query = "select * from urls where id=$id";
		$result = mysqli_query($con, $query);
		mysqli_close($con);
		if(mysqli_num_rows($result) > 0)
        {
			$row = mysqli_fetch_assoc($result);
            return new URL($row['id'], $row['url'], $row['description'], $row['shortname']);
        }
        else
            return 0;
    }

    public static function findByURL($url)
    {
        $con = connectDB("SMC");
		$query = "select * from urls where url='$url'";
		$result = mysqli_query($con, $query);
		mysqli_close($con);
		
		if(mysqli_num_rows($result) > 0)
        {
			$row = mysqli_fetch_assoc($result);
            return new URL($row['id'], $row['url'], $row['description'], $row['shortname']);
        }
        else
            return 0;
    
    }

    public static function add($url,$des,$shortname)
    {
        $con = connectDB("SMC");
        $query = "insert into urls(url,description,shortname) values('$url','$des','$shortname')";
        $result = mysqli_query($con, $query);
		$id = mysqli_insert_id($con);
        mysqli_close($con);
        
        if($result)
        {
            //addURLParams($url);
            return $id;
        }
        else
            return 0;
    }
    public static function param_list($url)
    {
        $data = file_get_contents($url);
		$data = json_decode($data, true);

		$params = array_keys($data[0]);

		return $params;
    }

    public static function add_params($url){
		/*
		Add into the table parameters
		*/

		$con = connectDB("SMC");
		$params = URL::param_list($url);
		$url_data = URL::findByURL($url);
		foreach ($params as $p) {
			$query = "insert into parameters(url_id,parameter_name) 
			values('$url_data->id','$p')";
			$res = mysqli_query($con, $query);
			if(!$res)
				return "ERROR";
		}
		mysqli_close($con);
		return 1;
	}

    public static function table_list($db)
    {
        $con = connectDB($db);
		$query = "SHOW TABLES FROM `$db`";
		$result = mysqli_query($con, $query);
		$count=0;
		while($r=mysqli_fetch_array($result))
			$t[$count++]=$r[0];
		mysqli_close($con);
		return $t;

    }

    public static function col_list($db, $table)
    {
        $con = connectDB($db);
		$query = "SHOW COLUMNS FROM `$table`";
		$result = mysqli_query($con, $query);
		$count=0;
		while($r=mysqli_fetch_array($result))
			$t[$count++] = $r[0];
		mysqli_close($con);
		return $t;
    }
	public static function get_mappings($url_id)
	{
		return Mapping::get($url_id);
	}

	public static function param_name($param_id)
	{
		$con = connectDB("SMC");
		
		$query = "select * from parameters where id=$param_id";
		$result = mysqli_query($con, $query);
		mysqli_close($con);

		return mysqli_fetch_assoc($result)['parameter_name'];
	}

	public static function param_id($param_name, $url)
	{
		$con = connectDB("SMC");
		$url_data = URL::findByURL($url);
		$query = "select * from parameters where url_id=$url_data->id and parameter_name='$param_name'";
		$result = mysqli_query($con, $query);
		mysqli_close($con);

		return mysqli_fetch_assoc($result)['id'];
	}

}


?>