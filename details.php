<?php
session_start();
include("db.php");
// if(!isset($_SESSION["uid"])){
// 	header("location:index.php");
// }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>E-Market</title>
		<link rel="stylesheet" href="css/style.css"/>
		<script type="text/javascript" src="js/jquery.js"></script>
		  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/bootstrap.min.js"></script>
		<script src="main.js"></script>
		<style>
			@media screen and (max-width:480px){
				#search{width:80%;}
				#search_btn{width:30%;float:right;margin-top:-32px;margin-right:10px;}
			}
      .button2 {
         background-color: #FF7F50;
  border: none;
  color: white;
  padding: 10px;
  width: 100%;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  cursor: pointer;
        border-radius: 12px;
      }
      .button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 4px 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  cursor: pointer;
  width: 30px;
}
.button1 {
  background-color: white;
  color: black;
  border: 2px solid #555555;
}

.button1:hover {
  background-color: #555555;
  color: white;
}
		</style>
	</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">	
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
					<span class="sr-only"> navigation toggle</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="#" class="navbar-brand">E-Market</a>
			</div>
		<div class="collapse navbar-collapse" id="collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
				<li><a href="index.php"><span class="glyphicon glyphicon-modal-window"></span>Product</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
       <a href="cart.php"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-shopping-cart" style="font-size:18px;"></span></a>
      </li>
					<li class="dropdown">
       <a href="message.php"><span class="label label-pill label-danger count1" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-envelope" style="font-size:18px;"></span></a>
      </li>
      <li class="dropdown">
       <a href="#" class="dropdown-toggle notif" data-toggle="dropdown"><span class="label label-pill label-danger count2" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span></a>
       <ul class="dropdown-menu" id="dropdown2"></ul>
      </li>
					<li><a href="#" data-toggle="modal" data-target="#myModal"><span class=""></span>Sell Your Item</a>
				<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span><?php echo "Hi,".$_SESSION["name"];?></a>
					<ul class="dropdown-menu">
						<li><a href="myprofile.php" style="text-decoration:none; color:blue;">View Profile</a></li>
						<li class="divider"></li>
						<li><a href="" style="text-decoration:none; color:blue;">Chnage Password</a></li>
						<li class="divider"></li>
						<li><a href="logout.php" style="text-decoration:none; color:blue;">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	</div>
	<p><br/></p>
	<p><br/></p>
	<p><br/></p>
	<div class="container">
						<?php  
							if(isset($_GET['pro_id'])){

		$prod_id = $_GET['pro_id']; 
 
    $get_pro = "select * from products,register where prd_id = '$prod_id' AND user_id = producer_id";
    $run_pro = mysqli_query($con,$get_pro);
 
$u_id = $_SESSION['uid'];

    while($row_pro = mysqli_fetch_array($run_pro)){
    	$producer_id = $row_pro['producer_id'];
        $product_id = $row_pro['prd_id'];
        $product_description = $row_pro['prd_desc'];
        $product_title = $row_pro['prd_title']; 
        $product_price = $row_pro['prd_price'];
        $product_image = $row_pro['prd_img'];
        $product_quantity = $row_pro['prd_quantity'];
        $phone_number = $row_pro['phone_number'];
        $fname = $row_pro['fname'];
          $user_ID = $row_pro['user_id'];
          $image = $row_pro['profile_image'];
        if($u_id == $producer_id){
        	$output = '<div class="row">				     
		<div class="col-sm-6">
							<div class="panel panel-info">
								<div class="panel-body">
								 <img src="images/'.$product_image.'" style="width:400px; height:270px;"/> 
								</div>
							</div>
						</div>

						<div class="col-sm-4">
								<h1>'.$product_title.'</h1>
								<h4><b>P'.$product_price.'</b></h4>
								<hr>
								<div class="post-left-box">
								<div class="id-img-box"><img src="images/'.$image.'"></div>	<div class="id-name">
                          				<ul>
                         				 <li><a href="viewprofile.php?user_id='.$user_ID.'">'.$fname.'</a></li>
                         				 </ul>
                        			</div>
                        			<br><br>
                        			<button type="submit" name="edit" id="'.$product_id.'" class="btn btn-success edit_data" style="width: 40%; margin-top: 1%">Edit</button>
                        			<button type="submit" name="insert" class="btn btn-success" style="width: 40%; margin-top: 1%">Delete</button>
                        		</div>
                        		<br>
                        		
							</div>
						</div><br><br>
				<div class="row">
					<div class="col-sm-2">
						<h4><b>Description</b></h4>
					</div>
					<div class="col-sm-4">
					<h4>'.$product_description.'</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<hr>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<h4><b>Seller Details</b></h4>
            <div class="post-left-box">
                <div class="id-img-box"><img src="images/'.$image.'"></img></div> <div class="id-name">
                                  <ul>
                                 <li><a href="viewprofile.php?user_id='.$user_ID.'">'.$fname.'</a></li>
                                 </ul>
                              </div>
                              </div>
					</div>
				</div>
		</div>
	<div id="user_model_details"></div>';
        }else{
        	$output = '<div class="row">				     
		<div class="col-sm-6">
							<div class="panel panel-info">
								<div class="panel-body">
								 <img src="images/'.$product_image.'" style="width:400px; height:270px;"/> 
								</div>
							</div>
							<label class="control-label col-sm-2" for="email">Quantity:</label><button class="button button1" name="minus">-</button><label id="value">1</label><button class="button button1" name="plus">+</button>
              <form method="POST" action="">
               <div class="form-group">
  </div><br>
  <input type="hidden" id="value1" name="quantity" value="0" />
  <input type="hidden" name="pro_id" value="'.$product_id.'" />
  <input type="hidden" name="pro_price" value="'.$product_price.'" />
  <button type="submit" name="addToCart" class="button2">Add to Cart</button>
  </form>
						</div>

						<div class="col-sm-4">
								<h1>'.$product_title.'</h1>
								<h4><b>P'.$product_price.' </b></h4>
								<hr>
								<div class="post-left-box">
								<div class="id-img-box"><img src="images/'.$image.'"></img></div>	<div class="id-name">
                          				<ul>
                         				 <li><a href="viewprofile.php?user_id='.$user_ID.'">'.$fname.'</a></li>
                         				 </ul>
                        			</div>
                        		</div>
                        		<br>
                        		<form method="POST" action="insert_chat.php">
                        		<small><center>Send a Message to the Seller </center></small>
								<textarea name= "chat_message"rows="4" cols="60"></textarea>
								<input type="hidden" name="to_user_id" value="'.$producer_id.'" />
								<input type="hidden" name="pro_id" value="'.$product_id.'" />
								<button type="submit" name="insert" class="btn btn-success" style="width: 122%; margin-top: 1%">Send Message</button>
								</form>
							</div>
						</div><br><br>
				<div class="row">
					<div class="col-sm-2">
						<h4><b>Description</b></h4>
					</div>
					<div class="col-sm-4">
					<h4>'.$product_description.'</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<hr>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<h4><b>Seller Details</b></h4>
					</div>
          <div class="col-sm-4">
          <div class="post-left-box">
                <div class="id-img-box"><img src="images/'.$image.'"></img></div> <div class="id-name">
                                  <ul>
                                 <li><a href="viewprofile.php?user_id='.$user_ID.'">'.$fname.'</a></li>
                                 </ul>
                              </div>
                              </div><br>
             Phone Number: '.$phone_number.' <br>
             <a href="products.php?user_id='.$user_ID.'">View More Products For This User</a>
          </div>
				</div>
		</div>
	<div id="user_model_details"></div>';
        }
}
	echo $output;
}
					     ?>

 <div id="add_data_Modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Product Details</h4>  
                </div>  
                <div class="modal-body">  
                     <form method="post" action="">  
                          <label>Product Name</label>  
                          <input type="text" name="prd_name" id="prd_name" class="form-control" />  
                          <br />  
                          <label>Product Category</label>  
                          <textarea name="prd_cat" id="prd_cat" class="form-control"></textarea>  
                          <br />  
                          <label>Product Description</label>
                          <input type="text" name="prd_desc" id="prd_desc" class="form-control" />  
                          <br />  
                          <label>Product Price</label>  
                          <input type="text" name="prd_price" id="prd_price" class="form-control" />  
                          <br />  
                          <label>Product Quantity</label>  
                          <input type="text" name="prd_quantity" id="prd_quantity" class="form-control" />  
                          <br />  
                          <input type="hidden" name="prd_id" id="prd_id" />  
                          <input type="submit" name="update_prd" id="insert" value="Insert" class="btn btn-success" />  
                     </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>  
	<form action="" method="POST" enctype="multipart/form-data">
	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
		<div class="row">
							<div class="col-md-12">
								<label for="password">Product Image</label>
								<input type="file" class="form-control" name="product_image" required />
							</div>
		 </div>
          <div class="row">
							<div class="col-md-12">
								<label for="f_name">Product Title</label>
								<input type="text" class="form-control" name="product_title" required />
							</div>
		  </div> 
		 <div class="row">
							<div class="col-md-12">
								<label for="f_name">Product Category</label>
								<select name="product_cat" required class="form-control">
									<option>-Select One-</option>
           
           
           <?php
           
          
     $id = $_SESSION['uid'];
	$get_cats = "select * from register,categories where user_id ='$id'";
	$run_cats = mysqli_query($con,$get_cats);

	while($row_cats=mysqli_fetch_array($run_cats)){
	$name = $row_cats['sellerOf'];
    $product = explode(",", $name);
    $length = count($product.length);
    for($i = 0; $i <= $length; $i++){
    	if($product[$i] == $row_cats['cat_title']){
     echo "<option value=".$row_cats['cat_id'].">".$row_cats['cat_title']."</option>";
     }  
 }
    

     }    
           ?>
								</select>
							</div>
		  </div> 
		   <div class="row">
							<div class="col-md-12">
								<label for="f_name">Product Description</label>
								<textarea type="text" class="form-control" name="product_desc" required ></textarea>
							</div>
		  </div> 
		  <div class="row">
							<div class="col-md-12">
								<label for="f_name">Product Quantity</label>
								<input type="text" class="form-control" name="product_quantity" required />
							</div>
		  </div>
		  <div class="row">
							<div class="col-md-12">
								<label for="f_name">Product Price</label>
								<input type="text" class="form-control" name="product_price" required />
							</div>
		  </div>
        </div>
        <div class="modal-footer">
          <input type="submit"name="add" value="INSERT"/>
        </div>
      </div>
      
    </div>
  </div>
  </form>
