<?php require_once 'inc/connection.php' ?>
<?php require_once 'inc/header.php' ?>

    <!-- Page Content -->
    <div class="page-heading products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>View Post</h4>
              <h2>View personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>



    <?php 
    // Ceck ID 
    if ($_GET['id']) {
      $id = $_GET['id'];

      // Query Select One
      
      $query = "select users.name , posts.* from posts join users
      on
      users.id = posts.user_id
      where posts.id=$id" ;

      $runQuery = mysqli_query($conn,$query);
      if (mysqli_num_rows($runQuery) == 1) {
        $post = mysqli_fetch_assoc($runQuery);
      }else{
        $_SESSION['errors'] = "Post not Found" ;
        header("location:index.php") ;
      }
    }else{
      $_SESSION['errors'] = "Post not Found" ;
      header("location:index.php") ;
    }
 

    require_once 'inc/errors.php';
    require_once 'inc/success.php';
    ?>
    

    <div class="best-features about-features">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Our Post Image</h2>
            </div>
          </div>
          <div class="col-md-6">
            <div class="right-image">
              <img src="uploads/<?php echo $post['image'];?>" alt="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="left-content">
              <h4><?php echo $post['title'];?></h4>
              <p><?php echo $post['body'];?></p>
              <h6>Author :  <?php echo $post['name'];?></h6>

              <?php    if (isset($_SESSION['user_id'])) { ?>
              
              <div class="d-flex justify-content-center">
                  <a href="editPost.php?id=<?php echo $id ;?>" class="btn btn-success mr-3 "> Edit Post</a>

                  <form action="handel/deletePost.php?id=<?php echo $id ?>" method="post">

                    <button type="submit" name="submit" class="btn btn-danger" onclick="alert('Are You Sure')">Delete Post</button>

                  </form>

              </div>

            <?php } ?>
            </div>
          </div>
        </div>
      </div>
</div>

    <?php require_once 'inc/footer.php' ?>
