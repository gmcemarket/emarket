
<?php
session_start();
include("db.php");
$get = new Main;
if(isset($_SESSION["uid"])){
  header("location:http://localhost/ECommerce/user/profile.php");
}
$limit = 9;
$countSql = "SELECT COUNT(prd_id) FROM products";  
$tot_result = mysqli_query($con, $countSql);   
$row = mysqli_fetch_row($tot_result);  
$total_records = $row[0];  
$total_pages = ceil($total_records / $limit);

//for first time load data
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  
$sql = "SELECT * FROM products ORDER BY prd_id ASC LIMIT $start_from, $limit";  
$rs_result = mysqli_query($con, $sql); 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>E-Market</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/style123.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='http://fonts.googleapis.com/css?family=Amaranth:400,700' rel='stylesheet' type='text/css'>
    <link href="css/jquery.bxslider.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="js/jquery.js"></script>
    <link rel="stylesheet" href="dist/simplePagination.css" />
<script src="dist/jquery.simplePagination.js"></script>
<link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>
    <script type="text/javascript" src="js/datatables.min.js"></script>
    <style>
    #img-display {
    height:250px;
    width:100%;
}
  .row {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex; 
}
.row > [class*='col-'] {
   display: flex;
   flex-direction: column;
}.text-block {
  position: absolute;
  bottom: 160px;
  right: 1px;
  background: rgba(76, 175, 80, 0.6);
  color: black;
  padding-left: 20px;
  padding-right: 20px;
}.category_block li:hover {
    background-color: #007bff;
}
.category_block li:hover a {
    color: #ffffff;
}
.category_block li a {
    color: #343a40;
}.qty .input-group{
    width: 100%;
    height: 40px;
}
.btn-qty{
    width: 40px;
    height: 40px;
    color: #fff !important;
    background-color: #555 !important; 
    border-color: #555 !important;
    padding: 0px 3px !important;
}.product{
    width: 100%;
    height: 40px;
    color: #fff !important;
    background-color: #555 !important; 
    border-color: #555 !important;
    padding: 0px 3px !important;
    cursor: pointer;
}
.qty input{
    height: 40px;
}
    </style>
  </head>
<body>
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="profile.php">E-Commerce</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fa fa-ellipsis-v"></i>
    </button>
     <a class="navbar-brand mr-1" href="profile.php">Products</a>
    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
     
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item">
        <a class="nav-link" href="cart.php">
          <i class="fa fa-cart-plus"></i>
          <span class="badge badge-danger count"></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="message.php">
          <i class="fa fa-envelope fa-fw"></i>
          <span class="badge badge-danger count1"></span>
        </a>
      </li>
       <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle notif" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-bell fa-fw"></i>
          <span class="badge badge-danger count2"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
           <div id="dropdown2" style="width: 400px;height: 600px"></div>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link" href="signup.php"><span class=""></span>Sign Up</a>
      </li>
       <li class="nav-item dropdown no-arrow">
        <a class="nav-link" href="login.php"><span class=""></span>Log In</a>
      </li>
      
     <!--  <li class="nav-item">
        <a class="nav-link" href="myprofile.php">
          <span class="glyphicon glyphicon-user"></span><?php echo "Hi,".$_SESSION["name"];?>
        </a>
      </li> -->
    </ul>
<!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
           <div id="dropdown2" ></div>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div> -->
  </nav>
  <!-- <div class="navbar navbar-inverse navbar-fixed-top">
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
        <li><a href="profile.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
        <li><a href="profile.php"><span class="glyphicon glyphicon-modal-window"></span>Product</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
       <a href="cart.php"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-shopping-cart" style="font-size:18px;"></span></a>
      </li>
          <li>
       <a href="message.php"><span class="label label-pill label-danger count1" style="border-radius:10px;"></span> <span class="