</body>
</html>
<script>
$(document).ready(function(){
  load_unseen_message();
 load_unseen_notification();
 load_cart();
 fetch_user();

 setInterval(function(){
  update_last_activity();
  update_chat_history_data();
 }, 5000);

 function fetch_user()
 {
  $.ajax({
   url:"fetch_user.php",
   method:"POST",
   success:function(data){
    $('#user_details').html(data);
   }
  })
 }
 function load_cart(cart = '')
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{cart:cart},
   dataType:"json",
   success:function(data)
   {
    if(data.cart > 0)
    {
     $('.count').html(data.cart);
    }
   }
  });
 }

 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    $('#dropdown2').html(data.notification);
    if(data.unseen_notification > 0)
    {
     $('.count2').html(data.unseen_notification);
    }
   }
  });
 }

 function load_unseen_message(message = '')
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{message:message},
   dataType:"json",
   success:function(data)
   {
    if(data.unseen_message > 0)
    {
     $('.count1').html(data.unseen_message);
    }
   }
  });
 }
 
 load_unseen_notification();
 load_unseen_message();

 $(document).on('click', '.button1', function(){
  		var quantity = parseInt(document.getElementById("value").textContent);
  		var type = $(this).attr("name");
  			if(type == 'plus'){
  				quantity = quantity + 1;
  				document.getElementById("value").innerHTML = quantity;
  				document.getElementById("value1").value = quantity;
  			}else{
  				quantity = quantity - 1;
  				document.getElementById("value").innerHTML = quantity;
  				document.getElementById("value1").value = quantity;
  			}
 });
 $(document).on('click', '.notif', function(){
  $('.count2').html('');
  load_unseen_notification('yes');
 });

 $(document).on('click', '.dropdown-toggle', function(){
  $('.count1').html('');
  load_unseen_message('yes');
 });
 
 $(document).on('click', '.view_data', function(){
  //$('#dataModal').modal();
  var employee_id = $(this).attr("id");
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{employee_id:employee_id},
   success:function(data){
    $('#u_name').html(data);
    $('#myModal2').modal('show');
   }
  });
 });
 $(document).on('click', '.edit_data', function(){  
           var product_details = $(this).attr("id");  
           $.ajax({  
                url:"fetch.php",  
                method:"POST",  
                data:{product_details:product_details},  
                dataType:"json",  
                success:function(data){  
                     $('#prd_name').val(data.prd_title);  
                     $('#prd_cat').val(data.prd_cat);  
                     $('#prd_desc').val(data.prd_desc);  
                     $('#prd_price').val(data.prd_price);  
                     $('#prd_quantity').val(data.prd_quantity);  
                     $('#prd_id').val(data.prd_id);  
                     $('#insert').val("Update");  
                     $('#add_data_Modal').modal('show');  
                }  
           });  
      }); 

});
</script>
<?php
if(isset($_POST['add'])){

    //getting text data
   $pid = $_SESSION["uid"];
   $product_id =  $_GET["pro_id"];
   $product_title = $_POST['product_title'];
   $product_cat = $_POST['product_cat'];
   $product_price = $_POST['product_price'];
   $product_desc = $_POST['product_desc'];
   $product_quantity = $_POST['product_quantity'];
   
    //getting image data
    $product_image = $_FILES['product_image']['name'];
   $product_image_tmp = $_FILES['product_image']['tmp_name'];
   
   move_uploaded_file($product_image_tmp,"images/$product_image");
   
   $insert_product = "insert into products (producer_id,prd_cat,prd_title,prd_price,prd_desc,prd_img,prd_quantity,status_time) values ('$pid','$product_cat','$product_title','$product_price','$product_desc','$product_image','$product_quantity',CURRENT_TIMESTAMP)";
   
   $run_product = mysqli_query($con,$insert_product);
   
   if($run_product){
   
   echo"<script>alert('Product Has been inserted')</script>";
   echo"<script>window.open('details.php?pro_id=$product_id','_self')</script>";
   }


}

