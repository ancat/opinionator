<html>
how is everyone doing ?
<body>


<?php


error_reporting(-1);


$pg = pg_connect("host=23.92.21.247 dbname=opinionator user=design password=p0stgr3s_is_really_annoying!!");

$result = pg_prepare($pg, "query", 'INSERT INTO products (product_name, product_image) VALUES ($1, $2)');
$result = pg_execute($pg, "query", array("Bread Is A Losers", "http://i.imgur.com/Ojzw8r9.jpg"));

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

/*
<form action = "<?php $_PHP_SELF ?>" method="POST">
Content ID<br></br>
<select name='cid'>
<?php
if ($stmt = $mysqli->prepare("select product_name from Products")){
$stmt->execute();
$stmt->bind_result($cid);
while($stmt->fetch()) 
{
  $cid = htmlspecialchars($cid);
  echo "<option value='$cid'>$cid</option>\n";  
}
$stmt->close();
$mysqli->close();
}
*/
?>

</body>
</html>