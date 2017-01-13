<?php
class User
{
	public $id, $username, $pass;

	public function __construct($id, $username, $pass)
	{
        $this->id = $id; 
		$this->username = $username;
		$this->pass = $pass;
		
	}

    public static function find($id) 
    {
        $con = connectDB("SMC");
		$query = "select * from users where $id=$id";
		$result = mysqli_query($con, $query);
		
		$no = mysqli_num_rows($result);
        mysqli_close($con);
        if($no > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    
    }
    public static function check($username, $password)
    {
        $password = sha1($password);
        $con = connectDB("SMC");
		$query = "select * from users where username='$username' and password='$password'";
		$result = mysqli_query($con, $query);
		
		$no = mysqli_num_rows($result);
        mysqli_close($con);
        if($no > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }   
    } 
    


}


?>