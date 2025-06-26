<header>
<?php 

include('includes/login.php');

?>

<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

  <nav id="navigation_bar" class="navbar navbar-default">
    <div class="container mt-10" style="display:block">
      <div class="navbar-header">
        <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a href="index.php"><h1 class="white-text font-semibold text-4xl">InggitMalaysia</h1></a>
      </div>
      <div class="header_wrap">
        <div class="user_login">
          <ul class="flex">
          <?php if($_SESSION['login']){?>
            <li class="heart-icon">
              <a href="my-wishlist.php" aria-haspopup="true" aria-expanded="false" class="user_icon">
                <i class="fa fa-heart-o text-4xl hover:text-red-500" aria-hidden="true"></i>
              </a>
            </li>
            <?php } else { ?>
                <li><a href="#loginform" class="login_btn" data-toggle="modal" data-dismiss="modal"> <i class="fa fa-heart-o text-4xl hover:text-red-500" aria-hidden="true"></i></a></li>
                <?php } ?>
            <li class="dropdown border-0" style="z-index:10;">
              <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="user_icon">
                <i class="fa fa-user-circle text-4xl hover:text-blue-500" aria-hidden="true"></i>
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" >
                <?php if($_SESSION['login']){?>
                <li><a href="profile.php">Profile Settings</a></li>
                <li><a href="logout.php">Sign Out</a></li>
                <?php } else { ?>
                <li ><a href="#loginform" class="login_btn" data-toggle="modal" data-dismiss="modal">Login / Register</a></li>
                <?php } ?>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">
          <li><?php   if(strlen($_SESSION['login'])==0)
	{	
?>
<?php }
else{ 

 } ?></li>
    </div>
  </nav>
</header>