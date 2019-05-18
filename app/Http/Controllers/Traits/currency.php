<?php
namespace App\Http\Controllers\Traits;

trait currency{
	public function getCurrency($count){
		if($count >= 0){
      $a = 3;
        $i = 0;
        $length = strlen($count);
        $money = ',00';
        while($length - $a + 3 >= 0){
          if($length - $a + 3 >= 3){
            $money = substr($count, $a*(-1), 3).$money;
          }else{
            $final = 'Rp '.substr($count, $a*(-1), $length%3).$money;
          }
          if($length - $a != 0){
            $money = '.'.$money;  
          }
          $i += 1;
          $a = $a + 3;
        }
    }else{
      $count = $count*(-1);
      $a = 3;
        $i = 0;
        $length = strlen($count);
        $money = ',00';
        while($length - $a + 3 >= 0){
          if($length - $a + 3 >= 3){
            $money = substr($count, $a*(-1), 3).$money;
          }else{
            $final = 'Rp -'.substr($count, $a*(-1), $length%3).$money;
          }
          if($length - $a != 0){
            $money = '.'.$money;  
          }
          $i += 1;
          $a = $a + 3;
        }
    }
  
    return $final;
	}
}

?>