<?php
function br(){
  echo '<br/>';
}

function division(int $a,int $b){
$result = $a/$b;
return($result);}

function tab($array){
  echo '<pre>';
  print_r ($array);
  echo '</pre>';}

function inc($i){
    $i++;
    return($i);}

$errors = array();
function vTxt($errors,$data,$min,$max,$key,$empty = true){
if (!empty($data)){
  if(strlen($data) < $min){
    $errors[$key]= 'min  '.$min.' caracteres ';
  }elseif (strlen($data) > $max ) {
    $errors=[$key]='max '.$max.' caractere';
  }
}else {
  if($empty){
  $errors[$key]='Veuillez renseigner ce champ';}
}
  return $errors;
}

function vMail($error,$value,$min,$max,$key) {
  if (!empty($value)) {
    if (filter_var($value, FILTER_VALIDATE_EMAIL)){
      $value = trim(strip_tags($value));
      if (is_string($value) && strlen($value) <= $min) {
        $error[$key] = 'error : moins de '.$min.' caractères';
      }
      elseif (is_string($value) && strlen($value) >= $max ){
        $error[$key] = 'error : plus de '.$max.' caractères';
      }
      else {
        $error[$key] = 'error : vide';
      }
    return $error;
    }
  }
}

function vMdp($error,$data,$min,$max,$key){
  if (!empty($data)) {
    if (is_string($data) && strlen($data) <= $min) {
      $error[$key] = 'error : moins de '.$min.' caractères';
    }
    elseif (is_string($data) && strlen($data) >= $max ){
      $error[$key] = 'error : plus de '.$max.' caractères';
    }
  }
  else {
    $error[$key] = 'error : vide';
  }
  return $error;
}

function generateRandomString($length){
    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $charsLength = strlen($characters) -1;
    $string = "";
    for($i=0; $i<$length; $i++){
        $randNum = mt_rand(0, $charsLength);
        $string .= $characters[$randNum];
    }
    return $string;
}

function isLogged(){
  if(!empty($_SESSION['user']['id'])  && !empty($_SESSION['user']['mail']) && !empty($_SESSION['user']['status']) && !empty($_SESSION['user']['ip'])) {
    if($_SESSION['user']['ip'] = $_SERVER['REMOTE_ADDR']){
    return true;
  }
}
return false;
}

function isAdmin() {
  if (!isLogged() && $_SESSION['user']['status']!='admin'){
    header('Location:../403.php');
  }
}

function error($errors,$key){
  if(!empty($errors[$key])){
    echo $errors[$key];
  }
}

function rappel(){
  if (!empty($_SESSION['user']['ddn'])){

      $timestamp = strtotime($_SESSION['user']['ddn']);
      $now = time();
      $difference = floor($now-$timestamp);

      $difference /= 60*60*24*7*4.35;

      $difference = floor($difference);
      echo $difference;


      return "$difference $periods[$j]";
      echo $difference.' mois ou '.floor($difference/12).' années';;
  }
}
function vnum($error,$data,$min,$max,$key){
  if (!empty($data)) {
    if (is_numeric($data) && $data <= $min) {
      $error[$key] = 'error : entre  '.$min.'et'.$max;
    }
    elseif (is_numeric($data) && $data <= $min) {
      $error[$key] = 'error : entre  '.$min.'et'.$max;
    }
  }
  else {
    $error[$key] = 'error : vide';
  }
  return $error;
}

 function ddn(){
   if(!empty($ddn)){
     if($ddn < 01-01-1900){
       $errors['ddn']='trop vieux';
     }
     elseif($ddn > NOW()){
       $errors['ddn']='n\'existe pas';
     }
   }
 }

 function sameVaccin(){

 }


?>
