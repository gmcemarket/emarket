<?php

$servername = "localhost";
$username = "root";
$password = "rootpassword";
$db = "ecommerce";

// Create connection
$con = mysqli_connect($servername, $username, $password,$db);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
date_default_timezone_set('Asia/Manila');

function fetch_user_chat_history($from_user_id, $to_user_id, $con)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = $from_user_id 
 AND to_user_id = $to_user_id
 OR from_user_id = $to_user_id 
 AND to_user_id = $from_user_id 
 ORDER BY timestamp DESC
 ";
 $result=mysqli_query($con,$query);
mysqli_fetch_all($result,MYSQLI_ASSOC);
 $output = '<ul class="list-unstyled">';
 foreach($result as $row)
 {
  $user_name = '';
  if($row["from_user_id"] == $from_user_id)
  {
  $output .= '<b class="text-success" style="float:right;">You</b>
                  <li style="border-bottom:1px dotted #ccc">
   <p style="float:right;">'.$row["chat_message"].' - 
    <div align="right">
     - <small><em>'.$row['timestamp'].'</em></small>
    </div>
   </p>
  </li>';
  }
  else
  {
   $output .= '<b class="text-success" style="float:left;">'.get_user_name($row['from_user_id'], $con).'</b>
                  <li style="border-bottom:1px dotted #ccc">
   <p style="float:left;"> - '.$row["chat_message"].'
    <div align="left">
     - <small><em>'.$row['timestamp'].'</em></small>
    </div>
   </p>
  </li>';
  }
 }
 $output .= '</ul>';
 // $query = "
 // UPDATE chat_message 
 // SET status = '0' 
 // WHERE from_user_id = '".$to_user_id."' 
 // AND to_user_id = '".$from_user_id."' 
 // AND status = '1'
 // ";
 // mysqli_query($con, $query);
 return $output;
}

function get_user_name($user_id, $con)
{
 $query = "SELECT fname FROM register WHERE user_id = '$user_id'";
 $result=mysqli_query($con,$query);
mysqli_fetch_all($result,MYSQLI_ASSOC);
 foreach($result as $row)
 {
  return $row['fname'];
 }
}function get_image($user_id, $con)
{
 $query = "SELECT profile_image FROM register WHERE user_id = '$user_id'";
 $result=mysqli_query($con,$query);
mysqli_fetch_all($result,MYSQLI_ASSOC);
 foreach($result as $row)
 {
  return $row['profile_image'];
 }
}

function count_unseen_message($from_user_id, $to_user_id, $con)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = '$from_user_id' 
 AND to_user_id = '$to_user_id' 
 AND status = '1'
 ";

 $result=mysqli_query($con,$query);
$count = mysqli_num_rows($result);
 $output = '';
 if($count > 0)
 {
  $output = '<span class="label label-success">'.$count.'</span>';
 }
 return $output;
}

class  Main{
function timeAgo($time_ago){

			$time_ago = strtotime($time_ago);
			$cur_time   = time();
			$time_elapsed   = $cur_time - $time_ago;
			$seconds    = $time_elapsed ;
			$minutes    = round($time_elapsed / 60 );
			$hours      = round($time_elapsed / 3600);
			$days       = round($time_elapsed / 86400 );
			$weeks      = round($time_elapsed / 604800);
			$months     = round($time_elapsed / 2600640 );
			$years      = round($time_elapsed / 31207680 );
			// Seconds
			if($seconds <= 60){
			    return "just now";
			}
			//Minutes
			else if($minutes <=60){
			    if($minutes==1){
			        return "one minute ago";
			    }
			    else{
			        return "$minutes minutes ago";
			    }
			}
			//Hours
			else if($hours <=24){
			    if($hours==1){
			        return "an hour ago";
			    }else{
			        return "$hours hrs ago";
			    }
			}
			//Days
			else if($days <= 7){
			    if($days==1){
			        return "yesterday";
			    }else{
			        return "$days days ago";
			    }
			}
			//Weeks
			else if($weeks <= 4.3){
			    if($weeks==1){
			        return "a week ago";
			    }else{
			        return "$weeks weeks ago";
			    }
			}
			//Months
			else if($months <=12){
			    if($months==1){
			        return "a month ago";
			    }else{
			        return "$months months ago";
			    }
			}
			//Years
			else{
			    if($years==1){
			        return "one year ago";
			    }else{
			        return "$years years ago";
			    }
			}
		}
	}

?>