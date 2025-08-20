<?php
if(!function_exists('protectData')){
  function protectData($data){
    return   strip_tags(trim($data));
  }
}
if(!function_exists('randomString')){
  function randomString($chars){
    $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefjhijklmnopqrstuvwxyz';
    return   substr(str_shuffle($data),0,$chars);
  }
}
?>

 