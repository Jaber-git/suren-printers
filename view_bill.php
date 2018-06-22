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
    <title>View Bill | Suren Printers</title>
</head>
<body>
  <?php
    $sql="SELECT CompanyName FROM Companies WHERE ID=:id;";
    $stmt=$pdo->prepare($sql);
    $stmt->bindValue(':id',$_GET['company_id']);
    $stmt->execute();
    $row=$stmt->fetch();    
    echo "<h1>{$row['CompanyName']}</h1>";
  ?>
  <table>
      <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>          
      </tr>
      <?php
        $sql="SELECT Name, Quantity ,Price FROM Items WHERE BillID=:id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id',$_GET['bill_id']);
        $stmt->execute();
        while($row=$stmt->fetch()){
            $output="<tr>";
            $output.="<td>{$row['Name']}</td>";
            $output.="<td>{$row['Quantity']}</td>";
            $output.="<td>{$row['Price']}</td>";
            $output.="</tr>";
            echo $output;
        }
      ?>
  </table>
  <?php
    echo "<a href=\"update_payment.php?bill_id={$_GET['bill_id']}\">Payment Done</a>&nbsp&nbsp&nbsp";
  ?>
  <a href="index.php">Home Page</a>
  
</body>
</html>