glyphicon glyphicon-envelope" style="font-size:18px;"></span></a>
      </li>
      <li class="dropdown">
       <a href="#" class="dropdown-toggle notif" data-toggle="dropdown"><span class="label label-pill label-danger count2" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span></a>
       <ul class="dropdown-menu" id="dropdown2"></ul>
      </li>
          <li><a href="sell.php"><span class=""></span>Sell Your Item</a></li>
        <li><a href="dashboard.php"><span class="glyphicon glyphicon-user"></span><?php echo "Hi,".$_SESSION["name"];?></a>
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
  </div> -->
  <p><br/></p>
  <p><br/></p>
  <!--==========home-slider===------>
  <!-- <div id="slider">
  <ul class="bxslider">
    <li><img src="images/image1.jpg" height="450px" width="2000px"></li>
    <li><img src="images/image2.jpg" height="450px" width="2000px"></li>
    <li><img src="images/image3.jpg" height="450px" width="2000px"></li>
    <li><img src="images/image4.jpg" height="450px" width="2000px"></li>
  </ul> 
  </div> -->

  <!--=========category-boxes=============-->
  <!-- <div id="container">
  <div id="heading-block">
    <h2>Category</h2>
  </div> -->

  <!---1st Category-->
 <!--  <a href="#">
  <div class="catbox">
    <img src="images/image1.jpg" alt="Fruits" height="250px" width="250px">
    <span class='category' cid='0'>Fruits</span>
  </div>
  </a> -->

  <!---2nd Category-->
 <!--  <a href="#">
  <div class="catbox">
    <img src="images/image2.jpg" alt="Seafoods" height="250px" width="250px">
    <span>Seafoods</span>
  </div>
  </a> -->

  <!---3rd Category-->
  <!-- <a href="#">
  <div class="catbox">
    <img src="images/image3.jpg" alt="Vegetables" height="250px" width="250px">
    <span>Vegetables</span>
  </div>
  </a> -->

  <!---4th Category-->
  <!-- <a href="#">
  <div class="catbox">
    <img src="images/image4.jpg" alt="Meat" height="250px" width="250px">
    <span>Meat</span>
  </div>
  </a> -->


  <!---Heading of Category-->
  <!-- <div id="heading-block">
    <h2>Products</h2>
  </div>
  <div class="prod-container">
    <div class="col-md-8 col-xs-12">
       <div id="Product_List"></div>
     </div>
  </div>
<div id="heading-block">
    <h2>Most Order Products</h2>
  </div>
  <div class="prod-container">
    <div class="col-md-8 col-xs-12">
      <div id="Most_Order"></div>
    </div>
</div>
</div> -->
  <div class="container-fluid">
     <div class="row"><br><br>
         <div class="col-sm-6" style="left: 26%">
          <input type="hidden" id="search_cat" class="form-control" value="0" />
          <label>Search</label>
      <input type="text" name="search_text" id="search_text" placeholder="Search Product" class="form-control" style="width: 100%" />
    </div>
</div><br><br>
    <div class="row">
      <div class="col-md-0"></div>
      <div class="col-md-2">
        <div class="card bg-light mb-3">
                <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-list"></i> Categories</div>
                <ul class="list-group category_block">
                  <li class='list-group-item'><a href='#'style='color:black' class='category' cid = '0'>All Categories</a></li>
                  <?php
                        $category_query = "SELECT * FROM categories";
              $run_query = mysqli_query($con,$category_query) or die(mysqli_error($con));
              if(mysqli_num_rows($run_query) > 0){
                while($row = mysqli_fetch_array($run_query)){
                  $cid = $row["cat_id"];
                  $cat_name = $row["cat_title"];
                  echo "
                    <li class='list-group-item'><a href='#'style='color:black' class='category' cid='$cid'>$cat_name</a></li>
                  ";
                }
                echo "";
                }
          ?>
                </ul>
            </div>
      <div class="card bg-light mb-3">
                <div class="card-header bg-success text-white text-uppercase">Registered User</div>
                <table class="table table-bordered" id="registeredUser">
                    <thead>
                      <tr>
                        <th>Name</th>
                      </tr>
                    </thead>
                    <tbody>
                <?php
                $u_id = $_SESSION["uid"];
                        $category_query = "SELECT * FROM register";
              $run_query = mysqli_query($con,$category_query) or die(mysqli_error($con));
              if(mysqli_num_rows($run_query) > 0){
                while($row = mysqli_fetch_array($run_query)){
                  $cid = $row["cat_id"];
                  $cat_name = $row["cat_title"];
                  echo '
                    <tr>
                      <td><a href="viewprofile.php?user_id='.$row["user_id"].'">'.$row["fname"].' '.$row["lname"].'</a></td>
                    </tr>
                  ';
                }
                echo "";
                }
          ?>
        </tbody>
      </table>
            </div>
      </div>
      <div class="col-md-8">
          <div id="slider">
  <ul class="bxslider">
    <li><img src="images/image1.jpg" height="450px" width="2000px"></li>
    <li><img src="images/image2.jpg" height="450px" width="2000px"></li>
    <li><img src="images/image3.jpg" height="450px" width="2000px"></li>
    <li><img src="images/image4.jpg" height="450px" width="2000px"></li>
  </ul> 
  </div><h2>Products</h2>
          <br>
            <div id="Product_List">
            </div><br>
         <nav><ul class="pagination" style="margin-left: 500px">
    <?php if(!empty($total_pages)):for($i=1; $i<=$total_pages; $i++):  
                if($i == 1):?>
                <li class='active'  id="<?php echo $i;?>"><a href='fetch_user.php?page=<?php echo $i;?>'><?php echo $i;?></a></li> 
                <?php else:?>
                <li id="<?php echo $i;?>"><a href='fetch_user.php?page=<?php echo $i;?>'><?php echo $i;?></a></li>
            <?php endif;?>          
    <?php endfor;endif;?>
    </ul></nav>
      </div>
      <div class="col-md-2">
        <div class="card-header bg-success text-white text-uppercase">Most Ordered Products</div><br>
        <div class="sort-by">
                    Sort by:
                    <select id="displayTop">
                        <option value="Last Week">Last Week </option>
                        <option value="Last Month">Last Month </option>
                    </select>
                    <br><br>
                </div>
                <div id="Most_Order"></div>
            </div>
    </div>
  </div> 
 <script src="js/jquery.bxslider.min.js"></script>
 <script src="js/my.js"></script>
