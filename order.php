<?php

  //If Form is Submitted
  if(isset($_POST['submit'])){

    //Form Variables
    $name = $_POST['name'];
    $email = $_POST['emailAddress'];
    $phone = $_POST['phoneNumber'];
    $food = $_POST['foodType'];
    $quantity = $_POST['quantity'];
    $notes = $_POST['notes'];
    $time = $_POST['pickupTime'];

    //Add Order
    $append = $name . "," . $email . "," . $phone . "," . $food . "," . $quantity . "," . $notes . "," . $time . "\n";
    date_default_timezone_set('America/New_York');
    $target_txt = "orders/" . date("d") . ".txt";
    $html = "";
    $tab = "                ";

    //HTML Order
    $brokenAppend = explode(",", rtrim($append, "\n"));
    $htmlAppend = $tab . "<tr>\nATTRIBUTES" . $tab . "</tr>\n";
    $attributes = "";
    foreach($brokenAppend as $attribute){
      $attributes .= $tab . "    <td>" . $attribute . "</td>\n";
    }
    $htmlAppend = str_replace("ATTRIBUTES", $attributes, $htmlAppend);

    //Make A New Order File For A New Day
    if(!file_exists(($target_txt))){

      $orders = fopen($target_txt, "w");
      fwrite($orders, $append);
      fclose($orders);
      $html .= $htmlAppend;
    }
    else{
      $orderFile = fopen($target_txt, "r");
      $orders = fread($orderFile, filesize($target_txt));
      fclose($orderFile);
      
      //Write New Order
      $orderFile = fopen($target_txt, "w");
      
      //Compare Times
      function compareTime($timeX, $timeY) {
        $timeX = intval(substr($timeX, 0, 2)) * 100 + intval(substr($timeX, 3));
        $timeY = intval(substr($timeY, 0, 2)) * 100 + intval(substr($timeY, 3));
        return $timeX < $timeY;
      }

      $wrote = false;
      $ordersList = explode("\n", $orders);
      
      //Loop Through Orders
      foreach ($ordersList as $order) {
        if ($order === '') {
          if(!$wrote){
            fwrite($orderFile, $append);
            $html .= $htmlAppend;
          }
          fclose($orderFile);
          break;
        }

        //Store Order Before Breaking Into Array
        $preOrder = $order . "\n";
        
        $order = explode(",", $order);

        //Make HTML Tag
        $htmlOrder = $tab . "<tr>\nATTRIBUTES" . $tab . "</tr>\n";
        $attributes = "";
        foreach($order as $attribute){
          $attributes .= $tab . "    <td>" . $attribute . "</td>\n";
        }
        $currTime = $order[count($order) - 1];

        //If Order Time Is Less, Then Add the Order
        if(!$wrote && compareTime($time, $currTime)) {
          fwrite($orderFile, $append);
          $html .= $htmlAppend;
          $wrote = true;
        }

        //Add the Order
        fwrite($orderFile, $preOrder); 
        $html .=  str_replace("ATTRIBUTES", $attributes, $htmlOrder);
      }
    }

    //Remove Last Skip Line(To make code look nicer)
    $html = rtrim($html, "\n");

    //Read HTML Template And Add New Orders
    $orderHTML = fopen("orders.txt", "r");
    $htmlContent = fread($orderHTML, filesize("orders.txt"));
    fclose($orderHTML);
    $htmlContent = str_replace("REPLACE", $html, $htmlContent);

    //Write the HTML Template on the HTML Page
    $orderHTML = fopen("orders.html", "w");
    fwrite($orderHTML, $htmlContent);
    fclose($orderHTML);

    //Redirect Page To Prevent Reloads
    header("Location: success.html");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>

    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Volkhov:wght@700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Order</title>
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
                    <a class="nav-link" href="menu.html">Menu</a>
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
    
    <div class="beginning">
      <h1 class="header">Order</h1>
    </div>
    
    <!--Forms: Referenced from GetBootstrap.com-->
    <form class="forms" id="orderFood" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>"> 

      <!--Name-->
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control forms" id="name" name="name" required>
        <!--type text allows the user to input text-->
      </div>

      <!--Email Address-->
      <div class="form-group">
        <label for="emailAddress">Email address:</label>
        <input type="email" class="form-control forms" id="emailAddress" name="emailAddress" placeholder="name@gmail.com" required>
        <!--type email checks if the user inputs a valid email address-->
      </div>

      <!--Phone Number-->
      <div class="form-group">
        <label for="phoneNumber">Phone Number:</label>
        <input type="tel" class="form-control forms" id="phoneNumber" name="phoneNumber" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="999-999-9999" required>
        <!--type tel with the pattern is the format to only accept inputs with XXX-XXX-XXXX phone number-->
      </div>

      <!--Food Type-->
      <div class="form-group">
        <label for="foodType">Select Food Item:</label>
        <select class="form-select forms" id="foodType" name="foodType" required>
          <option></option>
          <option>Chicken Teriyaki-$9</option>
          <option>Pork(Jeyuk)-$9</option>
          <option>Beef(Bulgogi)-$10</option>
          <option>Curry Rice-$10</option>
          <option>Curry Noodle-$12</option>
          <option>Fried Beef Dumplings-$10</option>
          <option>Pork Jjajang Rice-$10</option>
          <option>Pork Jjajang Noodle-$12</option>
          <option>Rice Cake-$10</option>
          <option>Chicken Cutlet-$10</option>
          <option>Chicken Cutlet Curry-$12</option>
          <option>Chicken Cutlet + Fried Dumplings(5 Pcs)-$14</option>
        </select>
      </div>

      <!--Quantity-->
      <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" class="form-control forms" id="quantity" name="quantity" min="1" max="10" placeholder="1-10" required>
      </div>

      <div class="form-group">
        <label for="appt">Pick Up Time:</label> (<small>Open between 9am to 6pm</small>)  <br/>
        <input type="time" id="pickupTime" name="pickupTime" min="09:00" max="18:00" required> <br/>
      </div>

      <!--Prefernces-->
      <div class="form-group">
        <label for="notes">Preferences/Notes</label>
        <textarea class="form-control forms" id="notes" name="notes" rows="3" placeholder="Make it spicy!"></textarea>
      </div>
      
      <button type="submit" name="submit" class="btn btn-primary submitButton">Submit</button>
      
    </form>
    <br/>
</body>
</html>