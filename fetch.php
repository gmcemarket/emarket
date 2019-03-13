<?php
session_start();
include("db.php");
$get = new Main;
$id = $_SESSION["uid"];
//fetch.php;
if(isset($_POST["view"]))
{
 $query = "SELECT * FROM friend,register,products WHERE friend_id = user_id AND user_id1 = $id AND prd_notif != 0 ORDER BY prd_id DESC";
 $result = mysqli_query($con, $query);
 $output = '';
$output1 = 'aaa';
 if($_POST["view"] != '')
 {
  $update_query = "UPDATE friend SET notify=1,prd_notif = 1 WHERE user_id1 = $id";
  mysqli_query($con, $update_query);
 }
 if(mysqli_num_rows($result) > 0)
 {
  while($row = mysqli_fetch_array($result))
  {
  $image = $row['prd_img'];
  $product = explode(",", $image);

    if($row['producer_id'] == $row['friend_id'] && $row['friend_id'] != $id){
   $output .= '<li>
    <a class="dropdown-item" href="viewprofile.php?user_id='.$row['producer_id'].'">
    <img src="images/'.$row['profile_image'].'" style="width:70px;height:60px;float:left"></img><img src="images/'.$product[0].'" style="width:70px;height:60px;float:right"></img>
     <b>'.$row['fname'].' '.$row['lname'].'</b></a><a href="details.php?pro_id='.$row['prd_id'].'" style="color:black">Has Posted A New Product </a><br><br>
     <input type="hidden"  name="userID" value="'.$row['user_id'].'">
   <div class="dropdown-divider"></div>
   ';
     }
  }
 }
 else
 {
  $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
 }
 $query_1 = "SELECT * FROM friend WHERE user_id1 = $id AND accept=1 AND prd_notif != 0";
 $result_1 = mysqli_query($con, $query_1);
 $count;
 while ($row1 = mysqli_fetch_array($result_1)) {
        $count = $row1['prd_notif'] - 1;
    }
 $data = array(
  'notification'   => $output,
  'unseen_notification' => $count,
 );
 echo json_encode($data);
}
if(isset($_POST["employee_id"]))
{
 $output = '';
 $connect = mysqli_connect("localhost", "root", "", "ecommerce");
 $query = "SELECT * FROM register WHERE user_id = '".$_POST["employee_id"]."'";
 $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_array($result))
    {
     $output .= '
          <h4 class="modal-title">Send Message To: '.$row['fname'].'</h4>
          <input type="hidden"  name="userID" id="'.$row['user_id'].'">
     ';
    }
    echo $output;
}
if(isset($_POST["message"]))
{
  $query = "SELECT * FROM chat_message,register WHERE from_user_id = user_id AND to_user_id = $id";
 $result = mysqli_query($con, $query);
 $output = '';
 if($_POST["message"] != '')
 {
  $update_query = "UPDATE chat_message SET status=1 WHERE to_user_id=$id";
  mysqli_query($con, $update_query);
 }
 
$query_1 = "
 SELECT * FROM chat_message,register 
 WHERE from_user_id = user_id 
 AND to_user_id = $id 
 AND status = 0
 ";

 $result_1=mysqli_query($con,$query_1);
$count = mysqli_num_rows($result_1);
 
 // $query_12 = "SELECT * FROM friend WHERE friend_id = $id AND accept=0 AND notify = 0";
 // $result_12 = mysqli_query($con, $query_1);
 // $count1 = mysqli_num_rows($result_12);

 $data = array(
  'unseen_message' => $count,
 );
 echo json_encode($data);
}
if(isset($_POST["cart"]))
{
  $query = "SELECT * FROM cart WHERE user_id2 = $id AND status = 0";

 $result=mysqli_query($con,$query);
 while($row = mysqli_fetch_array($result))
  {
      $count += $row['quantity'];
  }

 $data = array(
  'cart' => $count,
 );
 echo json_encode($data);
}
if(isset($_POST['insert_product'])){
    //getting text data
   $pid = $_SESSION["uid"];
   $product_title = $_POST['product_title'];
   $product_cat = $_POST['product_cat'];
   $product_price = $_POST['product_price'];
   $product_desc = $_POST['product_desc'];
   $product_quantity = $_POST['product_quantity'];

    //getting image data
    // $product_image = $_FILES['product_image']['name'];
   // $product_image_tmp = $_FILES['product_image']['tmp_name'];
   $product_image = "";
    foreach ($_FILES["product_image"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["product_image"]["tmp_name"][$key];
            $name = $_FILES["product_image"]["name"][$key];
            move_uploaded_file($tmp_name, "images/$name");
            $product_image .= $name."," ;
        }
    }

  //  $sql=mysql_query("INSERT INTO multiimg(image) values('".$images_name."')");
  // move_uploaded_file($product_image_tmp,"images/$product_image");
   
   $insert_product = "INSERT INTO products (producer_id,prd_cat,prd_title,prd_price,prd_desc,prd_img,prd_quantity,status_time) values ('$pid','$product_cat','$product_title','$product_price','$product_desc','$product_image','$product_quantity',CURRENT_TIMESTAMP)";
   
   $run_product = mysqli_query($con,$insert_product);

   $freind_query = "SELECT * friend WHERE friend_id = $pid";
   $result_query = mysqli_query($con,$insert_product);

  while($row = mysqli_fetch_array($result_query))
  {
   $update_query = "UPDATE friend SET prd_notif = prd_notif + 1 WHERE friend_id = $pid";
   mysqli_query($con, $update_query);
  }

   if($run_product){
   
   echo json_encode($product_image);
   }

}
if(isset($_POST["message_con"]))
{
 $cat_num = $_POST['message_cat'];
if($_POST['message_con'] = ' ' && $cat_num == 1){
$output ='';
    $query = "SELECT * FROM message_connect,register,products WHERE to_user_id = $id AND from_user_id = user_id AND prd_id1 = prd_id OR from_user_id = $id AND to_user_id = user_id AND prd_id = prd_id1 ORDER BY prd_id ASC";
    $result = mysqli_query($con,$query);
     while($row = mysqli_fetch_array($result))
  {
    $query_1 = "SELECT * FROM chat_message WHERE m_id1 = ".$row['m_id']." AND status = 0 AND to_user_id = ".$id."";
 $result_1 = mysqli_query($con, $query_1);
 $count = mysqli_num_rows($result_1);
 $name = $row['fname'] .' '. $row['lname'];
 if($count == 0){
   $output .= '
    <a href="#" id='.$row['m_id'].' name = "'.$cat_num.'" class="view_messages" to_id="'.$row['user_id'].'" FName="'.$name.'">
              <img src="images/'.$row["profile_image"].'" alt="Avatar" class="w3-left w3-square w3-margin-right" style="width:70px;height:60px;float:left"></img> 
                                 <div style="color:black;white-space: pre;">'.$row['fname'].'</div>
                                 <div style="white-space: pre;">'.$row['prd_title'].'</div>
                              </a><hr>';
                //              </a><hr><a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //   <i class="fa fa-bell fa-fw"></i>
        //   <span class="badge badge-danger count2">'.$count.'</span>
        // </a>
 }else{
    $output .= '
    <a href="#" id='.$row['m_id'].' name = "'.$cat_num.'" class="view_messages" to_id="'.$row['user_id'].'">
                <img src="images/'.$row["profile_image"].'" alt="Avatar" class="w3-left w3-square w3-margin-right" style="width:70px;height:60px;float:left"></img> <span class="badge badge-danger" style="left:54px;margin-top:-10px;position:absolute">'.$count.'</span>
                <div style="color:black;white-space: pre;">'.$row['fname'].'</div>
                                 <div style="white-space: pre;">'.$row['prd_title'].'</div>
                              </a><hr>
                            ';
   }
  }
}
  echo $output;
}
if(isset($_POST['to_user_id'])){
  $to_user_id = $_POST['to_user_id'];
  $to_id = $_POST['to_id'];
  $u_id = $_SESSION['uid'];
  $output = '<ul class="list-unstyled">';
  $product ='';
    $query = "SELECT * FROM chat_message WHERE m_id1 = $to_user_id";
    $result = mysqli_query($con,$query);

    $query1 = "UPDATE chat_message SET status = 1 WHERE m_id1 = $to_user_id";
    $result1 = mysqli_query($con,$query1);
     while($row = mysqli_fetch_array($result))
  { 
      if($row['from_user_id'] == $u_id){
          $output .= '<b class="text-success" style="float:right;">You</b>
                  <li style="border-bottom:1px dotted #ccc">
   <p style="float:right;">'.$row["chat_message"].' - 
    <div>
    <br><br>
     - <small style="float:right;"><em>'.$row['timestamp'].'</em></small>
    </div>
   </p>
  </li>';
        }else{
           $output .= '<b class="text-success" style="float:left;">'.get_user_name($row['from_user_id'], $con).'</b>
                  <li style="border-bottom:1px dotted #ccc">
   <p style="float:left;"> - '.$row["chat_message"].'
    <div>
    <br><br>
     - <small style="float:left;"><em>'.$row['timestamp'].'</em></small>
    </div>
   </p>
  </li>';
        }
      }
      $query1 = "SELECT * FROM message_connect,products,register WHERE m_id = $to_user_id AND prd_id = prd_id1 AND producer_id = user_id";
      $result1 = mysqli_query($con,$query1);
      while($row1 = mysqli_fetch_array($result1))
  { 
    $output .= '<input type="hidden" id="to_user_id" value="'.$to_id.'" />
    <input type="hidden" id="pro_id" value="'.$row1['prd_id'].'" />
    <input type="hidden" id="m_id" value="'.$row1['m_id'].'" />';

    $product .= '
              <br><br><img src="images/'.$row1["profile_image"].'" alt="Avatar" style="display:block;margin-left: auto;margin-right: auto;width: 70px;height: 60px"></img> <br>
                                 <div style="text-align: center;">'.$row1['fname'].'<br>
                                 <a href="viewprofile.php?user_id='.$row1['user_id'].'">View Profile</a></div><p><br></p><hr><p><br></p>
                                 <img src="images/'.$row1['prd_img'].'" alt="Avatar"style="display:block;margin-left: auto;margin-right: auto;width: 100px;height: 100px"></img> 
                                 <h4 style="text-align: center;">'.$row1['prd_title'].'<br>
                                 <b>P'.$row1['prd_price'].'</b></h4>
                                 ';
    //  $product .= '<br><div class="post-left-box"><div style="margin-left: 40%">
    // <a href="#" id='.$row1['m_id'].' class="view_messages">
    //            <div class="id-img-box"><img src="images/'.$row1['profile_image'].'"></img></div> 
    //                          </a><br><br><br>
    //                          <div class="id-name">
    //                          <ul>
    //                             <li style="color: black">'.$row1['fname'].'</li>
    //                             <li style="color: white"><a href="viewprofile.php?user_id='.$row1['user_id'].'">View Profile </a></li>
    //                           </ul>
    //                           </div>
    //                        </div></div><hr>
    //                        <div class="post-left-box">
    // <a href="#" id='.$row['m_id'].' class="view_messages">
    //            <div class="id-img-box"><img src="images/'.$row1['prd_img'].'"></img></div>  <div class="id-name">
    //                              <ul>
    //                             <li style="color: white">'.$row1['prd_title'].'</li>
    //                             <li style="color: black">P'.$row1['prd_price'].'</li>
    //                             </ul>
    //                          </div>
    //                          </a>
    //                        </div>
    //                        <hr>
    //                        <h4 style="color: white">Actions</h4>
    //                        <input type="hidden" id="delete_id" value="'.$row1['m_id'].'" />;
    //                        <small><a href = "#" class = "delete_message">Delete This Conversation</a>
    //                        ';
  }
  $output .= "</ul>";
  $data = array(
  'chat'   => $output,
  'product' => $product,
 );

 echo json_encode($data);

}
if(isset($_POST['user_product'])){
  $search = $_POST['user_product'];
  $num = $_POST['profile'];
   $output = '';
   if($num == 1){
  if($search != ''){
    $get_pro = "select * from products,categories WHERE prd_title LIKE '%".$search."%' AND producer_id ='$id' AND prd_cat = cat_id ";
  $result = mysqli_query($con,$get_pro);
  }else{
    $get_pro = "select * from products,categories WHERE producer_id ='$id' AND prd_cat = cat_id";
  $result = mysqli_query($con,$get_pro);
  }
if(mysqli_num_rows($result) > 0)
{ 
  $output .= '
  <table class="table table-bordered" id="productTables">
    <thead>
      <tr>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Description</th>
        <th>Category</th>
        <th></th>
      </tr>
    </thead>
    <tbody>';
    while($row_pro = mysqli_fetch_array($result)){


        $product_id = $row_pro['prd_id'];
        $product_category = $row_pro['cat_title'];
        $product_title = $row_pro['prd_title']; 
        $product_price = $row_pro['prd_price'];
        $product_image = $row_pro['prd_img'];
        $product_quantity = $row_pro['prd_quantity'];
        $product_desc = $row_pro['prd_desc'];
        
          /*echo "<img src = 'Producer/product_images/$row_pro[prd_img]' height=110 width=90>";*/

          if($product_quantity <= 5){

         $output .= '
                  </tr>
                    <td>'.$product_title.'</td>
                    <td style="color:red">'.$product_quantity.'</td>
                    <td>'.$product_price.'</td>
                    <td>'.$product_desc.'</td>
                    <td>'.$product_category.'</td>
                    <td><input type="button" value="...." id="edit" p_id="'.$product_id.'" style="margin-top: -30px;"class="btn success"></td>
                  </tr>';
            }else{
               $output .= '
                  </tr>
                    <td>'.$product_title.'</td>
                    <td>'.$product_quantity.'</td>
                    <td>'.$product_price.'</td>
                    <td>'.$product_desc.'</td>
                    <td>'.$product_category.'</td>
                    <td><input type="button" value="...." id="edit" p_id="'.$product_id.'" style="margin-top: -30px;"class="btn success"></td>
                  </tr>';
            }
    
  }
  $output .= '</tbody></table>';
}else{
  $output = "Product Not Found";
 }
 $output .= '</tbody>
            </table><button type="button" class="btn btn-primary" id="deliver">
    Deliver
  </button>';
}
if($num == 2){
  if($search != ''){
    $get_pro = "select * from products,categories WHERE prd_title LIKE '%".$search."%' AND producer_id ='$id' AND prd_quantity != 0 AND prd_cat = cat_id";
  $result = mysqli_query($con,$get_pro);
  }else{
    $get_pro = "select * from products,categories WHERE producer_id ='$id' AND prd_quantity != 0 AND prd_cat = cat_id";
  $result = mysqli_query($con,$get_pro);
  }
if(mysqli_num_rows($result) > 0)
{ 
   $output .= '
  <table class="table table-bordered" id="productTables">
    <thead>
      <tr>
        <th>ItemName</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Description</th>
        <th>Category</th>
      </tr>
    </thead>
    <tbody>';
    while($row_pro = mysqli_fetch_array($result)){

           $product_id = $row_pro['prd_id'];
        $product_category = $row_pro['cat_title'];
        $product_title = $row_pro['prd_title']; 
        $product_price = $row_pro['prd_price'];
        $product_image = $row_pro['prd_img'];
        $product_quantity = $row_pro['prd_quantity'];
        $product_desc = $row_pro['prd_desc'];
        
          /*echo "<img src = 'Producer/product_images/$row_pro[prd_img]' height=110 width=90>";*/


         $output .= '
                  </tr>
                    <td>'.$product_title.'</td>
                    <td>'.$product_quantity.'</td>
                    <td>'.$product_price.'</td>
                    <td>'.$product_desc.'</td>
                    <td>'.$product_category.'</td>
                  </tr>';

    
  }
  $output .= '</tbody></table><button type="button" class="btn btn-primary" id="deliver">
    Deliver
  </button>';
}else{
  $output = "Product Not Found";
 }
}
if($num == 3){
   $output .= '
  <table class="table table-bordered" id="productTables">
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Description</th>
        <th>Category</th>
      </tr>
    </thead>
    <tbody>';
  if($search != ''){
    $get_pro = "select * from products,categories WHERE prd_title LIKE '%".$search."%' AND producer_id ='$id' AND prd_quantity <= 5 AND prd_cat = cat_id";
  $result = mysqli_query($con,$get_pro);
  }else{
    $get_pro = "select * from products,categories WHERE producer_id ='$id' AND prd_quantity <= 5 AND prd_cat = cat_id";
  $result = mysqli_query($con,$get_pro);
  }
if(mysqli_num_rows($result) > 0)
{ 
    while($row_pro = mysqli_fetch_array($result)){

           $product_id = $row_pro['prd_id'];
        $product_category = $row_pro['cat_title'];
        $product_title = $row_pro['prd_title']; 
        $product_price = $row_pro['prd_price'];
        $product_image = $row_pro['prd_img'];
        $product_quantity = $row_pro['prd_quantity'];
        $product_desc = $row_pro['prd_desc'];
        
          /*echo "<img src = 'Producer/product_images/$row_pro[prd_img]' height=110 width=90>";*/


        
         $output .= '
                  </tr>
                    <td>'.$product_title.'</td>
                    <td style="color:red">'.$product_quantity.'</td>
                    <td>'.$product_price.'</td>
                    <td>'.$product_desc.'</td>
                    <td>'.$product_category.'</td>
                  </tr>';

    
  }
  $output .= '</tbody></table><button type="button" class="btn btn-primary" id="deliver">
    Deliver
  </button>';
}else{
  $output = "Product Not Found";
 }
}else if($num == 4){
     $output .= '
  <table class="table table-bordered" id="productTables">
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Description</th>
        <th>Category</th>
      </tr>
    </thead>
    <tbody>';
  if($search != ''){
    $get_pro = "select * from products,categories WHERE prd_title LIKE '%".$search."%' AND producer_id ='$id' AND prd_quantity = 0 AND prd_cat = cat_id";
  $result = mysqli_query($con,$get_pro);
  }else{
    $get_pro = "select * from products,categories WHERE producer_id ='$id' AND prd_quantity = 0 AND prd_cat = cat_id";
  $result = mysqli_query($con,$get_pro);
  }
if(mysqli_num_rows($result) > 0)
{ 
    while($row_pro = mysqli_fetch_array($result)){

           $product_id = $row_pro['prd_id'];
        $product_category = $row_pro['cat_title'];
        $product_title = $row_pro['prd_title']; 
        $product_price = $row_pro['prd_price'];
        $product_image = $row_pro['prd_img'];
        $product_quantity = $row_pro['prd_quantity'];
        $product_desc = $row_pro['prd_desc'];
        
          /*echo "<img src = 'Producer/product_images/$row_pro[prd_img]' height=110 width=90>";*/


        
         $output .= '
                  </tr>
                    <td>'.$product_title.'</td>
                    <td style="color:red">'.$product_quantity.'</td>
                    <td>'.$product_price.'</td>
                    <td>'.$product_desc.'</td>
                    <td>'.$product_category.'</td>
                  </tr>';

    
  }
  $output .= '</tbody></table><button type="button" class="btn btn-primary" id="deliver">
    Deliver
  </button>';
}else{
  $output = "<h1><b>Product Not Found</b></h1>";
 }
}else if($num == 5){
     $output .= '
  <table class="table table-bordered" id="productTables">
    <thead>
      <tr>
        <th>Delivery Code</th>
        <th>Total Delivery</th>
        <th></th>
      </tr>
    </thead>
    <tbody>';
    $get_pro = "SELECT * FROM deliver WHERE user_id3 = $id";
  $result = mysqli_query($con,$get_pro);
$result1 = mysqli_query($con, $get_pro);
    $array = mysqli_fetch_array($result1);
    $getCode = $array[1];
    $count = mysqli_num_rows($result);
    $i = 1;
    $num = 0;
if(mysqli_num_rows($result) > 0)
{ 
    while($row = mysqli_fetch_array($result)){
        if($getCode == $row['deliver_code']){
          $delivery_code = $row['deliver_code'];
          $num += 1;
          if($i == $count){
              $output .= '
                  </tr>
                    <td>'.$delivery_code.'</td>
                    <td>'.$num.'</td>
                    <td> <input type="button" value="...." id="deliverDetails" name="'.$delivery_code.'" style="margin-top: -30px;"class="btn success"></td>
                  </tr>';
          }
        }else{
         $output .= '
                  </tr>
                    <td>'.$delivery_code.'</td>
                    <td>'.$num.'</td>
                    <td> <input type="button" value="...." id="deliverDetails" name="'.$delivery_code.'" style="margin-top: -30px;"class="btn success"></td>
                  </tr>';
         $delivery_code = $row['deliver_code'];         
         $num = 1;
         $getCode = $row['deliver_code'];
         if($i == $count){
          $output .= '
                  </tr>
                    <td>'.$row["deliver_code"].'</td>
                    <td>'.$num.'</td>
                    <td> <input type="button" value="...." id="deliverDetails" name="'.$delivery_code.'" style="margin-top: -30px;"class="btn success"></td>
                  </tr>';
         }
        }
      $i++;
    
  }
  $output .= '</tbody></table>';
}else{
  $output = "<h1><b>Product Not Found</b></h1>";
 }
}else if($num == 6){
     $output .= '
  <table class="table table-bordered" id="productTables">
    <thead>
      <tr>
        <th>Date</th>
        <th>Log</th>
      </tr>
    </thead>
    <tbody>';
    $get_pro = "SELECT * FROM logs WHERE user_id4 = $id";
  $result = mysqli_query($con,$get_pro);
if(mysqli_num_rows($result) > 0)
{ 
    while($row = mysqli_fetch_array($result)){
        $output .= '
                  </tr>
                    <td>'.$row["log_date"].'</td>
                    <td>'.$row["log_text"].'</td>
                  </tr>';
  }
  $output .= '</tbody></table>';
}else{
  $output = "Product Not Found";
 }
}
echo $output;
 }if(isset($_POST['deliverDetails'])){

 }
 if(isset($_POST['delete_id'])){
    $delete_id = $_POST['delete_id'];
    echo"<script>alert('This Conversation is Deleted')</script>";
     $query = "DELETE from chat_message WHERE m_id1 ='$delete_id' ";
  $query1 = "DELETE from message_connect WHERE m_id ='$delete_id' ";
   $result = mysqli_query($con,$query);
  $result1 = mysqli_query($con,$query1);

  if($result && $result1){
    echo"<script>alert('This Conversation is Deleted')</script>";
    echo"<script>window.open('message.php','_self')</script>";
  }
 }if(isset($_POST['category_list'])){
  $get_cats = "select * from register,categories where user_id ='$id'";
  $run_cats = mysqli_query($con,$get_cats);

  while($row_cats=mysqli_fetch_array($run_cats)){
  $name = $row_cats['sellerOf'];
    $product = explode(",", $name);
    $length = count($product.length);
    for($i = 0; $i <= $length; $i++){
      if($product[$i] == $row_cats['cat_title']){
     $output .= '<div class="form-group"><div class="row">
              <input type="text" class="form-control choose" id="prd_cat" name="'.$row_cats["cat_title"].'" c_id= "'.$row_cats['cat_id'].'" value="'.$row_cats["cat_title"].'">
            </div><br>';
     }  
   }
  }
  echo $output;
 }
 if(isset($_POST['product_details'])){
      $prd_id = $_POST['product_details'];
      // $prd_name = mysqli_real_escape_string($connect, $_POST["prd_name"]);  
      // $prd_cat = mysqli_real_escape_string($connect, $_POST["prd_cat"]);  
      // $prd_desc = mysqli_real_escape_string($connect, $_POST["prd_desc"]);  
      // $prd_price = mysqli_real_escape_string($connect, $_POST["prd_price"]);  
      // $prd_quantity = mysqli_real_escape_string($connect, $_POST["prd_quantity"]); 

      $query = "SELECT * FROM products,categories WHERE prd_id = '$prd_id' AND prd_cat = cat_id";  
      $result = mysqli_query($con, $query);  
      $get_cats = "select * from register,categories where user_id ='$id'";
  $run_cats = mysqli_query($con,$get_cats);

       while($row = mysqli_fetch_array($result))
      {
           $output .= '<div class="form-group">
            <label class="col-sm-10 control-label" for="textinput">Product Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="prd_title" value="'.$row["prd_title"].'">
              <input type="hidden" class="form-control" id="prd_id" value="'.$row["prd_id"].'">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-10 control-label" for="textinput">Product Category</label>
            <div class="col-sm-10">
              <input type="text" class="form-control pointer" id="prd_cat" value="'.$row["cat_title"].'" readonly>
              <input type="hidden" class="form-control" id="cat_id" value="'.$row["prd_cat"].'"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-10 control-label" for="textinput">Product Description</label>
            <div class="col-sm-10">
              <textarea type="text" class="form-control" id="prd_desc">'.$row["prd_desc"].'</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-10 control-label" for="textinput">Product Price</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="prd_price" value="'.$row["prd_price"].'">
            </div>
          </div><button type="submit" class="btn btn-primary" name="'.$row['prd_id'].'" id="update_product">Update</button>';
      }
      echo $output;
 }function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
 if(isset($_POST['update_product'])){
  $prd_id = $_POST['update_product'];
  $prd_title = $_POST['prd_title'];
  $prd_desc = $_POST['prd_desc'];
  $prd_price = $_POST['prd_price'];
  $prd_cat = $_POST['prd_cat'];
  $password=md5(check_input($_POST['password']));
  date_default_timezone_set('Asia/Manila');
  $date_today = date("Y-m-d");
  if($password == $_SESSION['password']){
  $update_product = "UPDATE products SET prd_title = '$prd_title', prd_desc = '$prd_desc', prd_price = '$prd_price', prd_cat = '$prd_cat' WHERE prd_id = $prd_id";
  $result = mysqli_query($con,$update_product);
  }
 }if(isset($_POST['insert_log'])){
  $data = json_decode(stripslashes($_POST['data']));
  $password=md5(check_input($_POST['password']));
  date_default_timezone_set('Asia/Manila');
  $date_today = date("Y-m-d");
  $log_text = "You have change the following: ";
  foreach($data as $d){
     $log_text .= $d ."; ";
  }
  if($password == $_SESSION['password']){
  $insert_logs = "INSERT INTO logs (user_id4,log_text,log_date) VALUES ('$id','$log_text','$date_today')";
  $result1 = mysqli_query($con,$insert_logs);
   }
 }
 if(isset($_POST['cart_product'])){
      $query = "SELECT * FROM cart,products,categories,register WHERE user_id2 = $id AND prd_id = prd_id2 AND prd_cat = cat_id AND user_id = $id AND status = 0";  
      $result = mysqli_query($con, $query);
      $query1 = "SELECT * FROM cart WHERE user_id2 = $id AND status = 0";
      $result1 = mysqli_query($con,$query1);
      while($row1 = mysqli_fetch_array($result1))
      {
      $count += $row1['quantity'];
       }
       if(mysqli_num_rows($result) > 0)
 { 
      $total;
      $output = '
      <div class="container">
  <h2><b>SHOPPING CART</b></h2>       
  <table>
    <thead>
      <tr style="height:70px">
        <td>You have '.$count.' items in your cart</td>
        <td></td>
        <td></td>
        <td><a href="#" id="deleteAll" class="btn btn-primary outline btn-lg" style="margin-top:-1px">Clear Shopping Cart</a></td>
        <td></td>
      </tr>
    </thead>
      <tr>
        <th style="width:200px;height:40px"></th>
        <th>Products</th>
        <th>Quantity</th>
        <th>Price</th>
        <th></th>
      </tr>
    <tbody>
     ';

      while($row = mysqli_fetch_array($result)){
        $image = $row['prd_img'];
        $product = explode(",", $image);

          $total += $row['price'] * $row['quantity'];
         $price = $row['price'] * $row['quantity'];
          if($row['quantity'] == 1){
            if($row['prd_quantity'] <= 5  ){
               $output .= "<tr>
        <td style='height:124px;'><img src='images/".$product[0]."' class='cart-img'> <input type='hidden' name='prd_id'value='".$row['prd_id']."'/></td>
        <td>".$row['prd_title']."</td>
        <td style='width:400px;'> <div class='grid_1 simpleCart_shelfItem qty'>
                  <div class='input-group'>
                            <div class='input-group-prepend'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='minus' c_id='".$row['cart_id']."' disabled><i class='fa fa-minus'></i></button>
                            </div>
                            <input  type='text' class='form-control-sm text-center' value='".$row['quantity']." in cart' readonly>
                            <div class='input-group-append'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='plus' c_id='".$row['cart_id']."'><i class='fa fa-plus'></i></button>
                            </div>
                          </div>
                          <small style='color:red'> only ".$row['prd_quantity']." item in stock </small>  
          </div></td>
        <td><b>P".$price."<input type='hidden' name='prod_id'value='".$row['producer_id']."'/></b></td>
        <td><button type='button' class='btn btn-outline-danger btn-lg' id='deleteProduct' p_id='".$row['prd_id']."'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button></td>
         </tr>  ";
            }
            else if($row['prd_quantity'] <= 10){
             $output .= "<tr>
        <td style='height:124px;'><img src='images/".$product[0]."' class='cart-img'> <input type='hidden' name='prd_id'value='".$row['prd_id']."'/></td>
        <td>".$row['prd_title']."</td>
        <td style='width:400px;'>
        <div class='grid_1 simpleCart_shelfItem qty'>
                  <div class='input-group'>
                            <div class='input-group-prepend'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='minus' c_id='".$row['cart_id']."' disabled><i class='fa fa-minus'></i></button>
                            </div>
                            <input  type='text' class='form-control-sm text-center' value='".$row['quantity']." in cart' readonly>
                            <div class='input-group-append'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='plus' c_id='".$row['cart_id']."'><i class='fa fa-plus'></i></button>
                            </div>
                          </div>
                          <small style='color:GoldenRod'> only ".$row['prd_quantity']." item in stock </small>  
          </div>
         </td>
        <td><b>P".$price."<input type='hidden' name='prod_id'value='".$row['producer_id']."'/></b></td>
        <td> <button type='button' class='btn btn-outline-danger btn-lg' id='deleteProduct' p_id='".$row['prd_id']."'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button></td>
         </tr>  ";
       }else{
          $output .= "<tr>
        <td style='height:124px;'><img src='images/".$product[0]."' class='cart-img'> <input type='hidden' name='prd_id'value='".$row['prd_id']."'/></td>
        <td>".$row['prd_title']."</td>
        <td style='width:400px;'>
        <div class='grid_1 simpleCart_shelfItem qty'>
                  <div class='input-group'>
                            <div class='input-group-prepend'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='minus' c_id='".$row['cart_id']."' disabled><i class='fa fa-minus'></i></button>
                            </div>
                            <input  type='text' class='form-control-sm text-center' value='".$row['quantity']." in cart' readonly>
                            <div class='input-group-append'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='plus' c_id='".$row['cart_id']."'><i class='fa fa-plus'></i></button>
                            </div>
                          </div>  
          </div></td>
        <td><b>P".$price."<input type='hidden' name='prod_id'value='".$row['producer_id']."'/></b></td>
        <td> <button type='button' class='btn btn-outline-danger btn-lg' id='deleteProduct' p_id='".$row['prd_id']."'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button></td>
         </tr>  ";
            }
          }else if($row['prd_quantity'] == $row['quantity']){
            if($row['prd_quantity'] <= 5){
                $output .= "<tr>
        <td style='height:124px;'><img src='images/".$product[0]."' class='cart-img'> <input type='hidden' name='prd_id'value='".$row['prd_id']."'/></td>
        <td>".$row['prd_title']."</td>
        <td style='width:400px;'>
        <div class='grid_1 simpleCart_shelfItem qty'>
                  <div class='input-group'>
                            <div class='input-group-prepend'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='minus' c_id='".$row['cart_id']."'><i class='fa fa-minus'></i></button>
                            </div>
                            <input  type='text' class='form-control-sm text-center' value='".$row['quantity']." in cart' readonly>
                            <div class='input-group-append'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='plus' c_id='".$row['cart_id']."' disabled><i class='fa fa-plus'></i></button>
                            </div>
                          </div>
                          <small style='color:red'> only ".$row['prd_quantity']." item in stock </small>  
          </div></td>
        <td><b>P".$price."<input type='hidden' name='prod_id'value='".$row['producer_id']."'/></b></td>
        <td> <button type='button' class='btn btn-outline-danger btn-lg' id='deleteProduct' p_id='".$row['prd_id']."'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button></td>
         </tr>  ";
            }else if($row['prd_quantity'] <= 10){
              $output .= "<tr>
        <td style='height:124px;'><img src='images/".$product[0]."' class='cart-img'> <input type='hidden' name='prd_id'value='".$row['prd_id']."'/></td>
        <td>".$row['prd_title']."</td>
        <td style='width:400px;'>
        <div class='grid_1 simpleCart_shelfItem qty'>
                  <div class='input-group'>
                            <div class='input-group-prepend'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='minus' c_id='".$row['cart_id']."'><i class='fa fa-minus'></i></button>
                            </div>
                            <input  type='text' class='form-control-sm text-center' value='".$row['quantity']." in cart' readonly>
                            <div class='input-group-append'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='plus' c_id='".$row['cart_id']."' disabled><i class='fa fa-plus'></i></button>
                            </div>
                          </div>
                          <small style='color:GoldenRod'> only ".$row['prd_quantity']." item in stock </small>  
          </div></td>
        <td><b>P".$price."<input type='hidden' name='prod_id'value='".$row['producer_id']."'/></b></td>
        <td> <button type='button' class='btn btn-outline-danger btn-lg' id='deleteProduct' p_id='".$row['prd_id']."'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button></td>
         </tr>  ";
            }else{
              $output .= "<tr>
        <td style='height:124px;'><img src='images/".$product[0]."' class='cart-img'> <input type='hidden' name='prd_id'value='".$row['prd_id']."'/></td>
        <td>".$row['prd_title']."</td>
        <td style='width:400px;'>
        <div class='grid_1 simpleCart_shelfItem qty'>
                  <div class='input-group'>
                            <div class='input-group-prepend'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='minus' c_id='".$row['cart_id']."'><i class='fa fa-minus'></i></button>
                            </div>
                            <input  type='text' class='form-control-sm text-center' value='".$row['quantity']." in cart' readonly>
                            <div class='input-group-append'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='plus' c_id='".$row['cart_id']."' disabled><i class='fa fa-plus'></i></button>
                            </div>
                          </div>
          </div></td>
        <td><b>P".$price."<input type='hidden' name='prod_id'value='".$row['producer_id']."'/></b></td>
        <td> <button type='button' class='btn btn-outline-danger btn-lg' id='deleteProduct' p_id='".$row['prd_id']."'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button></td>
         </tr>  ";
            }
               
          }else{
             if($row['prd_quantity'] <= 5  ){
               $output .= "<tr>
        <td style='height:124px;'><img src='images/".$product[0]."' class='cart-img'> <input type='hidden' name='prd_id'value='".$row['prd_id']."'/></td>
        <td>".$row['prd_title']."</td>
        <td style='width:400px;'>
        <div class='grid_1 simpleCart_shelfItem qty'>
                  <div class='input-group'>
                            <div class='input-group-prepend'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='minus' c_id='".$row['cart_id']."'><i class='fa fa-minus'></i></button>
                            </div>
                            <input  type='text' class='form-control-sm text-center' value='".$row['quantity']." in cart' readonly>
                            <div class='input-group-append'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='plus' c_id='".$row['cart_id']."'><i class='fa fa-plus'></i></button>
                            </div>
                          </div>
                          <small style='color:red'> only ".$row['prd_quantity']." item in stock </small>  
          </div></td>
          <td><b>P".$price."<input type='hidden' name='prod_id'value='".$row['producer_id']."'/></b></td>
        <td> <button type='button' class='btn btn-outline-danger btn-lg' id='deleteProduct' p_id='".$row['prd_id']."'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button></td>
         </tr>  ";
            }
            else if($row['prd_quantity'] <= 10){
             $output .= "<tr>
        <td style='height:124px;'><img src='images/".$product[0]."' class='cart-img'> <input type='hidden' name='prd_id'value='".$row['prd_id']."'/></td>
        <td>".$row['prd_title']."</td>
        <td style='width:400px;'>
        <div class='grid_1 simpleCart_shelfItem qty'>
                  <div class='input-group'>
                            <div class='input-group-prepend'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='minus' c_id='".$row['cart_id']."'><i class='fa fa-minus'></i></button>
                            </div>
                            <input  type='text' class='form-control-sm text-center' value='".$row['quantity']." in cart' readonly>
                            <div class='input-group-append'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='plus' c_id='".$row['cart_id']."'><i class='fa fa-plus'></i></button>
                            </div>
                          </div>
                          <small style='color:GoldenRod'> only ".$row['prd_quantity']." item in stock </small>  
          </div></td>
        <td><b>P".$price."<input type='hidden' name='prod_id'value='".$row['producer_id']."'/></b></td>
        <td> <button type='button' class='btn btn-outline-danger btn-lg' id='deleteProduct' p_id='".$row['prd_id']."'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button></td>
         </tr>  ";
       }else{
          $output .= "<tr>
        <td style='height:124px;'><img src='images/".$product[0]."' class='cart-img'> <input type='hidden' name='prd_id'value='".$row['prd_id']."'/></td>
        <td>".$row['prd_title']."</td>
        <td style='width:400px;'>
        <div class='grid_1 simpleCart_shelfItem qty'>
                  <div class='input-group'>
                            <div class='input-group-prepend'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='minus' c_id='".$row['cart_id']."' disabled><i class='fa fa-minus'></i></button>
                            </div>
                            <input  type='text' class='form-control-sm text-center' value='".$row['quantity']." in cart' readonly>
                            <div class='input-group-append'>
                              <button type='submit' class='btn btn-sm btn-qty button1' id='".$row['quantity']."' name='plus' c_id='".$row['cart_id']."'><i class='fa fa-plus'></i></button>
                            </div>
                          </div>  
          </div></td>
        <td><b>P".$price."<input type='hidden' name='prod_id'value='".$row['producer_id']."'/></b></td>
        <td> <button type='button' class='btn btn-outline-danger btn-lg' id='deleteProduct' p_id='".$row['prd_id']."'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </button></td>
         </tr>  ";
            }
          }
        }
        $output .= " <tr>
                      <td style='width:200px;height:40px'></td>
                      <td></td>
                      <td></td>
                      <td><b>P".$total."</b></td>
                      <td></td>
                    </tr>
                     <tr style='height:100px;'>
                      <td><button type='button' class='btn btn-primary checkout'style='height:40px;margin-top:10px'>Check Out</button></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    </tbody>
                  </table>";
  }else{
    $output = "<h1 style='margin-left:400px'>You Have No Item's In Your Cart";
  }
        echo $output;
      
 } if(isset($_POST['delete_cart'])){
  $type = $_POST['type'];
  if($type == "All"){
    $query = "DELETE FROM cart WHERE user_id2 = $id AND status = 0";
    $run = mysqli_query($con,$query);
    echo"<script>window.open('cart.php?','_self')</script>";
  }else{
    $p_id = $_POST['p_id'];
    $query = "DELETE FROM cart WHERE user_id2 = $id AND prd_id2 = $p_id AND status = 0";
    $run = mysqli_query($con,$query);
    echo"<script>window.open('cart.php?','_self')</script>";
  }
 }
 if(isset($_POST['addToCart'])){
  $u_id = $_SESSION['uid'];
  $product_id =  $_POST["pro_id"];
  $product_price = $_POST['pro_price'];
  $quantity = $_POST['quantity'];
    echo"<script>alert('".$product_id."')</script>";
  $insert_cart = "INSERT INTO cart (user_id2,prd_id2,price,quantity) VALUES ('$u_id','$product_id','$product_price','$quantity')";
  $run_cart = mysqli_query($con,$insert_cart);

  if($run_cart){
    echo"<script>alert('Product Has been added to Your Cart')</script>";
   echo"<script>window.open('details.php?pro_id=$product_id','_self')</script>";
  }
}
 if(isset($_POST['update_cart'])){
      $quantity = $_POST['quantity'];
      $c_id = $_POST['c_id'];
     $update_query = "UPDATE cart,products SET quantity = $quantity WHERE cart_id = $c_id AND prd_id = prd_id2 AND prd_quantity != 1";
     $result = mysqli_query($con, $update_query);
      echo"<script>alert('Product Has been added to Your Cart')</script>";
 }
 if(isset($_POST['checkout'])){
  $query = "SELECT * FROM cart,products WHERE user_id2 = $id AND prd_id = prd_id2 AND status = 0";  
      $result = mysqli_query($con, $query);
      $query1 = "SELECT * FROM register,cart WHERE user_id = $id AND user_id2 = $id AND status = 0";
      $result1 = mysqli_query($con,$query1);
      while($row1 = mysqli_fetch_array($result1))
      {
      $name = $row1['fname'] . ' ' . $row1['lname'];
      $count += $row1['quantity'];
       }
       $arr = array();
  $output = '
  <div class="container" style="float:left">
        <div class="row">
          <div class="col-50">
            <h3>Billing Address</h3>
            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
            <input type="text" id="fname" name="firstname" value="'.$name.'" readonly>
            <label for="pickUpDate"><i class="fa fa-envelope"></i> Pick Up Date</label>
            <input type="date" id="date" name="date">
            <label for="pickUpTime"><i class="fa fa-envelope"></i> Pick Up Time</label>
            <input type="time" id="time" name="time">
            <label for="phonenumber"><i class="fa fa-address-card-o"></i> Phone Number</label>
            <input type="text" id="phoneNumber" name="phoneNumber" placeholder="">
            <br>
            <input type="submit" value="Place Order" id="placeOrder" name="placeOrder" class="btn"><br>
              </div>
              </div>
             </div>
              <div class="container" style="float:right;width:40%">
                        <h2>Order Summary </h2>  
                        You have '.$count.' items in your shopping cart <hr>';
        $i = 0;
        while($row = mysqli_fetch_array($result)){
          if($row['prd_id2'] == $row['prd_id']){
            array_push($arr, [$row['producer_id'],$row['prd_id']]);
            $price = $row['quantity'] * $row['price'];
            $total += $row['quantity'] * $row['price'];
            $output .= '<div class="row">
                          <div class="col-sm-10">'.$row["quantity"].' x '.$row["prd_title"].'
                          </div>
                          <div class="col-sm-2">P'.$price.'</div>
                        </div><hr>';
            }
            $i++;
      }
        $output .= "<div class='row'>
                      <div class='col-sm-10'><b>Total</b></div>
                      <div class='col-sm-2'><b>P".$total."</b><div>
                    </div>
                  </div><br><br>";

  echo $output;
 }
 if(isset($_POST['placeOrder'])){
  $date = $_POST['date'];
  $time = $_POST['time'];
  $number = $_POST['number'];
  $code = $_POST['code'];

  $query = "SELECT * FROM cart,products WHERE user_id2 = $id AND prd_id2 = prd_id";  
      $result = mysqli_query($con, $query);
      while($row = mysqli_fetch_array($result)){
        $producer_id = $row['producer_id'];
        $product_id = $row['prd_id'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $cart_id = $row['cart_id'];

         $insert_orders = "INSERT INTO orders (order_code,o_producer_id,product_id,orderby_id,o_quantity,o_price,order_date,order_time,status) 
         VALUES ('$code','$producer_id','$product_id','$id','$quantity','$price','$date','$time','pending')";
         mysqli_query($con,$insert_orders);
         $update_cart = "UPDATE cart SET status=1 WHERE cart_id = $cart_id";
        mysqli_query($con, $update_cart);
        $update_product = "UPDATE products SET prd_quantity = prd_quantity - $quantity WHERE prd_id = $product_id";
        mysqli_query($con, $update_product);
      }
 }
 if(isset($_POST['order'])){
  date_default_timezone_set('Asia/Manila');
  $date_today = date("Y-m-d");
  $time_today = date("H-i-s");
  $type = $_POST['type'];
   $dateFrom = $_POST['dateFrom'];
  $dateTo = $_POST['dateTo'];
  if($type == 1){
   if($dateFrom == '' && $dateTo == ''){
      $query = "SELECT * FROM orders,products,register WHERE o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id"; 
    }else{
       $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id";
    }
     $result = mysqli_query($con, $query);
      $output = '<table class="table table-bordered" id="orderTables">
    <thead>
      <tr>
      <th></th>
        <th>Name</th>
        <th>Product</th>
        <th>quantity</th>
        <th>Price</th>
        <th>Order Date</th>
        <th>OrderTime</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
   ';
     if(mysqli_num_rows($result) > 0)
{ 
  while($row = mysqli_fetch_array($result)){
    $image = $row['prd_img'];
        $product = explode(",", $image);
    $date = date_create($row["order_date"]);
    $date_format = date_format($date,"F,d,Y");

    $date1 = $row['order_date'];
    $time1 = $row['order_time'];
    if($date_today == $date1 && $time_today <= $time1){
    $output .= '
      <tr>
        <td><span class="glyphicon glyphicon-exclamation-sign" style="color:red"></td>
        <td>'.$row["fname"].' '.$row["lname"].'</td>
        <td>'.$row["prd_title"].'</td>
        <td>'.$row["o_quantity"].'</td>
        <td>'.$row["o_price"].'</td>
        <td>'.$date_format.'</td>
        <td>'.$row["order_time"].'</td>
        <td>'.$row["status"].'</td>
      </tr>';
    }else{
       $output .= '
      <tr>
        <td></td>
        <td>'.$row["fname"].' '.$row["lname"].'</td>
        <td><img src="images/'.$product[0].'" style="width:70px;height:60px;">'.$row["prd_title"].'</td>
        <td>'.$row["o_quantity"].'</td>
        <td>'.$row["o_price"].'</td>
        <td>'.$date_format.'</td>
        <td>'.$row["order_time"].'</td>
        <td>'.$row["status"].'</td>
      </tr>';
    }
  } 
  $output .= '</tbody></table><input type="submit" value="View Summary Report" id="summary" name="summary" class="btn btn-success">';
}else{
  $output = '<h1 style="margin-left:100px">There is no unpaid orders</h1>';
}
  }else if($type == 2){
     $output = '<table class="table table-bordered" id="orderTables">
    <thead>
      <tr>
        <th>Name</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Order Date</th>
        <th>OrderTime</th>
        <th>Action</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
   ';
   if($dateFrom == '' && $dateTo == ''){
      $query = "SELECT * FROM orders,products,register WHERE o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'pending'"; 
    }else{
       $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'pending'";
    }
     $result = mysqli_query($con, $query);
     if(mysqli_num_rows($result) > 0)
{ 
  while($row = mysqli_fetch_array($result)){
    $image = $row['prd_img'];
  $product = explode(",", $image);
    $date = date_create($row["order_date"]);
    $date_format = date_format($date,"F,d,Y");
    $output .= '
      <tr>
        <td>'.$row["fname"].' '.$row["lname"].'</td>
        <td><img src="images/'.$product[0].'" style="width:70px;height:60px;">'.$row["prd_title"].'</td>
        <td>'.$row["o_quantity"].'</td>
        <td>'.$row["o_price"].'</td>
        <td>'.$date_format.'</td>
        <td>'.$row["order_time"].'</td>
        <td><select class="form-control" id="'.$row["order_id"].'">
                <option></option>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
            </select>
        </td>
        <td><button type="submit" class="button" id="updateOrder" o_id="'.$row["order_id"].'">Submit</button></td>
      </tr>';
    }
    $output .= ' </tbody>
  </table><input type="submit" value="View Summary Report" id="summary" name="summary" class="btn btn-success">';
  }else{
    $output = '<h1 style="margin-left:100px">There is no unpaid orders</h1>';
  }
  }else if($type == 3){
     $output = '<table class="table table-bordered" id="orderTables">
    <thead>
      <tr>
        <th>Name</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Order Date</th>
        <th>Order Time</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
   ';
   if($dateFrom == '' && $dateTo == ''){
      $query = "SELECT * FROM orders,products,register WHERE o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status='paid'"; 
    }else{
       $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'paid'";
    }
     $result = mysqli_query($con, $query);
     if(mysqli_num_rows($result) > 0)
{ 
  while($row = mysqli_fetch_array($result)){
    $image = $row['prd_img'];
  $product = explode(",", $image);
    $date = date_create($row["order_date"]);
    $date_format = date_format($date,"F,d,Y");
    $output .= '
      <tr>
        <td>'.$row["fname"].' '.$row["lname"].'</td>
        <td><img src="images/'.$product[0].'" style="width:70px;height:60px;">'.$row["prd_title"].'</td>
        <td>'.$row["o_quantity"].'</td>
        <td>'.$row["o_price"].'</td>
        <td>'.$date_format.'</td>
        <td>'.$row["order_time"].'</td>
        <td>'.$row["status"].'</td>
      </tr>';
    }
    $output .= ' </tbody>
  </table><input type="submit" value="View Summary Report" id="summary" name="summary" class="btn btn-success">';
  }else{
    $output = '<h1 style="margin-left:100px">There is no unpaid orders</h1>';
  }
  }else if($type == 4){
    $image = $row['prd_img'];
  $product = explode(",", $image);
     $output = '<table class="table table-bordered" id="orderTables">
    <thead>
      <tr>
        <th>Name</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Order Date</th>
        <th>Order Time</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
   ';
   if($dateFrom == '' && $dateTo == ''){
      $query = "SELECT * FROM orders,products,register WHERE o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'cancel'"; 
    }else{
       $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'cancel'";
    }
     $result = mysqli_query($con, $query);
     if(mysqli_num_rows($result) > 0)
{ 
  while($row = mysqli_fetch_array($result)){
    $date = date_create($row["order_date"]);
    $date_format = date_format($date,"F,d,Y");
    $output .= '
      <tr>
        <td>'.$row["fname"].' '.$row["lname"].'</td>
        <td><img src="images/'.$product[0].'" style="width:70px;height:60px;">'.$row["prd_title"].'</td>
        <td>'.$row["o_quantity"].'</td>
        <td>'.$row["o_price"].'</td>
        <td>'.$date_format.'</td>
        <td>'.$row["order_time"].'</td>
        <td>'.$row["status"].'</td>
      </tr>';
    }
    $output .= ' </tbody>
  </table><input type="submit" value="View Summary Report" id="summary" name="summary" class="btn btn-success">';
  }else{
    $output = '<h1 style="margin-left:100px">There is no unpaid orders</h1>';
   }
  }else if($type == 5){
     $output = '';
       if($dateFrom == '' && $dateTo == ''){
      $query = "SELECT * FROM orders,products,register WHERE o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'paid' ORDER BY order_date ASC"; 
    }else{
       $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'paid' ORDER BY order_date ASC";
    } 
    $result = mysqli_query($con, $query);
    $result1 = mysqli_query($con, $query);
    $array = mysqli_fetch_array($result1);
    $getCode = $array[1];
    $day = array();
    $sales = array();
     $day1 = array();
    $order = array();
    $chartData = '';
    $count = mysqli_num_rows($result);
    $i = 1;
    $output .= '<table class="table table-bordered" id="orderTables" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Order Number</th>
                    <th>Total Orders</th>
                    <th>Total Amount</th>
                    <th></th>
                  </tr>
                </thead>
              <tbody>
             ';
    while($row = mysqli_fetch_array($result)){
       $chartData .= "{ date:'".$row['order_date']."', orders:" .$row['o_quantity'].", price:".$row['o_price']."}, ";
      if($getCode == $row['order_code']){
       $orders += $row['o_quantity'];
       $oDay = $row['order_date'];
       // $date = date_create($row["order_date"]);
       // $date_format = date_format($date,"F,d,Y");
       $totalOrders = $orders;
       $total += $row['o_quantity'] * $row['o_price'];
        $totalPrice = $total;
        if($i == $count){
          $output .= '
                <tr>
                  <td>'.$getCode.'</td>
                  <td>'.$orders.'</td>
                  <td>P'.$total.'</td>
                  <td> <input type="button" value="...." id="orderDetails" name="'.$getCode.'" style="margin-top:-30px;"class="btn success"></td>
                </tr>';
        }
    }else{
       array_push($day, $oDay);
      array_push($sales, $total);
        $output .= '
                <tr>
                  <td>'.$getCode.'</td>
                  <td>'.$orders.'</td>
                  <td>P'.$total.'</td>
                  <td><input type="button" value="...." id="orderDetails" name="'.$getCode.'" style="margin-top: -30px;"class="btn success"></td>
                </tr>';
      // $date = date_create($row["order_date"]);
      // $date_format = date_format($date,"F,d,Y");
      $price = $row["o_price"];
      $orders = $row['o_quantity'];
      $totalPrice += $orders * $price;
      $totalOrders += $orders;
      $total = $orders * $price;
      $getCode = $row['order_code'];
      $oDay = $row['order_date'];
        if($i == $count){
           array_push($day, $row['order_date']);
      array_push($sales, $total);
           $output .= '
                <tr>
                  <td>'.$getCode.'</td>
                  <td>'.$orders.'</td>
                  <td>P'.$total.'</td>
                  <td><input type="button" value="...." id="orderDetails" name="'.$getCode.'" style="margin-top: -30px;"class="btn success"></td>
                </tr>';
        }
      }
      $i++;
    }
    $output .= '  </tbody>
            </table><div id="container-label">
    <div class = "row">
    <div class="col-sm-2" id="totalSummary"><b>'.$totalOrders.'</b><br>Total Orders</div><br><br>
    <div class="col-sm-2" id="totalSummary" style="margin-left:10px"><b>P'.$totalPrice.'</b><br>Total Amount</div><br><br>
    </div></div><br>';
   
  }
  $data = array(
  'data' => $output,
  'days' => $day,
  'sales' => $sales,
 );
 echo json_encode($data);
 }
 if(isset($_POST['update_order'])){
    $o_id = $_POST['o_id'];
    $type = $_POST['type'];
    $update_query = "UPDATE orders SET status = '$type' WHERE order_id = '$o_id'";
    mysqli_query($con,$update_query);
 }
 if(isset($_POST['myorder'])){
  date_default_timezone_set('Asia/Manila');
  $date_today = date("Y-m-d");
  $time_today = date("H-i-s");
  $type = $_POST['type'];
  $dateFrom = $_POST['dateFrom'];
  $dateTo = $_POST['dateTo'];
  if($type == 1){
     $output = '<table class="table table-hover" id="my_orderTable">
    <thead>
      <tr>
        <th>Seller Name</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
    </thead>
   ';
   if($dateFrom == '' && $dateTo == ''){
    $query = "SELECT * FROM orders,products,register WHERE orderby_id = $id AND product_id = prd_id AND o_producer_id = user_id";
    }else{
      $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND orderby_id = $id AND product_id = prd_id AND o_producer_id = user_id";
    } 
     $result = mysqli_query($con, $query);
     if(mysqli_num_rows($result) > 0)
{ 
  while($row = mysqli_fetch_array($result)){
    $date = date_create($row["order_date"]);
    $date_format = date_format($date,"F,d,Y");

    $date1 = $row['order_date'];
    $time1 = $row['order_time'];
    if($row['status'] != 'cancel'){
    $output .= '<tbody>
      <tr>
        <td>'.$row["fname"].' '.$row["lname"].'</td>
        <td><img src="images/'.$row["prd_img"].'" class="cart-img">'.$row["prd_title"].'</td>
        <td>'.$row["o_quantity"].'</td>
        <td>'.$row["o_price"].'</td>
      </tr>';
    }
  } 
}else{
  $output = 'You have no Orders';
}
  }else if($type == 2){
     $output = '<table class="table table-hover">
    <thead>
      <tr>
        <th>Seller  Name</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th></th>
      </tr>
    </thead>
   ';
   if($dateFrom == '' && $dateTo == ''){
    $query = "SELECT * FROM orders,products,register WHERE orderby_id = $id AND product_id = prd_id AND o_producer_id = user_id AND status = 'cancel'";
    }else{
      $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND orderby_id = $id AND product_id = prd_id AND o_producer_id = user_id AND status = 'cancel'";
    } 
     $result = mysqli_query($con, $query);
     if(mysqli_num_rows($result) > 0)
{ 
  while($row = mysqli_fetch_array($result)){
    $date = date_create($row["order_date"]);
    $date_format = date_format($date,"F,d,Y");
    $output .= '<tbody>
      <tr>
        <td>'.$row["fname"].' '.$row["lname"].'</td>
        <td><img src="images/'.$row["prd_img"].'" class="cart-img">'.$row["prd_title"].'</td>
        <td>'.$row["o_quantity"].'</td>
        <td>'.$row["o_price"].'</td>
      </tr>';
    }
  }else{
    $output = 'You have no cancel Orders';
  }
 }
 echo $output;
} if(isset($_POST['summary'])){
  date_default_timezone_set('Asia/Manila');
   $type = $_POST['type'];
   $dateFrom = $_POST['dateFrom'];
   $dateTo = $_POST['dateTo'];
   $pending = 0; $paid = 0; $cancel = 0;
    if($type == 1){
     $output = '<div class="container">
                        <h2>All Orders Product Summary Report</h2> <br><br> 
                        <div class="row">
                          <div class="col-sm-2"><b>Order Date</b></div>
                          <div class="col-sm-2"><b>Product</b></div>
                          <div class="col-sm-2"><b>Quantity</b></div>
                          <div class="col-sm-2"><b>Price</b></div>
                          <div class="col-sm-2"><b>Total Price</b></div>
                          <div class="col-sm-2"><b>Status</b></div>
                        </div><br><br>';
   if($dateFrom == '' && $dateTo == ''){
      $query = "SELECT * FROM orders,products,register WHERE o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id"; 
    }else{
       $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id";
    }
     $result = mysqli_query($con, $query);
     if(mysqli_num_rows($result) > 0)
{ 
  while($row = mysqli_fetch_array($result)){
    $date = date_create($row["order_date"]);
    $date_format = date_format($date,"F,d,Y");
    $date1 = $row['order_date'];
    $time1 = $row['order_time'];
    $price = $row['o_quantity'] * $row['o_price'];
    $total += $price;
    $output .= '<div class="row">
                          <div class="col-sm-2">'.$row["order_date"].'</div>
                          <div class="col-sm-2">'.$row["prd_title"].'</div>
                          <div class="col-sm-2">'.$row["o_quantity"].'</div>
                          <div class="col-sm-2">P'.$row["o_price"].'</div>
                          <div class="col-sm-2">P'.$price.'</div>
                          <div class="col-sm-2">'.$row["status"].'</div>
                        </div><hr>';
      if($row['status'] == 'pending'){
        $pending += 1;
      }else if($row['status'] == 'paid'){
        $paid += 1;
      } else{
        $cancel += 1;
      }
  }
   $output .= "<div class='row'>
                      <div class='col-sm-6'><b></b></div>
                      <div class='col-sm-2'><b>Total</b></div>
                      <div class='col-sm-2'><b>P".$total."</b><div>
                    </div><br>
                  </div></div></div><br>
                  "; 
                  $output .='<div class="container" style="width: 70%;"><br>
                              <div class="row"><div class="col-sm-10">Total Pending Products: '.$pending.'</div></div><br>
                              <div class="row"><div class="col-sm-10">Total Paid Products: '.$paid.'</div></div><br>
                              <div class="row"><div class="col-sm-10">Total Cancel Products: '.$cancel.'</div></div><br>
                            </div>
                          ';
}else{
  $output = 'There is no pending orders';
}
  }else if($type == 2){
     $output = '<label for="dateFrom">Date From</label>
            <input type="date" id="dateFrom" name="dateFrom"> - 
            <label for="dateTo">Date To</label>
            <input type="date" id="dateTo" name="dateTo">
            <input type="submit" value="Search" id="searchMyOrder" name="searchMyOrder" class="btn1">
            <p><br></p>
            <input type="submit" value="Show All" id="showAll" name="showAll" class="btn1">
            <p><br></p><table class="table table-hover" id="orderTable">
    <thead>
      <tr>
        <th>Name</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Order Date</th>
        <th>OrderTime</th>
        <th>Action</th>
        <th></th>
      </tr>
    </thead>
   ';
   if($dateFrom == '' && $dateTo == ''){
      $query = "SELECT * FROM orders,products,register WHERE o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'pending'"; 
    }else{
       $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'pending'";
    }
     $result = mysqli_query($con, $query);
     if(mysqli_num_rows($result) > 0)
{ 
  while($row = mysqli_fetch_array($result)){
    $date = date_create($row["order_date"]);
    $date_format = date_format($date,"F,d,Y");
    $output .= '<tbody>
      <tr>
        <td>'.$row["fname"].' '.$row["lname"].'</td>
        <td><img src="images/'.$row["prd_img"].'" class="cart-img">'.$row["prd_title"].'</td>
        <td>'.$row["o_quantity"].'</td>
        <td>'.$row["o_price"].'</td>
        <td>'.$date_format.'</td>
        <td>'.$row["order_time"].'</td>
        <td><select class="form-control" id="'.$row["order_id"].'">
                <option></option>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
            </select>
        </td>
        <td><button type="submit" class="button" id="updateOrder" o_id="'.$row["order_id"].'">Submit</button></td>
      </tr>';
    }
    $output .= ' </tbody>
  </table><input type="submit" value="View Summary Report" id="summary" name="summary" class="btn btn-success">';
  }else{
    $output = 'There is no pending orders';
  }
  }else if($type == 3){
     $output = '<div class="container">
                        <h2>All Orders Product Paid Summary Report</h2> <br><br> 
                        <div class="row">
                          <div class="col-sm-2"><b>Order Date</b></div>
                          <div class="col-sm-2"><b>Product</b></div>
                          <div class="col-sm-2"><b>Quantity</b></div>
                          <div class="col-sm-2"><b>Price</b></div>
                          <div class="col-sm-2"><b>Total Price</b></div>
                          <div class="col-sm-2"><b>Status</b></div>
                        </div><br><br>';
   if($dateFrom == '' && $dateTo == ''){
      $query = "SELECT * FROM orders,products,register WHERE o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'paid'"; 
    }else{
       $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'paid'";
    }
     $result = mysqli_query($con, $query);
     if(mysqli_num_rows($result) > 0)
{ 
  while($row = mysqli_fetch_array($result)){
    $date = date_create($row["order_date"]);
    $date_format = date_format($date,"F,d,Y");
    $date1 = $row['order_date'];
    $time1 = $row['order_time'];
    $price = $row['o_quantity'] * $row['o_price'];
    $total += $price;
    $output .= '<div class="row">
                          <div class="col-sm-2">'.$row["order_date"].'</div>
                          <div class="col-sm-2">'.$row["prd_title"].'</div>
                          <div class="col-sm-2">'.$row["o_quantity"].'</div>
                          <div class="col-sm-2">P'.$row["o_price"].'</div>
                          <div class="col-sm-2">P'.$price.'</div>
                          <div class="col-sm-2">'.$row["status"].'</div>
                        </div><hr>';
      if($row['status'] == 'pending'){
        $pending += 1;
      }else if($row['status'] == 'paid'){
        $paid += 1;
      } else{
        $cancel += 1;
      }
  }
   $output .= "<div class='row'>
                      <div class='col-sm-6'><b></b></div>
                      <div class='col-sm-2'><b>Total</b></div>
                      <div class='col-sm-2'><b>P".$total."</b><div>
                    </div><br>
                  </div></div></div><br>
                  "; 
                  $output .='<div class="container" style="width: 70%;"><br>
                              <div class="row"><div class="col-sm-10"><h3>Total Paid Products: '.$paid.'</h3></div></div><br>
                            </div>
                          ';
}else{
  $output = 'There is no pending orders';
}
  }
  echo $output;
}
if(isset($_POST['deliver_products'])){
  $search = $_POST['deliver_products'];
  if($search != ''){
    $query = "SELECT * FROM products WHERE prd_title LIKE '%".$search."%' AND producer_id = $id";
  }else{
    $query = "SELECT * FROM products WHERE producer_id = $id";
  }
  $result = mysqli_query($con, $query);
  if(mysqli_num_rows($result) > 0)
{ 
$output .= '
  <table class="table table-hover" id="orderTable" style="width:100%;">
    <thead>
      <tr>
        <th hidden></th>
        <th>Item</th>
        <th>Left</th>
        <th></th>
      </tr>
    </thead>';
    $i = 0;
   while($row = mysqli_fetch_array($result)){
      $output .= '<tbody>
                  </tr>
                    <td hidden>'.$row["prd_id"].'</td>
                    <td>'.$row["prd_title"].'</td>
                    <td>'.$row["prd_quantity"].'</td>
                    <td><input type="hidden" value="Edit" id="edit" p_id="'.$row["prd_id"].'" style="margin-top: 1px;"class="btn btn-success"></td>
                  </tr>';
                  $i++;
   }
   $output .= '</tbody></table>';
 }else{
   $output = '<div class="container-deliver"><h2>No Product Found</h2></div>';
 }
 echo $output;
}if(isset($_POST['insert_deliver'])){
  $prd_id = $_POST['prd_id'];
  $left = $_POST['left'];
  $deliver = $_POST['deliver'];
  $delivery_code = $_POST['delivery_code'];
  date_default_timezone_set('Asia/Manila');
  $date_today = date("Y-m-d");
  // values ('$pid','$product_cat','$product_title','$product_price','$product_desc','$product_image','$product_quantity',CURRENT_TIMESTAMP)";
   
  // $run_product = mysqli_query($con,$insert_product);
foreach( $prd_id as $key => $n ) {
  $insert_deliver = "INSERT INTO  deliver (deliver_code,user_id3,prd_id3,qty_left,qty_deliver,deliver_date) VALUES (
            '$delivery_code','$id','$n','$left[$key]','$deliver[$key]','$date_today')";
  $result = mysqli_query($con,$insert_deliver);
  $update_quantity = "UPDATE products SET prd_quantity = prd_quantity + $deliver[$key] WHERE prd_id = $n";
  $result1 = mysqli_query($con,$update_quantity);
}

}
if(isset($_POST['order_details'])){
  $code = $_POST['code'];
  $num = $_POST['num'];
   $query = "SELECT * FROM orders,products WHERE order_code = '$code' AND prd_id = product_id";
   $result = mysqli_query($con, $query);
   if($num == 1){
      $output = '
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Order Date</th>
        <th>Item</th>
        <th>Price</th>
        <th>Total Price</th>
      </tr>
    </thead>';
    while($row = mysqli_fetch_array($result)){
      $date = date_create($row["order_date"]);
      $date_format = date_format($date,"F,d,Y");
      $total = $row['o_quantity'] * $row['o_price'];
      $totalAmount += $total;
      $output .= '<tbody>
                  </tr>
                    <td>'.$date_format.'</td>
                    <td>'.$row["prd_title"].'</td>
                    <td>P'.$row["o_price"].'</td>
                    <td>P'.$total.'</td>
                  </tr>';
   }
   $output .= '</tr>
                    <td></td>
                    <td></td>
                    <td><p><b>Total:</b></p></td>
                    <td>P'.$totalAmount.'</td>
                  </tr>
                  </tbody></table>';
   }else if($num == 2){
    $output = '
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Order Date</th>
        <th>Item</th>
        <th>Quantity</th>
      </tr>
    </thead>';
    while($row = mysqli_fetch_array($result)){
      $date = date_create($row["order_date"]);
      $date_format = date_format($date,"F,d,Y");
      $totalOrders += $row['o_quantity'];
      $output .= '<tbody>
                  </tr>
                    <td>'.$date_format.'</td>
                    <td>'.$row["prd_title"].'</td>
                    <td>'.$row["o_quantity"].'</td>
                  </tr>';
   }
   $output .= '</tr>
                    <td></td>
                    <td><p><b>Total:</b></p></td>
                    <td>'.$totalOrders.'</td>
                  </tr>
                  </tbody></table>';
   }else{
   $output = '
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Order Date</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total Price</th>
      </tr>
    </thead>';
    while($row = mysqli_fetch_array($result)){
      $date = date_create($row["order_date"]);
      $date_format = date_format($date,"F,d,Y");
      $total = $row['o_quantity'] * $row['o_price'];
      $totalAmount += $total;
      $output .= '<tbody>
                  </tr>
                    <td>'.$date_format.'</td>
                    <td>'.$row["prd_title"].'</td>
                    <td>'.$row["o_quantity"].'</td>
                    <td>P'.$row["o_price"].'</td>
                    <td>P'.$total.'</td>
                  </tr>';
   }
   $output .= '</tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><p><b>Total:</b></p></td>
                    <td>P'.$totalAmount.'</td>
                  </tr>
                  </tbody></table>';
                }
   echo $output;
}
if(isset($_POST['deliver_details'])){
  $code = $_POST['code'];
   $query = "SELECT * FROM products,deliver WHERE deliver_code = $code AND prd_id3 =prd_id AND user_id3 = $id";
   $result = mysqli_query($con, $query);
   $output = '
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Delivery Date</th>
        <th>Product Name</th>
        <th>Quantity Left</th>
        <th>Quantity Deliver</th>
        <th>Total Quantity</th>
      </tr>
    </thead>';
    while($row = mysqli_fetch_array($result)){
      $total = $row['qty_left'] + $row['qty_deliver'];
      $output .= '<tbody>
                  </tr>
                    <td>'.$row["deliver_date"].'</td>
                    <td>'.$row["prd_title"].'</td>
                    <td>'.$row["qty_left"].'</td>
                    <td>'.$row["qty_deliver"].'</td>
                    <td>'.$total.'</td>
                  </tr>';
   }
   $output .= '</tbody></table>';
   echo $output;
}if(isset($_POST['dashboard'])){

    $query = "SELECT * FROM orders WHERE o_producer_id = $id ORDER BY order_date ASC"; 
    $result = mysqli_query($con, $query);
    $result1 = mysqli_query($con, $query);
    $array = mysqli_fetch_array($result1);
    $getDate = $array[7];
    $day = array();
    $sales = array();
    $order = array();
    $chartData = '';
    $count = mysqli_num_rows($result);
    $i = 1;
    if(mysqli_num_rows($result) > 0)
{ 
    while($row = mysqli_fetch_array($result)){
      if($getDate == $row['order_date']){
       $orders += $row['o_quantity'];
       $oDay = $row['order_date'];
       $totalOrders = $orders;
       $total += $row['o_quantity'] * $row['o_price'];
        $totalPrice = $total;
        if($i == $count){
          array_push($day, $oDay);
          array_push($sales, $total);
          array_push($order, $orders);
        }
    }else{
       array_push($day, $oDay);
      array_push($sales, $total);
      array_push($order, $orders);
      $price = $row["o_price"];
      $orders = $row['o_quantity'];
      $total = $orders * $price;
      $totalPrice += $orders * $price;
      $totalOrders += $orders;
      $oDay = $row['order_date'];
      $getDate = $row['orderDate'];
        if($i == $count){
          array_push($day, $oDay);
        array_push($sales, $total);
        array_push($order, $orders);
        }
      }
      $i++;
    }
  }else{
    $sales = 0;
    $order = 0;
    $totalOrders = 0;
    $totalPrice = 0;
  }
       $data = array(
    'days'   => $day,
    'sales' => $sales,
    'orders' => $order,
    'totalOrders' => $totalOrders,
    'totalSales' => $totalPrice,
   );
 echo json_encode($data);
}if(isset($_POST['chart'])){
  
  $type = $_POST['type'];
  $chartType = $_POST['chartType'];
  
 if($type == "Last Week"){
      $previous_week = strtotime("-1 week +1 day");
      $start_week = strtotime("last sunday midnight",$previous_week);
$end_week = strtotime("next saturday",$start_week);

$start_week = date("Y-m-d",$start_week);
$end_week = date("Y-m-d",$end_week);
   $query = "SELECT * FROM orders WHERE order_date BETWEEN '$start_week' AND '$end_week' AND o_producer_id = $id AND status = 'paid' ORDER BY order_date ASC"; 
   //$query = "SELECT * FROM orders,products WHERE o_producer_id = $id AND product_id = prd_id ORDER BY product_id";
   }else if($type == "Last Month"){
      $output .= $_POST["chart"];
      $dateFrom = date("Y-m-d", strtotime("first day of previous month "));
   $dateTo = date("Y-m-d", strtotime("last day of previous month"));
   $query = "SELECT * FROM orders WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND o_producer_id = $id AND status = 'paid' ORDER BY order_date ASC"; 
   }
    
    $result = mysqli_query($con, $query);
    $result1 = mysqli_query($con, $query);
    $array = mysqli_fetch_array($result1);
    $getDate = $array[7];
    $day = array();
    $sales = array();
    $order = array();
    $chartData = '';
    $count = mysqli_num_rows($result);
    $i = 1;
    if(mysqli_num_rows($result) > 0)
{ 
    while($row = mysqli_fetch_array($result)){
      if($getDate == $row['order_date']){
       $orders += $row['o_quantity'];
       $oDay = $row['order_date'];
       $totalOrders = $orders;
       $total += $row['o_quantity'] * $row['o_price'];
        $totalPrice = $total;
        if($i == $count){
          array_push($day, $oDay);
          array_push($sales, $total);
          array_push($order, $orders);
        }
    }else{
       array_push($day, $oDay);
      array_push($sales, $total);
      array_push($order, $orders);
      $price = $row["o_price"];
      $orders = $row['o_quantity'];
      $total = $orders * $price;
      $totalPrice += $orders * $price;
      $totalOrders += $orders;
      $oDay = $row['order_date'];
      $getDate = $row['orderDate'];
        if($i == $count){
          array_push($day, $oDay);
        array_push($sales, $total);
        array_push($order, $orders);
        }
      }
      $i++;
    }
  }else{
    $sales = 0;
    $order = 0;
    $totalOrders = 0;
    $totalPrice = 0;
  }
       $data = array(
    'days'   => $day,
    'sales' => $sales,
    'orders' => $order,
    'totalOrders' => $totalOrders,
    'totalSales' => $totalPrice,
   );
 echo json_encode($data);
}if(isset($_POST['dashboard_details'])){
  $type = $_POST['type'];
  // $query = "SELECT * FROM orders,products,register WHERE o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'paid' ORDER BY order_date ASC"; 
   $week = $_POST['top'];
   if($week == "Last Week"){
      $previous_week = strtotime("-1 week +1 day");echo "<br>";
      $start_week = strtotime("last sunday midnight",$previous_week);
$end_week = strtotime("next saturday",$start_week);

$start_week = date("Y-m-d",$start_week);
$end_week = date("Y-m-d",$end_week);
   $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$start_week' AND '$end_week' AND o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'paid' ORDER BY order_date ASC";
   //$query = "SELECT * FROM orders,products WHERE o_producer_id = $id AND product_id = prd_id ORDER BY product_id";
   }else{
      echo $week;
      $dateFrom = date("Y-m-d", strtotime("first day of previous month "));
   $dateTo = date("Y-m-d", strtotime("last day of previous month"));
   $query = "SELECT * FROM orders,products,register WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND o_producer_id = $id AND product_id = prd_id AND orderby_id = user_id AND status = 'paid' ORDER BY order_date ASC";
   }
     $result = mysqli_query($con, $query);
    $result1 = mysqli_query($con, $query);
    $array = mysqli_fetch_array($result1);
    $getCode = $array[1];
    $day = array();
    $sales = array();
    $chartData = '';
    $count = mysqli_num_rows($result);
    $i = 1;

  if($type == 1){
    while($row = mysqli_fetch_array($result)){
       $chartData .= "{ date:'".$row['order_date']."', orders:" .$row['o_quantity'].", price:".$row['o_price']."}, ";
      if($getCode == $row['order_code']){
       $orders += $row['o_quantity'];
       $oDay = $row['order_date'];
       // $date = date_create($row["order_date"]);
       // $date_format = date_format($date,"F,d,Y");
       $totalOrders = $orders;
       $total += $row['o_quantity'] * $row['o_price'];
        $totalPrice = $total;
        if($i == $count){
          $output .= '<tr>
                  <td>'.$getCode.'</td>
                  <td>P'.$total.'</td>
                  <td> <input type="button" value="..." id="orderDetails" name="'.$getCode.'" style="margin-top:1px;"class="btn success"></td>
                </tr>';
        }
    }else{
       array_push($day, $oDay);
      array_push($sales, $total);
        $output .= '<tr>
                  <td>'.$getCode.'</td>
                  <td>P'.$total.'</td>
                  <td><input type="button" value="..." id="orderDetails" name="'.$getCode.'" style="margin-top: 1px;"class="btn success"></td>
                </tr>';
      // $date = date_create($row["order_date"]);
      // $date_format = date_format($date,"F,d,Y");
      $price = $row["o_price"];
      $orders = $row['o_quantity'];
      $totalPrice += $orders * $price;
      $totalOrders += $orders;
      $total = $orders * $price;
      $getCode = $row['order_code'];
      $oDay = $row['order_date'];
        if($i == $count){
           array_push($day, $row['order_date']);
      array_push($sales, $total);
           $output .= '<tr>
                  <td>'.$getCode.'</td>
                  <td>P'.$total.'</td>
                  <td><input type="button" value="..." id="orderDetails" name="'.$getCode.'" style="margin-top: 1px;"class="btn success"></td>
                </tr>';
        }
      }
      $i++;
    }
  }else if($type == 2){
    while($row = mysqli_fetch_array($result)){
       $chartData .= "{ date:'".$row['order_date']."', orders:" .$row['o_quantity'].", price:".$row['o_price']."}, ";
      if($getCode == $row['order_code']){
       $orders += $row['o_quantity'];
       $oDay = $row['order_date'];
       // $date = date_create($row["order_date"]);
       // $date_format = date_format($date,"F,d,Y");
       $totalOrders = $orders;
       $total += $row['o_quantity'] * $row['o_price'];
        $totalPrice = $total;
        if($i == $count){
          $output .= '<tr>
                  <td>'.$getCode.'</td>
                  <td>'.$orders.'</td>
                  <td> <input type="button" value="..." id="orderDetails" name="'.$getCode.'" style="margin-top: 1px;"class="btn success"></td>
                </tr>';
        }
    }else{
       array_push($day, $oDay);
      array_push($sales, $total);
        $output .= '<tr>
                  <td>'.$getCode.'</td>
                  <td>'.$orders.'</td>
                  <td><input type="button" value="..." id="orderDetails" name="'.$getCode.'" style="margin-top: 1px;"class="btn success"></td>
                </tr>';
      // $date = date_create($row["order_date"]);
      // $date_format = date_format($date,"F,d,Y");
      $price = $row["o_price"];
      $orders = $row['o_quantity'];
      $totalPrice += $orders * $price;
      $totalOrders += $orders;
      $total = $orders * $price;
      $getCode = $row['order_code'];
      $oDay = $row['order_date'];
        if($i == $count){
           array_push($day, $row['order_date']);
      array_push($sales, $total);
           $output .= '<tbody>
                <tr>
                  <td>'.$getCode.'</td>
                  <td>'.$orders.'</td>
                  <td><input type="button" value="..." id="orderDetails" name="'.$getCode.'" style="margin-top: 1px;"class="btn success"></td>
                </tr>';
        }
      }
      $i++;
    }
  }else{
    $aa = $_POST['top'];
  if($aa == "Last Week"){
      $previous_week = strtotime("-1 week +1 day");echo "<br>";
    $start_week = strtotime("last sunday midnight",$previous_week);
$end_week = strtotime("next saturday",$start_week);

$start_week = date("Y-m-d",$start_week);
$end_week = date("Y-m-d",$end_week);
  $query = "SELECT * FROM orders,products WHERE order_date BETWEEN '$start_week' AND '$end_week' AND o_producer_id = $id AND product_id = prd_id ORDER BY product_id";
   //$query = "SELECT * FROM orders,products WHERE o_producer_id = $id AND product_id = prd_id ORDER BY product_id";
  }else{
    $dateFrom = date("Y-m-d", strtotime("first day of previous month "));
  $dateTo = date("Y-m-d", strtotime("last day of previous month"));
  $query = "SELECT * FROM orders,products WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND o_producer_id = $id AND product_id = prd_id ORDER BY product_id";
  }
    $result = mysqli_query($con, $query);
    $topSelling = array();
    $result1 = mysqli_query($con, $query);
    $array = mysqli_fetch_array($result1);
      $count = mysqli_num_rows($result);
    $getCode = $array[3];
    while($row = mysqli_fetch_array($result)){
      if($getCode == $row['product_id']){
        $product = $row['prd_title'];
       $orders += $row['o_quantity'];
        $total = $orders;
        if($i == $count){
          array_push($topSelling, [$product,$total]);
        }
    }else{
       array_push($topSelling, [$product,$total]);
      $price = $row["o_price"];
      $orders += $row['o_quantity'];
      $product = $row['prd_title'];
      $getCode = $row['product_id'];
      $total = $orders;
        if($i == $count){
           array_push($topSelling, [$product,$total]);
        }
      }
      $i++;    
    }
    $sorttop = array();
  foreach ($topSelling as $top) {
    $sorttop[] = $top['1'];
    }
    array_multisort($sorttop, SORT_DESC, $topSelling);
  $tmp = 0;
   foreach( $topSelling as $sell )
{
    $output .= '<tr>';
    foreach( $sell as $key )
    {
        $output .= '<td>'.$key.'</td>';
    }
    $output .= '</tr>';
}   
  }

  echo $output;
}if(isset($_POST['media'])){

  //$query = "SELECT * FROM products,friend,register WHERE friend_id = $id AND accept = 1 AND user_id = user_id1 ORDER BY prd_id DESC"; 
//  $query = "SELECT * FROM products,friend,register WHERE friend_id = $id AND accept = 1 AND user_id1 = producer_id AND user_id = user_id1 ORDER BY prd_id DESC"; 
  $query = "SELECT * FROM products
        LEFT JOIN friend
        ON friend.user_id1 = products.producer_id
        LEFT JOIN register
        ON register.user_id = products.producer_id ORDER BY prd_id DESC";
  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_array($result)){
    if($row["friend_id"] == $id && $row["accept"] == 1 && $row["user_id1"] = $row["producer_id"]){
    $name = $row['fname'] . ' ' . $row['lname'];
    $image = $row['prd_img'];
     $product = explode(",", $image);
     $length = count($product);
    $time_ago = $row['status_time'];
    $output .= '<div class="w3-container w3-card w3-white w3-round w3-margin"><br>
        <img src="images/'.$row["profile_image"].'" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
        <span class="w3-right w3-opacity">'.$get->timeAgo($time_ago).'</span>
        <h4>'.$name.'</h4><br>
        <hr class="w3-clear">
        <p>'.$row["prd_desc"].'</p> 
        <div class="w3-row-padding" style="margin:0 -16px">';
        foreach($product as $i =>$key) {
          if($length > 1){
            $output .= ' <div class="w3-half">
              <img src="images/'.$product[$i].'" style="width:100%;height:250px;" alt="Products" class="w3-margin-bottom">
            </div>';
          }else{
            $output .= '<img src="images/'.$product[$i].'" style="width:100%;height:250px;" class="w3-margin-bottom">';
          }
      }
      $output .= '
        </div>
        <a class="w3-button w3-theme-d1 w3-margin-bottom" href="details.php?pro_id='.$row['prd_id'].'">View Product</a>
      </div>';
    
     }if($row["producer_id"] == $id){
      $name = $row['fname'] . ' ' . $row['lname'];
    $image = $row['prd_img'];
     $product = explode(",", $image);
     $length = count($product);
    $time_ago = $row['status_time'];
    $output .= '<div class="w3-container w3-card w3-white w3-round w3-margin"><br>
        <img src="images/'.$row["profile_image"].'" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
        <span class="w3-right w3-opacity">'.$get->timeAgo($time_ago).'</span>
        <h4>'.$name.'</h4><br>
        <hr class="w3-clear">
        <p>'.$row["prd_desc"].'</p> 
        ';
    foreach($product as $i =>$key) {
          if($length > 1){
            $output .= ' <div class="w3-half">
              <img src="images/'.$product[$i].'" style="width:100%" alt="Products" class="w3-margin-bottom">
            </div>';
          }else{
            $output .= '<img src="images/'.$product[$i].'" style="width:100%;height:250px;" class="w3-margin-bottom">';
          }
      }
      $output .= '<br>
        <a class="w3-button w3-theme-d1 w3-margin-bottom" href="details.php?pro_id='.$row['prd_id'].'">View Product</a>
      </div>';
     }
  }
  echo $output;
}if(isset($_POST['most_order'])){
  $type = $_POST['type'];

  if($type == 'Last Week'){
    $previous_week = strtotime("-1 week +1 day");

    $start_week = strtotime("last sunday midnight",$previous_week);
    $end_week = strtotime("next saturday",$start_week);

    $start_week = date("Y-m-d",$start_week);
    $end_week = date("Y-m-d",$end_week);
    $query = "SELECT * FROM orders,products WHERE order_date BETWEEN '$start_week' AND '$end_week' AND product_id = prd_id ORDER BY product_id"; 
    $result = mysqli_query($con, $query);
  }if($type == 'Last Month'){
    $dateFrom = date("Y-m-d", strtotime("first day of previous month "));
    $dateTo = date("Y-m-d", strtotime("last day of previous month"));
    $query = "SELECT * FROM orders,products WHERE order_date BETWEEN '$dateFrom' AND '$dateTo' AND product_id = prd_id ORDER BY product_id"; 
    $result = mysqli_query($con, $query);
  }
  
    $topSelling = array();
    $result1 = mysqli_query($con, $query);
    $array = mysqli_fetch_array($result1);
    $getCode = $array[3];
    $count = mysqli_num_rows($result);
    //echo $count;
    $i = 1;
    while($row = mysqli_fetch_array($result)){
      if($getCode == $row['product_id']){
        $product = $row['prd_id'];
        $prd_title = $row['prd_title'];
        $prd_price = $row['prd_price'];
        $prd_desc = $row['prd_desc'];
        $prd_img = $row['prd_img'];
       $total += $row['o_quantity'];
        if($i == $count){
          array_push($topSelling, [$product,$prd_title,$prd_price,$prd_desc,$prd_img,$total]);
        }
    }else{
       array_push($topSelling, [$product,$prd_title,$prd_price,$prd_desc,$prd_img,$total]);
      $price = $row["o_price"];
      $orders += $row['o_quantity'];
      $product = $row['prd_id'];
      $prd_title = $row['prd_title'];
        $prd_price = $row['prd_price'];
        $prd_desc = $row['prd_desc'];
        $prd_img = $row['prd_img'];
      $getCode = $row['product_id'];
      $total = $orders;
        if($i == $count){
           array_push($topSelling, [$product,$prd_title,$prd_price,$prd_desc,$prd_img,$total]);
        }
      }
      $i++;    
    }
    $sorttop = array();
  foreach ($topSelling as $top) {
    $sorttop[] = $top['5'];
    }
    array_multisort($sorttop, SORT_DESC, $topSelling);

  $tmp = 0; 
   $length = sizeof($topSelling);
   $num = 0;

   $query1 = "SELECT * FROM products"; 
   $result2 = mysqli_query($con, $query1);

     $output = '<div class="container">
          <div class="row">';
          for ($i=0; $i < $length; $i++) {
            $image = $topSelling[$i][4];
        $product = explode(",", $image);
            $output .= '<div class="card bg-light mb-3"><div class="card-body">
                     <a href="details.php?pro_id='.$topSelling[$i][0].'"><img class="img-fluid" src="images/'.$product[0].'"id="img-display"/></a>
                    <h5 class="card-title">'.$topSelling[$i][1].'</h5>
                    <p class="card-text">'.$topSelling[$i][3].'</p>
                    <p class="bloc_left_price">P'.$topSelling[$i][2].'</p>
                </div></div>';
        //    $output .= '<div class="card-body">
        //     <div class="product-grid2">
        //         <div class="product-image2"><br>
        //             <a href="details.php?pro_id='.$topSelling[$i][0].'"><img src="images/'.$topSelling[$i][4].'" style="width:300px;height:200px;"></a>
        //             <a class="add-to-cart" href="">'.$topSelling[$i][3].'</a>
        //         </div>
        //         <div class="product-content">
        //             <h3 class="title">'.$topSelling[$i][1].'</h3>
        //             <span class="price">P'.$topSelling[$i][2].'</span>
        //         </div>
        //     </div>
        // </div>';
          }
           
   $output .= '</div></div>';
  echo $output;

}if(isset($_POST['my_profile'])){
  $view_id = $_POST['view_id'];
  if($view_id == 1){
   $query = "SELECT * FROM register WHERE user_id = $id";
   $result = mysqli_query($con, $query);
   while($row = mysqli_fetch_array($result)){
    $output .= '<div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Personal Information</h2>
        <div class="w3-container">
        <div class="row">
        <div class="col-md-4">
         <h4>First Name: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["fname"].'</h4>
         </div>
          </div>
          <div class="row">
        <div class="col-md-4">
         <h4>Last Name: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["lname"].'</h4>
         </div>
          </div>
          <div class="row">
        <div class="col-md-4">
         <h4>Email: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["email"].'</h4>
         </div>
          </div>
          <div class="row">
        <div class="col-md-4">
         <h4>Phone Number: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["phone_number"].'</h4>
         </div>
          </div>
          <hr>
                  <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Product Sell</h2>
                  ';

     $seller = explode(",", $row["sellerOf"]);
        foreach($seller as $i =>$key) {
            $output .= '<h4>'.$seller[$i].' 
              ';
      }
        $output .= '</div>

      </div>';
   }
  }if($view_id == 2){
    $query = "SELECT * FROM register,friend WHERE user_id1 = $id AND friend_id = user_id AND accept = 1";
   $result = mysqli_query($con, $query);
   $count = mysqli_num_rows($result);
    $output = ' <div class="w3-container w3-card w3-white">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Friends ('.$count.')</h2>
        <div class="w3-container">
          <p><br></p>
        ';
        $output .= '<div class="row" style="margin:0 -16px">';
      //   foreach($product as $i =>$key) {
      //    if($length > 1){
      //      $output .= ' <div class="w3-half">
      //         <img src="images/'.$product[$i].'" style="width:100%;height:250px;" alt="Products" class="w3-margin-bottom">
      //       </div>';
      //    }else{
      //      $output .= '<img src="images/'.$product[$i].'" style="width:100%;height:250px;" class="w3-margin-bottom">';
      //    }
      // }
    
      while($row = mysqli_fetch_array($result)){
        $name = $row["fname"] .' '. $row["lname"];
        $output.= '<div class="col-md-6" style="margin-bottom: 20px"><img src="images/'.$row["profile_image"].'" alt="Avatar" class="w3-left w3-square w3-margin-right" style="width:100px;height:100px">
            '.$name.'</div>';
      }
      $output .= '</div></div>
      </div>';
  }
  echo $output;
}if(isset($_POST['view_profile'])){
  $view_id = $_POST['view_id'];
  $f_id = $_POST['f_id'];
  $output = '';                      
  if($view_id == 1){
  $query = "SELECT * from register,friend WHERE friend_id = $f_id AND user_id1 = $id AND user_id = $f_id";
    $run = mysqli_query($con,$query);
   $row = mysqli_num_rows($run);
      if ($row == 1) { // means the relationship exist, whether it's active or not
   while($row = mysqli_fetch_array($run)) {

      if ($row['accept'] == 1) {
        $name = $row['fname'] .' '. $row['lname'];
        $output .= '<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
  
    <!-- Left Column -->
    <div class="w3-third">
    
      <div class="w3-white w3-text-grey w3-card-4">
        <div class="w3-display-container">
          <img src="images/'.$row["profile_image"].'" style="width:100%" alt="Avatar">
          <div class="w3-display-bottomleft w3-container w3-text-black">
            <h2>'.$name.'</h2>
          </div>
        </div>
        <div class="w3-container">
          <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>'.$row["email"].'</p>
          <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>'.$row["phone_number"].'</p>
          <h4>You Followed This User</h4>
          <hr>
          <button class="w3-button w3-theme-d1 w3-margin-bottom view" id="1">View Profile</button><br>
          <button class="w3-button w3-theme-d1 w3-margin-bottom view" id="2">View Product</button>
        </div>
      </div><br>

    <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">
      <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Personal Information</h2>
        <div class="w3-container">
        <div class="row">
        <div class="col-md-4">
         <h4>First Name: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["fname"].'</h4>
         </div>
          </div>
          <div class="row">
        <div class="col-md-4">
         <h4>Last Name: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["lname"].'</h4>
         </div>
          </div>
          <div class="row">
        <div class="col-md-4">
         <h4>Email: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["email"].'</h4>
         </div>
          </div>
          <div class="row">
        <div class="col-md-4">
         <h4>Phone Number: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["phone_number"].'</h4>
         </div>
          </div>
          <hr>
                  <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Product Sell</h2>';

                   $seller = explode(",", $row["sellerOf"]);
        foreach($seller as $i =>$key) {
            $output .= '<h4>'.$seller[$i].' 
              ';
      }
        $output .= '</div>

      </div>

    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
</div>';
      }
   }
}
 else { // if the relationship don't exist
  $query = "select * from register where user_id = '$f_id'";
    $run = mysqli_query($con,$query);
  while($row = mysqli_fetch_array($run)) {
      $output .= '<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
  
    <!-- Left Column -->
    <div class="w3-third">
    
      <div class="w3-white w3-text-grey w3-card-4">
        <div class="w3-display-container">
          <img src="images/'.$row["profile_image"].'" style="width:100%" alt="Avatar">
          <div class="w3-display-bottomleft w3-container w3-text-black">
            <h2>'.$name.'</h2>
          </div>
        </div>
        <div class="w3-container">
          <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>'.$row["email"].'</p>
          <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>'.$row["phone_number"].'</p>
          <input type="submit" id="follow" value="Follow This User" class="w3-button w3-theme-d1 w3-margin-bottom"/>
          <hr>
          <button class="w3-button w3-theme-d1 w3-margin-bottom view" id="1">View Profile</button><br>
          <button class="w3-button w3-theme-d1 w3-margin-bottom view" id="2">View Product</button>
        </div>
      </div><br>

    <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">
      <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Personal Information</h2>
        <div class="w3-container">
        <div class="row">
        <div class="col-md-4">
         <h4>First Name: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["fname"].'</h4>
         </div>
          </div>
          <div class="row">
        <div class="col-md-4">
         <h4>Last Name: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["lname"].'</h4>
         </div>
          </div>
          <div class="row">
        <div class="col-md-4">
         <h4>Email: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["email"].'</h4>
         </div>
          </div>
          <div class="row">
        <div class="col-md-4">
         <h4>Phone Number: </h4> 
         </div>
         <div class="col-md-6">
         <h4>'.$row["phone_number"].'</h4>
         </div>
          </div>
          <hr>
                  <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Product Sell</h2>';

                   $seller = explode(",", $row["sellerOf"]);
        foreach($seller as $i =>$key) {
            $output .= '<h4>'.$seller[$i].' 
              ';
      }
        $output .= '</div>

      </div>

    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
</div>';
      // $output .=  '
      //    <div class="panel-body">
      //      <div class="row">
      //        <div class="col-md-12">
      //          <label for="f_name">Name</label>
      //          <p>'.$row['fname'].'
      //          '.$row['lname'].'</p>
      //          <label for="f_name">Seller Of</label>
      //          <p>'.$row['sellerOf'].'</p>
      //        </div>
      //      </div>
      //      <p><br/></p>
      //      <div class="row">
      //        <div class="col-md-12">
      //        &nbsp;<input style="float:right;" type="submit" name="index" value="Follow This User" class="btn btn-success btn-lg"/>&nbsp;<br />
      //        </div>
      //      </div>
            
      //    </div>';
    }
  }
}if($view_id == 2){
  $query = "SELECT * from products WHERE producer_id = $f_id";
    $run = mysqli_query($con,$query);
   $row_col = mysqli_num_rows($run);
   $query1 = "SELECT * from register WHERE user_id = $f_id";
    $run1 = mysqli_query($con,$query1);
  while($row = mysqli_fetch_array($run1)) {
    $name = $row['fname'] .' '. $row['lname'];
   $output .= '<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
  
    <!-- Left Column -->
    <div class="w3-third">
    
      <div class="w3-white w3-text-grey w3-card-4">
        <div class="w3-display-container">
          <img src="images/'.$row["profile_image"].'" style="width:100%" alt="Avatar">
          <div class="w3-display-bottomleft w3-container w3-text-black">
            <h2>'.$name.'</h2>
          </div>
        </div>
        <div class="w3-container">
          <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>'.$row["email"].'</p>
          <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>'.$row["phone_number"].'</p>
          <h4>You Followed This User</h4>
          <hr>
          <button class="w3-button w3-theme-d1 w3-margin-bottom view" id="1">View Profile</button><br>
          <button class="w3-button w3-theme-d1 w3-margin-bottom view" id="2">View Product</button>
        </div>
      </div><br>

    <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">
      <div class="w3-container w3-card w3-white">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Products</h2>
        <div class="w3-container">
          <p><br></p>';
      }
      if ($row_col > 0) {
   while($row1 = mysqli_fetch_array($run)) {
    $output.= '<div class="w3-half"><img src="images/'.$row1["prd_img"].'" alt="Avatar" class="w3-left w3-square w3-margin-right" style="width:100px;height:100px">
            <br><h4><b>'.$row1["prd_title"].'</b></h4></div>';
 }

    $output .= '</div><br>

    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
</div>';
}else{
    $output = '<h1>This User Dont have a Product';
   }
}
echo $output;
}if(isset($_POST['follow'])){
  $f_id = $_POST['f_id'];
   $insert = "insert into friend (user_id1,friend_id,accept,notify) values ('$id','$f_id','1','0')";
   
   $run = mysqli_query($con,$insert);
   
}
?>
