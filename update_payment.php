<?php
    include_once 'config.php';
    $pdo=null;
    try{
        $connString="mysql:host=".DBHOST.";dbname=".DBNAME;
        $user=DBUSER;
        $pass=DBPASS;
        $pdo=new PDO($connString,$user,$pass);
    }catch(PDOException $e){
        $pdo=null;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="table.css"/>
    <title>Document</title>
</head>
<body>
  <?php
    if(!is_null($pdo)){
        $sql="UPDATE Bills SET PayStatus=1 WHERE ID=:id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id',$_GET['bill_id']);
        if($stmt->execute()){
            echo "<h1>Successfully updated payment status!</h1>";
        }else{
            echo "<h1>Sorry could'nt update payment status.</h1>";
        }
    }else{
        echo "<h1>Sorry could'nt update payment status.</h1>";
    }
    $pdo=null;
  ?>  
  <a href="index.php">Home Page</a>
</body>
</html>