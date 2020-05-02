<?php  
require ("includefiles/header.inc.php");
 $type="";
 $title="";
 $textbody="";
 $id=0;
 $photo_array=array();
 $i=0;
 $date=date("Y:m:d");
 if(is_array($_FILES) && !empty($_FILES['files']))   
 {   
      $qusername=mysqli_real_escape_string($conn,$user);
      $caption=mysqli_real_escape_string($conn,$_POST['caption']);
      $tag=mysqli_real_escape_string($conn,$_POST['tag']);
      $visibility = mysqli_real_escape_string($conn, $_POST['audience']);
      $total_images=$_POST['totalimages'];
      if($total_images>1){
      $type="photos";
      }
      else{
      $type="photo";
      }
          $result=mysqli_query($conn,"SELECT * FROM users WHERE username="."'$qusername'".";") or die("ERROR!");
          if(mysqli_num_rows($result)==1) {
            $content=mysqli_fetch_assoc($result);
            $id=$content['userid'];
            $res=mysqli_query($conn,"SELECT * from posts WHERE username="."'$qusername'"." AND userid=$id;");
            $resnum=mysqli_num_rows($res);
            $resnum+=1;

            foreach ($_FILES['files']['name'] as $name => $filename) {
              $test = explode('.', $_FILES['files']['name'][$name]);
              $ext = end($test);
              $uniqueid=uniqid('',true);
              $photoname = $user.$id.$uniqueid.$resnum.$i.'.'. $ext;
              $photo_array[$i]=$photoname;
              $location = './posts/' . $photoname; 
              move_uploaded_file($_FILES["files"]["tmp_name"][$name],$location);
              $i+=1;
            }
            $file_names=implode(" ",$photo_array);
            $sql="INSERT INTO posts(id,userid,username,title,caption,link,textbody,tag,dt,type,visibility) VALUES('','$id','$qusername','$title','$caption','$total_images','$file_names','$tag','$date','$type', '$visibility');";        
            mysqli_query($conn,$sql) or die("ERROR!");
            $post_type = "post_".$type;
            $recentInsertId = mysqli_insert_id($conn);
            insertPost($recentInsertId, "", $caption,$post_type);  
          }                  
 }
 ?>  