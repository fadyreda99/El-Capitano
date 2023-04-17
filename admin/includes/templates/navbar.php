<nav class="navbar navbar-dark bg-dark topbar">
  <div class="container">
    <a class="navbar-brand"><img src="./images/logo/2.png" alt=""></a>

    <a href="users.php?do=editBasic&userid=<?php echo  $_SESSION['ID'] ?>" class="btn btn-outline-secondary  me-2">Edit Profile</a>

  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-2">

      <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar" style="width: 280px;">
        <a href="dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32">
            <use xlink:href="dashboard.php" />
          </svg>
          <span class="fs-4"> AL-CAPITANO
          </span>
        </a>
        <hr>

        <ul class="nav nav-pills flex-column mb-auto">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link text-white bglink" aria-current="page">
              <svg class="bi me-2" width="16" height="16">
                <use xlink:href="dashboard.php" />
              </svg>
              Home
            </a>
          </li>

          <li>
            <a href="categories.php" class="nav-link text-white bglink">
              <svg class="bi me-2" width="16" height="16">
                <use xlink:href="categories.php" />
              </svg>
              categories
            </a>
          </li>
          <li>
            <a href="drivers.php" class="nav-link text-white bglink">
              <svg class="bi me-2" width="16" height="16">
                <use xlink:href="#table" />
              </svg>
              drivers
            </a>
          </li>

          <li>
            <a href="users.php" class="nav-link text-white bglink">
              <svg class="bi me-2" width="16" height="16">
                <use xlink:href="#grid" />
              </svg>
              users
            </a>
          </li>

          <li>
            <a href="cars.php" class="nav-link text-white bglink">
              <svg class="bi me-2" width="16" height="16">
                <use xlink:href="#people-circle" />
              </svg>
              cars
            </a>
          </li>


          <li>
            <a href="usermessage.php" class="nav-link text-white bglink">
              <svg class="bi me-2" width="16" height="16">
                <use xlink:href="#people-circle" />
              </svg>
              user messages
            </a>
          </li>


          <li>
            <a href="drivermessage.php" class="nav-link text-white bglink">
              <svg class="bi me-2" width="16" height="16">
                <use xlink:href="#people-circle" />
              </svg>
              driver messages
            </a>
          </li>
          <li>
            <a href="membership.php" class="nav-link text-white bglink">
              <svg class="bi me-2" width="16" height="16">
                <use xlink:href="#people-circle" />
              </svg>
              Ended membership
            </a>
          </li>

          <li>
            <a href="alltrips.php" class="nav-link text-white bglink">
              <svg class="bi me-2" width="16" height="16">
                <use xlink:href="#people-circle" />
              </svg>
              All trips
            </a>
          </li>


          <li>
            <a href="reports.php" class="nav-link text-white bglink">
              <svg class="bi me-2" width="16" height="16">
                <use xlink:href="#people-circle" />
              </svg>
              Reports
            </a>
          </li>



        </ul>
        <hr>
        <div class="dropdown ms-3">
          <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">

            <strong>More</strong>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="users.php?do=editBasic&userid=<?php echo  $_SESSION['ID'] ?>">Edit profile</a></li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="logout.php">log out</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-10">
      <div class="body2 ">