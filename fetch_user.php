	<?php

//fetch_user.php

include('db.php');
$get = new Main;
session_start();
$id = $_SESSION['uid'];
$record_per_page = 20;  
 $page = '';  
 $output = '';
if(isset($_POST["query"]))
{
$limit = 9;
  if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;   
  $cat_id1 = $_POST['cat_id1'];
 $search = mysqli_real_escape_string($con, $_POST["query"]);
 $cat = $_POST['cat'];
 if($cat_id1== 0){
  $query = "
  SELECT * FROM products,register,categories 
  WHERE prd_title LIKE '%".$search."%' 
  AND user_id = producer_id AND prd_cat = cat_id ORDER BY prd_id DESC LIMIT $start_from, $limit";
 }else if($search == ''){
  $query = "
  SELECT * FROM products,register,categories  
  WHERE prd_cat = ".$cat_id1."
  AND user_id = producer_id AND prd_cat = cat_id ORDER BY prd_id DESC LIMIT $start_from, $limit
 ";
 }else{
 $query = "
  SELECT * FROM products,register,categories  
  WHERE prd_title LIKE '%".$search."%' 
  AND prd_cat = ".$cat_id1."
  AND user_id = producer_id AND prd_cat = cat_id ORDER BY prd_id DESC LIMIT $start_from, $limit
 ";
  }
  $result = mysqli_query($con, $query);
  
$query1 = "
 SELECT * FROM cart WHERE status = 0";
$result1 = mysqli_query($con, $query1);
while($row1 = mysqli_fetch_array($result1)){
if($row1['user_id2'] == $id){
$data[] = $row1;
sksort($data,"prd_id2");
  }
}
if(mysqli_num_rows($result) > 0)
{ 
  $output = '<div class="container">
    <div class="row">';
  $i = 0;
  $j = 0;
  $a = 0;
 while($row = mysqli_fetch_assoc($result))
 {
  $time_ago = $row['status_time'];
  $image = $row['prd_img'];
  $product = explode(",", $image);
  if($data[$i][2] == $row['prd_id']){
   if($data[$i][4] == 1){
    if($row['prd_quantity'] <= 5){
      $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'"><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
                          <small style="color:red"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>';
            $i++;
    }else if($row['prd_quantity'] <= 10){ 
    $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'"><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
                          <small style="color:GoldenRod"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>'; 
            $i++;
          }else{
             $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
           <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'"><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
          </div>
              </div>
      </div>';
            $i++;
          }
  }else if($row['prd_quantity'] == $data[$i][4]){
          if($row['prd_quantity'] <= 5){
            $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
                           <small style="color:red"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>';
            $i++;
    }else if($row['prd_quantity'] <= 10){  
      $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
                           <small style="color:GoldenRod"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>';
            $i++;
          }else{
            $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
           <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
          </div>
              </div>
      </div>';
            $i++;
          }
      }else{
    if($row['prd_quantity'] <= 5){
      $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
           <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'" ><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
                          <small style="color:red"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>';
            $i++;
    }else if($row['prd_quantity'] <= 10){  
       $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
           <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'"><i class="fa fa-plus"></i></button>
                              
                            </div>
                          </div>
                           <small style="color:GoldenRod"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>';
            $i++;
          }else{
             $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'"><i class="fa fa-plus"></i></button>
                              
                            </div>
                          </div>
          </div>
              </div>
      </div>';
            $i++;
          }
  }
     }else{
        if($row['producer_id'] == $id){
          $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          
          <button type="submit" id="editProduct" p_id="'.$row["prd_id"].'" class="product">Edit Product</button>
              </div>
      </div>';
        }else{
          $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem">
          <button type="submit" id="addToCart" p_id="'.$row["prd_id"].'" price="'.$row["prd_price"].'" class="product">Add to Cart</button>
          </div>
              </div>
      </div>';
        }
        $j++;
     }
     $a++;
     if($a % 4 == 0)  {
            $output .="<div class='col-md-12' style='color: rgba(0, 0, 0, 0);'>a</div>";

          }
 }
 
 $output .= '</div></div>';
echo $output;
}else{
  echo 'Data Not Found';
}
}else
{
  $limit = 9;
  if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  
 $query = "
 SELECT * FROM products,register,categories WHERE user_id = producer_id AND prd_cat = cat_id ORDER BY prd_id DESC LIMIT $start_from, $limit";
$result = mysqli_query($con, $query);
 $query1 = "
 SELECT * FROM cart WHERE status = 0";
$result1 = mysqli_query($con, $query1);
while($row1 = mysqli_fetch_array($result1)){
if($row1['user_id2'] == $id){
$data[] = $row1;
sksort($data,"prd_id2");
  }
}
$a = 0;
$output .= "<div class='container'><div class='row'>";
if(mysqli_num_rows($result) > 0)
{ 
  $i = 0;
  $j = 0;
  $a = 0;
 while($row = mysqli_fetch_assoc($result))
 {
  $time_ago = $row['status_time'];
  $image = $row['prd_img'];
  $product = explode(",", $image);
  if($data[$i][2] == $row['prd_id']){
   if($data[$i][4] == 1){
    if($row['prd_quantity'] <= 5){
      $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'"><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
                          <small style="color:red"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>';
            $i++;
    }else if($row['prd_quantity'] <= 10){ 
    $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'"><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
                          <small style="color:GoldenRod"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>'; 
            $i++;
          }else{
             $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
           <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'"><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
          </div>
              </div>
      </div>';
            $i++;
          }
  }else if($row['prd_quantity'] == $data[$i][4]){
          if($row['prd_quantity'] <= 5){
            $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
                           <small style="color:red"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>';
            $i++;
    }else if($row['prd_quantity'] <= 10){  
      $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
                           <small style="color:GoldenRod"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>';
            $i++;
          }else{
            $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
           <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'" disabled><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
          </div>
              </div>
      </div>';
            $i++;
          }
      }else{
    if($row['prd_quantity'] <= 5){
      $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
           <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'" ><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
                          <small style="color:red"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>';
            $i++;
    }else if($row['prd_quantity'] <= 10){  
       $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
           <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'"><i class="fa fa-plus"></i></button>
                              
                            </div>
                          </div>
                           <small style="color:GoldenRod"> only '.$row["prd_quantity"].' item in stock </small>
          </div>
              </div>
      </div>';
            $i++;
          }else{
             $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem qty">
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="minus" c_id="'.$data[$i][0].'" ><i class="fa fa-minus"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center" id="" aria-describedby="" value="'.$data[$i][4].' in cart" readonly>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-sm btn-qty button1" id="'.$data[$i][4].'" name="plus" c_id="'.$data[$i][0].'"><i class="fa fa-plus"></i></button>
                              
                            </div>
                          </div>
          </div>
              </div>
      </div>';
            $i++;
          }
  }
     }else{
        if($row['producer_id'] == $id){
          $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          
          <button type="submit" id="editProduct" p_id="'.$row["prd_id"].'" class="product">Edit Product</button>
              </div>
      </div>';
        }else{
          $output .= '<div class="col-md-3">
        <div class="card"> <a href="details.php?pro_id='.$row['prd_id'].'"><img src="images/'.$product[0].'" id="img-display"></a>
                <div class="card-body">
            <div class="news-title">
                    <h2 class=" title-small">'.$row['prd_title'].'</h2>
                    <h4 class="text-block">P'.$row['prd_price'].'</h4> 
                  </div>
          </div>
          <div class="grid_1 simpleCart_shelfItem">
          <button type="submit" id="addToCart" p_id="'.$row["prd_id"].'" price="'.$row["prd_price"].'" class="product">Add to Cart</button>
          </div>
              </div>
      </div>';
        }
        $j++;
     }
     $a++;
     if($a % 4 == 0)  {
            $output .="<div class='col-md-12' style='color: rgba(0, 0, 0, 0);'>a</div>";

          }
     
 }
 //$output .= "</div></div><nav><ul class='pagination'>";

  //    if(!empty($total_pages)){
  //     for($i=1; $i<=$total_pages; $i++){ 
  //               if($i == 1){
  //             $output .=  '<li class="active"  id="'.$i.'"><a href="fetch_user.php?page='.$i.'">'.$i.'></a></li> ';
  //               } else {
  //                  $output .=  '<li id="'.$i.'"><a href="fetch_user.php?page='.$i.'">'.$i.'></a></li> ';
  //             }
  //           }        
  //   }
  // $output .= '</ul></nav>';
echo $output;
}
else
{
 echo 'Data Not Found';
}
}
function sksort(&$array, $subkey="id", $sort_ascending=false) {

    if (count($array))
        $temp_array[key($array)] = array_shift($array);

    foreach($array as $key => $val){
        $offset = 0;
        $found = false;
        foreach($temp_array as $tmp_key => $tmp_val)
        {
            if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey]))
            {
                $temp_array = array_merge(    (array)array_slice($temp_array,0,$offset),
                                            array($key => $val),
                                            array_slice($temp_array,$offset)
                                          );
                $found = true;
            }
            $offset++;
        }
        if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
    }

    if ($sort_ascending) $array = array_reverse($temp_array);

    else $array = $temp_array;
}
?>