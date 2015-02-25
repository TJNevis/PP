<?php 
function field($value){
  $value = (isset($$value)) ? $$value : "";
  return $value;
} 


?>