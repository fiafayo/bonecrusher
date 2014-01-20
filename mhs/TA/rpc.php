<?
require("../../include/global.php");
require("../../include/fungsi.php");


f_connecting();
	mysql_select_db($DB);
	
		if(isset($_POST['queryString'])) {
			$queryString = $_POST['queryString'];		
			if(strlen($queryString) >0) {
				$query = "SELECT nama FROM master_mhs WHERE nama LIKE '$queryString%' LIMIT 10";
				$result = mysql_query($query) or die("There is an error in database please contact support@ExploreMyBlog.Com");
					while($row = mysql_fetch_array($result)){
					echo '<li onClick="fill(\''.$row[nama].'\');">'.$row[nama].'</li>';                                         
      }
	  }
	  }
?>