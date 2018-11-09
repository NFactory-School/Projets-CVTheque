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
    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
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

?>
