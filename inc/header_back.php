<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Back vax</title>

    <!-- bootstrap core css -->
    <link href="bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="bootstrap/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="bootstrap/dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="bootstrap/vendor/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="bootstrap/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  </head>

  <body>
    <div id="wrapper">
      <header>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                </button>
                <a class="navbar-brand" href="b_back.php">Dashboard Administrateur VAX</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
              <li class="active">
                <a href="b_back.php"><i class="active	far fa-file-alt fa-fw"></i> Dashboard</a>
            </li>
            <li>
              <a href="b_user_back.php"><i class="fa fa-user fa-fw"></i> Profils</a>
            </li>
            <li>
                <a href="b_vaccins_back.php"><i class="fa fa-medkit fa-fw"></i> Vaccins</a>
            </li>

                <li class="dropdown">

                    <a class="dropdown-toggle" data-toggle="dropdown" href="b_back.php">
                        <i class="	fas fa-user-secret"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="profil.php"><i class="	fas fa-user"></i> User Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="deconnection.php"><i class="	fas fa-power-off fa-fw"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
              <!-- /.navbar-static-side -->
    </nav>

      </header>
    </div>
