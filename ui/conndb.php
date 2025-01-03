<?php

try{

    $pdo = new PDO('mysql:host=localhost;dbname=bbsmaposis_db','root','');

}catch(PDOException $e  ){

echo $e->getMessage();


}

?>