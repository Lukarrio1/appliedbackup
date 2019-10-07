<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title></title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" />
  <!-- Bootstrap core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Material Design Bootstrap -->
  <link href="../../../resources/css/mdb.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../resources/css/main.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css">
</head>

<body>
  <!--Navbar -->
  <nav class="mb-1 navbar navbar-expand-lg navbar-dark aqua-gradient">
    <a class="navbar-brand" href="../../../resources/view/index.php">CARRIUM</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="../../../resources/view/myposts.php"><i class="fas fa-atlas"></i>My Posts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../../resources/view/friends.php"><i class="fas fa-users"></i> Friends</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../../resources/view/add_friend.php"><i class="fas fa-plus"></i>Friend</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto nav-flex-icons">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="notificationdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell" id="notificationcount">0</i>
             Notifications
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="notificationdropdown" id="notificationdisplay">

          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"></i>
            <span id="username"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
            <a class="dropdown-item" href="../../../resources/view/profile.php">Profile</a>
            <a class="dropdown-item" href="../../../controllers/LoginController.php?function=logout">Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!--/.Navbar -->
