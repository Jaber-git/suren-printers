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
    <title>Insert Bill | Suren Printers</title>
</head>
<body>
    <?php
        try{
            $sql="INSERT INTO Bills (CompanyID,BillDate) VALUES (:id,:date);";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(':id',$_POST['company_id']);
            $stmt->bindValue(':date',$_POST['bill_date']);
            $bill_id=0;
            if($stmt->execute()){
                $bill_id=$pdo->lastInsertId();
            }else{
                echo "<h1>Sorry we couldn't add the bill try again</h1>";
            }

            $sql="INSERT INTO Items (BillID,Name,Quantity,Price) VALUES (:id,:name,:quantity,:price);";
            $insert_flag=1;
            for($i=0;$i<30;$i++){
                $name=$_POST['name_'.$i];
                if(!empty($name)){
                    $stmt=$pdo->prepare($sql);
                    $stmt->bindValue(':id',$bill_id);
                    $stmt->bindValue(':name',$name);
                    $stmt->bindValue(':quantity',$_POST['quantity_'.$i]);
                    $stmt->bindValue(':price',$_POST['price_'.$i]);
                    if(!$stmt->execute()){
                        $insert_flag=0;
                    }
                }
            }
            if($insert_flag){
                echo "<h1>Successfully inserted new bill!</h1>";
            }else{
                echo "<h1>Sorry we couldn't add the bill try again</h1>";
            }
        }catch(PDOException $e){
            echo "<h1>Sorry we couldn't add the bill try again</h1>";
        }
    ?>
    <a href="index.php">Home Page</a>
</body>
</html>