<?php

function br(){

  echo '<br/>';
}

function division(int $a,int $b){

$result = $a/$b;
return($result);
}

function tab($array){

  echo '<pre>';
  print_r ($array);
  echo '</pre>';
}

function inc($i){

    $i++;
    return($i);
}

$errors = array();

function validationTxt($errors,$data,$min,$max,$key,$empty = true){
if (!empty($data)){

  if(strlen($data) < $min){
    $errors[$key]= 'min  '.$min.' caracteres ';
  }
  
  elseif (strlen($data) > $max ) {
    $errors=[$key]='max '.$max.' caractere';
  }

}

else if($empty){
  $errors[$key]='Veuillez renseigner ce champ';
}

return $errors;
}
  

function vmail($error,$value,$min,$max,$key) {

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

function table($key){
  return 
  '<tr><td>'.$key['title'].'</td>
  <td>'.$key['auteur'].'</td>
  <td>'.$key['content'].'</td>
  <td>'.$key['created_at'].'</td>
  <td>'.$key['updated_at'].'</td>
  <td>'.$key['statu'].'</td>
  <td><a href="editpost.php?id='.$key['id'].'">Modifier</a></td></tr>';
  
}

function generateRandomString(){
  $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  $string = "";
  for($i=0; $i<20; $i++){
      $randNum = mt_rand(0, strlen($characters) -1);
      $string .= $characters[$randNum];
  }
  return $string;
}