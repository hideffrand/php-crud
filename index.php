<!-- 
Proyek UAS Lab - PW IBDA2012
Deffrand Farera
222201312
-->

<?php
include './handlers/connection.php';
include './handlers/uid.php';
session_start();

$q = $con->prepare("SELECT * FROM cars WHERE status = 'Available'");
$q->execute();
$result = $q->get_result();
$q->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $type = $_POST['type'];

  // Fetch cars by type
  if (isset($type) && !empty($type)) {
    $q = $con->prepare("SELECT * FROM cars WHERE type = ? AND status = 'Available'");
    $q->bind_param("s", $type);
    $q->execute();
    $result = $q->get_result();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1Ktv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="index.css">
  <title>Garage | C-Cars</title>
</head>

<body>
  <div class="garage-door">
    <div class="logo">C-Cars</div>
  </div>

  <form action="" method="POST">
    <div id="filter" class="filter md:w-[300px] w-[90%] px-8 fixed z-20 left-0 h-screen bg-black bg-opacity-20 backdrop-blur-md flex flex-col items-start justify-center gap-6">
      <span class="w-full flex items-center justify-between mb-8">
        <b class="text-xl">Filter</b>
        <button onclick="handleFilter()" type="button">
          <ion-icon name="close-circle-outline" class="md:text-3xl text-2xl hover:text-white"></ion-icon>
        </button>
      </span>
      <div class="flex flex-col w-full justify-center">
        <label class="text-sm" for="type">Type:</label>
        <select name="type" id="type" class="px-4 py-1 border border-gray-400 text-white bg-transparent cursor-pointer rounded-md">
          <option class="bg-black text-white" value="">Choose</option>
          <option class="bg-black text-white" value="SUV">SUV</option>
          <option class="bg-black text-white" value="Sedan">Sedan</option>
          <option class="bg-black text-white" value="Coupe">Coupe</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary px-8 w-full mt-8">Apply Filter</button>
    </div>
  </form>

  <nav class="w-full h-fit flex items-center justify-center fixed z-20 pt-4">
    <div class="md:w-1/2 w-[95%] flex justify-center items-center gap-12 md:py-4 py-2 md:px-8 px-4 bg-black bg-opacity-20 backdrop-blur-md border border-gray-600 rounded-full text-center">
      <button class="flex items-center gap-2 hover:text-white" onclick="handleFilter()">
        <ion-icon name="filter-outline" class="md:text-3xl text-2xl hover:text-white"></ion-icon>
        Filter
      </button>
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

  <script>
    const filter = document.getElementById('filter');

    function handleFilter() {
      if (filter.style.transform == 'translateX(-100%)') {
        filter.style.transform = 'translateX(0%)'
      } else {
        filter.style.transform = 'translateX(-100%)'
      }
    }
  </script>

  <main class="w-full h-screen main-index z-1">
    <div id="carouselExampleControls" class="carousel h-full w-full slide" data-ride="carousel">
      <div class="carousel-inner h-full w-full -translate-y-8 relative">
        <?php
        $first = true;
        while ($row = $result->fetch_assoc()) {
          $activeClass = $first ? 'active' : '';
          $first = false;
          echo <<<END
            <div class="carousel-item h-full w-full relative {$activeClass}">
              <button class="rent-btn btn btn-primary d-block md:bottom-[50%] bottom-[30%] right-[50%] absolute translate-x-[50%]" style="z-index: 20;" 
                data-id="{$row['id']}"
                data-brand="{$row['brand']}" 
                data-model="{$row['model']}" 
                data-price="{$row['price_per_day']}"
                >
                Rent this car
              </button>
              <i class="md:text-[160px] text-[60px]">{$row['model']}</i>
              <img class="d-block md:w-[50%] w-[90%] md:bottom-[10%] bottom-[30%] right-[50%] absolute translate-x-[50%]" src="{$row['img']}" alt="{$row['brand']}">
              <div class="absolute bottom-12 text-center w-full flex justify-center items-end md:gap-32 gap-12">
                <span class="flex flex-col items-center md:text-md text-sm">
                  Type
                  <b class="md:text-4xl text-2xl italic text-white">{$row['type']}</b>
                </span>
                <span class="flex flex-col items-center md:text-md text-sm">
                  Year
                  <b class="md:text-4xl text-2xl italic text-white">{$row['year']}</b>
                </span>
                <span class="flex flex-col items-center md:text-md text-sm">
                  Top Speed
                  <b class="md:text-4xl text-2xl italic text-white">{$row['top_speed']}<span class="md:text-sm text-xs text-normal">km/h</span></b>
                </span>
                <span class="flex flex-col items-center md:text-md text-sm">
                  MPG
                  <b class="md:text-4xl text-2xl italic text-white">{$row['mpg']}</b>
                </span>
              </div>
            </div>
          END;
        }
        ?>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </main>

  <div class="modal fade" id="rentModal" tabindex="4" role="dialog" aria-labelledby="rentModalLabel" aria-hidden="true" style="z-index: 100;">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="background-color: black;">
        <div class="modal-header border-dashed border-gray-400">
          <h5 class="modal-title font-bold" id="rentModalLabel">Confirm Your Rent</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="./handlers/rent_car.php" method="POST">
          <input type="text" id="car_id" name="car_id" hidden>
          <input type="number" id="price_per_day" name="price_per_day" hidden>
          <div class="modal-body">
            <h3 id="car_name" class="font-medium pb-4"></h3>
            <div class="flex justify-between mt-8">
              <label for="start_date">From</label>
              : <input type="date" class="px-4 py-2 border border-gray-400" id="start_date" name="start_date">
            </div>
            <div class="flex justify-between mb-8">
              <label for="finish_date">Until</label>
              : <input type="date" class="px-4 py-2 border border-gray-400" id="finish_date" name="finish_date">
            </div>
            <div class="flex justify-between mb-8">
              <p>Price</p>
              : <p id="price_per_day_display" class="font-medium text-green-500"></p>
            </div>
          </div>
          <div class="modal-footer border-dashed border-gray-400">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button class="btn btn-primary px-8" type="submit">Rent</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const rentButtons = document.querySelectorAll('.rent-btn');
      const rentModal = document.getElementById('rentModal');
      const carIdInput = document.getElementById('car_id');
      const pricePerDayInput = document.getElementById('price_per_day');
      const carNameElement = document.getElementById('car_name');
      const pricePerDayDisplay = document.getElementById('price_per_day_display');

      rentButtons.forEach(button => {
        button.addEventListener('click', () => {
          const carId = button.getAttribute('data-id');
          const carBrand = button.getAttribute('data-brand');
          const carModel = button.getAttribute('data-model');
          const pricePerDay = button.getAttribute('data-price');

          carIdInput.value = carId;
          console.log(carIdInput.value)
          pricePerDayInput.value = pricePerDay;
          carNameElement.innerText = `${carBrand} ${carModel}`;
          pricePerDayDisplay.innerText = `$${pricePerDay} / day`;

          $('#rentModal').modal('show');
          $('.modal').on('shown.bs.modal', function() {
            $(this).css("z-index", parseInt($('.modal-backdrop').css('z-index')) + 1);
          });
        });
      });

    });
  </script>


  <script src="./scripts/garageDoorAnimation.js"></script>
</body>

</html>