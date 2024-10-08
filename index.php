
<?php require_once 'inc/connection.php' ?>
<?php require_once 'inc/header.php' ?>
    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="banner header-text">
      <div class="owl-banner owl-carousel">
        <div class="banner-item-01">
          <div class="text-content">
            <!-- <h4>Best Offer</h4> -->
            <!-- <h2>New Arrivals On Sale</h2> -->
          </div>
        </div>
        <div class="banner-item-02">
          <div class="text-content">
            <!-- <h4>Flash Deals</h4> -->
            <!-- <h2>Get your best products</h2> -->
          </div>
        </div>
        <div class="banner-item-03">
          <div class="text-content">
            <!-- <h4>Last Minute</h4> -->
            <!-- <h2>Grab last minute deals</h2> -->
          </div>
        </div>
      </div>
    </div>
    <!-- Banner Ends Here -->

<?php 


//  Pagenation - Check page in URL


if (isset($_GET['page'])) {
  $page = $_GET['page'];  
}else{
  $page = 1;
}
$limit = 3;
$offset = ($page-1) * $limit;
// number of pages = total / 3 = 2 
// IF Condition >> Page Of Number

$sql = "select count(id) as total from posts ";
$runQuery = mysqli_query($conn, $sql);
if (mysqli_num_rows($runQuery) == 1 ) {
  $total = mysqli_fetch_assoc( $runQuery )["total"];
}

$numberOfPages = ceil( $total/ $limit);

if ($page< 1) {
  header("location:".$_SERVER['PHP_SELF']."?page=1");
}elseif($page>$numberOfPages ){
  header("location:".$_SERVER['PHP_SELF']."?page=$numberOfPages");
}

// Query Select All 

$query = "select id , title , substring(body,1,100) as body,  image , created_at from `posts` order by id limit $limit offset $offset";
$runQuery = mysqli_query($conn,$query);
if (mysqli_num_rows($runQuery)>0) {
  $posts = mysqli_fetch_all($runQuery,MYSQLI_ASSOC);
}else{
  $msg = "No Data Founded" ;
}

?>



    <div class="latest-products">
      <div class="container">

      <?php require_once 'inc/success.php'  ;
      require_once 'inc/errors.php';
      ?>



        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Latest Posts</h2>
              <!-- <a href="products.html">view all products <i class="fa fa-angle-right"></i></a> -->
            </div>
          </div>


          <?php 
          
          // Check And Loop
          
          if(!empty($posts)) :
          foreach($posts as $post) :


            ?>

          <div class="col-md-4">
            <div class="product-item">
              <a href="#"><img src="uploads/<?php echo $post['image'] ?>" alt=""></a>
              <div class="down-content">
                <a href="#"><h4><?php echo $post['title'] ?></h4></a>
                <h6><?php echo $post['created_at'] ?></h6>
                <p> <?php echo $post['body'] . "..." ?></p>
                <div class="d-flex justify-content-end">
                  <a href="viewPost.php?id=<?php echo $post['id'] ?>" class="btn btn-info "> view</a>
                </div>
              </div>
            </div>
          </div>


          <?php endforeach; else : echo $msg ; endif ;?>

        </div>
      </div>
    </div>


    <div class="container d-flex justify-content-center">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item <?php if($page == 1) echo "disabled" ;?>"><a  href="<?php echo $_SERVER['PHP_SELF']."?page=" . $page-1?>" class="page-link " ><<</a></li>
          <li class="page-item"><a class="page-link" ><?php echo $page . ' of '. $numberOfPages ;?></a></li>
          <li class="page-item <?php if($page == $numberOfPages) echo "disabled" ;?>"><a href="<?php echo $_SERVER['PHP_SELF']."?page=" . $page+1?>" class="page-link" >>></a></li>
        </ul>
      </nav>
    </div>
 
    
<?php require_once 'inc/footer.php' ?>
