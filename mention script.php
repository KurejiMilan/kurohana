<?php
$dbServername="localhost";
$dbUsername="root";
$dbPassword="";
$dbName="Kakumei_studios";

$conn=mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName) or die('couldn\'t connect to Server');
//global $conn;
echo CheckMentions("@@CMrai is the CEO of kurohana while @Midoriya,@@Naruto,@perter,@OnePunchMan is our hero.<script>alert(\"Hello\")</script>");
function convertLinks($link)
{
	$conn=$GLOBALS['$conn'];
	if(strpos($link,"@")!==false){
    	$startpos=strpos($link, "@");
    	$linkchecked="";//this hold the string which has been coverted to link
    	$bool=false;//this is not a good name for a varaiable i know
    	if($startpos!=0)
    	{
    		$count=0;
    		$newlink=substr($link,$startpos);
        	$linkchecked=htmlspecialchars(substr($link,0,$startpos));
        	$startpos=0;
        	$strlen=strlen($link)-strlen($linkchecked);
        	while($bool===false)
        	{
        		if($startpos===$strlen)
        		{
        		 $bool=true;
                 return $linkchecked.'@'.convertLinks(substr($newlink,1));
        		}
        		$temUsername=substr($newlink,$startpos+1,$strlen-1);
        		$query_username=mysqli_real_escape_string($conn,$temUsername);
        		$result=mysqli_query($conn,"SELECT * FROM users WHERE username="."'$query_username'".";") or die("couldn't do query");
        		if(mysqli_num_rows($result)===1)
        		{	
        			$linkchecked.='<a href="profile.php?user='.$query_username.'" style="color:blue;font-weight:bold;">@'.$query_username.'</a>';
        			$bool=true;
        		}
                $strlen-=1;
               
        	}
        	
        	return $linkchecked.convertLinks(substr($newlink,$strlen+1));
    	}
    	else
    	{
    		$strlen=strlen($link);
        	while($bool===false)
        	{
        		if($startpos===$strlen-1)
        		{
        		 $bool=true;
                 return $linkchecked.'@'.convertLinks(substr($link,1));
        		}
        		$temUsername=substr($link,$startpos+1,$strlen-1);
        		$query_username=mysqli_real_escape_string($conn,$temUsername);
        		$result=mysqli_query($conn,"SELECT * FROM users WHERE username="."'$query_username'".";");
        		if(mysqli_num_rows($result)===1)
        		{	
        			$linkchecked.='<a href="profile.php?user='.$query_username.'" style="color:blue;font-weight:bold;">@'.$query_username.'</a>';
        			$bool=true;
        		}
                --$strlen;
        	}
   
        	return $linkchecked.convertLinks(substr($link,$strlen+1));
    	}
	}
	else{
		return htmlspecialchars($link);
	}
}

function CheckMentions($string) 
{
	$array=explode(" ", $string);
	$arrayelement=count($array);
	for($i=0;$i<$arrayelement;$i++)
 	{
 		if(strpos($array[$i],"@")!==false)
 		{
      		$array[$i]=convertLinks($array[$i]);
 		}
 		else
 		{
 			$array[$i]=htmlspecialchars($array[$i]);
 		}
 	}
	$string=implode(" ",$array);
	return $string;
} 
?>