</body>
</html>
<script>
$(document).ready(function(){
  load_unseen_message();
 load_unseen_notification();
 load_cart();
 most_order('Last Week');
 //fetch_user();
load_data();
 setInterval(function(){
  update_last_activity(); 
  update_chat_history_data();
 }, 5000);
  $('#registeredUser').DataTable();
function load_data(page,query,cat_id1)
 {
  $.ajax({
   url:"fetch_user.php",
   method:"POST",
   data:{page:page,query:query,cat_id1:cat_id1},
   success:function(data)
   {
    $('#Product_List').html(data);
   }
  });
 }
 function most_order(type = '')
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{most_order: 1,type:type},
   success:function(data)
   {
    $('#Most_Order').html(data);
   }
  });
 }

 $('.pagination').pagination({
        items: <?php echo $total_records;?>,
        itemsOnPage: <?php echo $limit;?>,
        cssStyle: 'light-theme',
    currentPage : 1,
    onPageClick : function(pageNumber) {
      jQuery("#Product_List").html('loading...');
      jQuery("#Product_List").load("fetch_user.php?page=" + pageNumber);
    }
    });
 var cat_ID;
 $('.category').click(function() {
    var cat_id1 = $(this).attr('cid');
    var search = document.getElementById('search_text').value;
    document.getElementById("search_cat").value = cat_id1;
    if(search == '')
  {
   load_data(0,search,cat_id1);
  }else if(search != ''){
    load_data(0,search,cat_id1);
  }
  else
  {
   load_data();
  }
});
 $('#search_text').keyup(function(){
  var search = $(this).val();
  var cat_id1 = document.getElementById('search_cat').value;
  if(search == '')
  {
   load_data(0,search,cat_id1);
  }else if(search != '')
  {
   load_data(0,search,cat_id1);
  }
  else
  {
   load_data();
  }
 });
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
  //  $('#dropdown1').html(data.message);
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
      var quantity = parseInt($(this).attr("id"));
      var type = $(this).attr("name");
      var c_id = $(this).attr("c_id");
        if(type == 'plus'){
          quantity = quantity + 1;
        }else{
          quantity = quantity - 1;
        }
      $.ajax({
         url:"fetch.php",
         method:"POST",
         data:{update_cart:1,c_id:c_id,quantity:quantity},
         success:function(data){
          load_data();
         load_unseen_notification();
         load_cart();        
        }
       });
 });
 $(document).on('change', '#displayTop', function(){ 
   sellTop = $(this).val();
        most_order(sellTop);  
      });
 $(document).on('click', '#editProduct', function(){
      var p_id = parseInt($(this).attr("p_id"));
      window.open('details.php?pro_id='+p_id+'','_self');
 });

 $(document).on('click', '#addToCart', function(){
  var pro_id = parseInt($(this).attr("p_id"));
  var price = parseInt($(this).attr("price"));
  var quantity = 1;
    $.ajax({
         url:"fetch.php",
         method:"POST",
         data:{addToCart:1,pro_id:pro_id,pro_price:price,quantity:quantity},
         success:function(data){
          load_data();
         load_unseen_notification();
         load_cart();        
        }
       });
 });

 $(document).on('click', '.notif', function(){
  $('.count2').html('');
  load_unseen_notification('yes');
 });

 // $(document).on('click', '.dropdown-toggle', function(){
 //  $('.count1').html('');
 //  load_unseen_message('yes');
 // });
 
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

});
</script>














