if(isset($_POST['addToCart'])){
  $u_id = $_SESSION['uid'];
  $product_id =  $_GET["pro_id"];
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
	if(isset($_POST["search1"])){
		$keyword = $_POST["search"];
		$sql = "SELECT * FROM products WHERE prd_title LIKE '%$keyword%'";
	
	$run_query = mysqli_query($con,$sql);
	while($row=mysqli_fetch_array($run_query)){
			$pro_id    = $row['prd_id'];
			$pro_cat   = $row['prd_cat'];
			$pro_title = $row['prd_title'];
			$pro_price = $row['prd_price'];
			$pro_image = $row['prd_img'];
			echo "
				<div class='col-md-4'>
							<div class='panel panel-info'>
								<div class='panel-heading'>$pro_title</div>
								<div class='panel-body'>
									<a href='detailsBuyer.php?pro_id=$pro_id'><img src='product_images/$pro_image' style='width:160px; height:250px;'/></a>
								</div>
								<div class='panel-heading'>P$pro_price.00
								</div>
							</div>
						</div>	
			";
		}
	}

	if(isset($_POST["update_prd"])){
		 $product_id =  $_POST['prd_id'];
   $product_title = $_POST['prd_name'];
   $product_price = $_POST['prd_price'];
   $product_desc = $_POST['prd_desc'];
   $product_quantity = $_POST['prd_quantity'];
   	$query = "UPDATE products SET prd_title = '$product_title', prd_desc = '$product_desc', prd_price = '$product_price', prd_quantity = '$product_quantity' WHERE prd_id = '$product_id'";
   	$result = mysqli_query($con,$query);
   	if($result){
		 echo"<script>alert('Product Has been Updated')</script>";
		 echo"<script>window.open('details.php?pro_id=$product_id','_self')</script>";
		}
	}
?>













































