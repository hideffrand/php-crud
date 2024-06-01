<!-- 
Proyek UAS Lab - PW IBDA2012
Deffrand Farera
222201312
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="index.css">
  <title>Profile | C-Cars</title>
</head>

<body>
  <?php
  include 'middleware.php';
  include './handlers/connection.php';
  $email = $_SESSION['email'];

  $q = $con->prepare("SELECT id FROM users WHERE email = ?");
  $q->bind_param("s", $email);
  $q->execute();
  $user_id = $q->get_result()->fetch_assoc()['id'];

  $q->close();
  ?>
  <nav class="w-full h-fit flex items-center justify-center fixed z-20 pt-4 top-0">
    <div class="md:w-1/2 w-[95%] flex justify-center items-center gap-12 md:py-4 py-2 md:px-8 px-4 bg-black bg-opacity-20 backdrop-blur-md border border-gray-600 rounded-full text-center">
      <a class="flex items-center gap-2 hover:text-white" href="index.php">
        <ion-icon name="car-sport-outline" class="md:text-3xl text-2xl hover:text-white"></ion-icon>
        Garage
      </a>
      <div class="logo md:text-lg text-xs w-full mb-0">C-Cars</div>
      <span class="flex md:gap-6 gap-2">
        <?php
        if (!isset($_SESSION['email'])) {
          echo <<<END
            <a href="login.php" class="flex gap-2 items-center justify-center">
              Login
              <ion-icon name="log-out-outline" class="md:text-3xl text-2xl hover:text-white"></ion-icon>
            </a>
          END;
        } else {
          echo <<<END
            <a href="signout.php" class="flex gap-2 items-center justify-center">
              Logout
              <ion-icon name="log-out-outline" class="md:text-3xl text-2xl hover:text-white"></ion-icon>
            </a>
            <a href="profile.php" class="flex items-center justify-center">
              <ion-icon name="person-circle-outline" class="md:text-3xl text-2xl hover:text-white"></ion-icon>
            </a>
          END;
        }
        ?>
      </span>
    </div>
  </nav>

  <div class="container w-full h-screen flex flex-col items-center justify-start mt-32 px-[10%]">
    <h1 class="text-center w-full text-xl text-white mb-8">Hi, <?php echo $_SESSION['email']; ?>!</h1>

    <p class="mb-8">Rent History: </p>
    <div class="w-full flex flex-col">
      <?php
      $date_now = new DateTime();
      $q = $con->prepare("SELECT * FROM rents WHERE user_id = ?");
      $q->bind_param('s', $user_id);
      $q->execute();
      $res = $q->get_result();
      $q->close();

      while ($row = $res->fetch_assoc()) {
        $car_id = $row['car_id'];
        $q = $con->prepare("SELECT brand, model, img FROM cars WHERE id = ?");
        $q->bind_param('s', $car_id);
        $q->execute();
        $res_car = $q->get_result()->fetch_assoc();
        $q->close();
        echo <<<END
          <div class="w-full h-fit mb-4 p-4 flex md:flex-row flex-col md:gap-12 gap-4 justify-between items-center border-b border-gray-800 rounded-md" style="background-color: rgb(10, 10, 10);">
            <img src="{$res_car['img']}" alt="{$res_car['brand']} {$res_car['model']}" class="w-40 h-auto">
            <span class="flex flex-col">
              <h1 class="text-white text-xl">{$res_car['brand']} {$res_car['model']}</h1>
              </span>
              <div class="flex gap-8">
              <span class"flex flex-col">
                From:
                <p class="text-white">{$row['start_date']}</p>
              </span>
              <span class"flex flex-col">
                To:
                <p class="text-white">{$row['finish_date']}</p>
              </span>
              </div>
            <span>
        END;

        $start_date = new DateTime($row['start_date']);
        if ($start_date > $date_now) {
          echo <<<END
            <form action="./handlers/cancel_rent.php" method="POST">
              <input type="text" value="{$row['id']}" name="rent_id" hidden>
              <input type="submit" value="Cancel" class="bg-red-700 text-white py-2 px-4 rounded-md cursor-pointer hover:bg-red-800">
            </form>
          END;
        } else {
          echo "<p class='text-white py-2 px-4 rounded-md' style='background-color: rgb(25, 25, 25);'>{$row['status']}</p>";
        }
        echo "</span>";
        echo "</div>";
      }
      ?>
    </div>

  </div>
</body>

</html>