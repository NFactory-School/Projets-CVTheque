<<<<<<< HEAD
<?php
   try {
        $pdo = new PDO('mysql:host=localhost;dbname=user', "root", "", array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ));
    }
    catch (PDOException $e) {
        echo 'Erreur de connexion : ' . $e->getMessage();
    }
=======
<?php
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=nf_vax', "root", "", array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ));
    }
    catch (PDOException $e) {
        echo 'Erreur de connexion : ' . $e->getMessage();
    }
>>>>>>> ed69d64948c6a9fa86844aae90d07a6037450565
