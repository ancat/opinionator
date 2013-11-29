<?PHP
function ELO_algorithm($winner = 1000, $loser = 1000){
  $Ra = $winner;
  $Rb = $loser;


  $k1 = 32;

  if (($Ra > 2099) && ($Ra < 2401)){
    $k1 = 24;
  }

  if ($Ra>2400){
    $k1 = 16;
  }

  $k2 = 24;
  $k3 = 16;

  $Ea = 1/ (1+pow(10,(($Rb - $Ra)/400)));
  $Eb = 1/ (1+pow(10,(($Ra - $Rb)/400)));

  $Sa = 1;
  $Sb = 0;

  $Ra_prime = $Ra + $k1*($Sa - $Ea);
  $Rb_prime = $Rb + $k1*($Sb - $Eb);

  $return_array = array($Ra_prime, $Rb_prime);
  return $return_array;
}

?>
