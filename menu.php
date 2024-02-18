<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
      <!-- CSS only -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">

      <!-- JavaScript Bundle with Popper -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>
      
      <!--Google Font-->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Volkhov:wght@700&display=swap" rel="stylesheet">
      
      <link href="style.css" rel="stylesheet" type="text/css">

      <title>Menu</title>
    </head>
    <body>
        <!--Navigation Bar: Referenced from GetBootstrap.com-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" class="navigationBar"> <!--Color of NavBar and calling navbar class in bootstrap-->
            <div class="container">
              <a class="navbar-brand" href="#">ISpeedFood</a> <!--The Header of the Navbar-->
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <!--Dropdown button of the ul's when display screen is at a certain size-->
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
              	<!--Links in the Navigation Bar-->
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="home.html">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="home.html#aboutUs">About Us</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="menu.php">Menu</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="order.php">Order</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="contactUs.html">Contact Us</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>

        <!--Title and Image-->
        <div class="beginning">
            <h1 class="header">Menu</h1>
        </div>
        
        <!--Menu List-->
        <div id="menu">

          <?php 
             $itemList = fopen("itemList.txt", "r"); 
            
             // Displaying each image
             while(!feof($itemList)) {
              $option = explode(",", fgets($itemList));
              echo
          '<!--' . $option[1] . '-->
          <figure>
            <img src="images/' .$option[0] . '.jpg" alt="' . $option[1] . '" width="500" class="menuImages">
            <figcaption class="caption">
              <p>
                <mark class="highlight caption">' . 
                  $option[1] . '-' . $option[2] . 
                '</mark>
              </p>
            </figcaption>
          </figure> <br/>' . "\n\n";
              if(!feof($itemList)){
                echo "          ";
              }
             }
             fclose($itemList);
          ?>
        </div>     
    </body>
</html>
