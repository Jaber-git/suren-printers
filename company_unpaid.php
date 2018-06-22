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
    <title>Unpaid | Suren Printers</title>
</head>
<body>
    <?php
        if(!is_null($pdo)){
            try{
                $sql="Select CompanyName FROM Companies WHERE ID=:id;";
                $stmt=$pdo->prepare($sql);
                $stmt->bindValue(':id',$_POST['company_id']);
                $stmt->execute();
                $row=$stmt->fetch();
                echo "<h1>{$row['CompanyName']}</h1>";
            }catch(PDOException $e){
                echo "<h1>Sorry we are unable to process your request</h1>";
            }
        }
    ?>
    <table>
        <tr>
            <th>Bill No.</th>
            <th>Bill Date</th>
            <th>Bill Amount</th>
            <th>View Bill</th>
        </tr>
        <?php
            if(!is_null($pdo)){
                try{
                    $sql="Select Bills.ID AS BillID,Bills.BillDate AS BillDate ,SUM(Items.Price) AS Amount FROM Bills,Items WHERE Bills.ID=Items.BillID AND Bills.CompanyID=:id AND Bills.PayStatus=0 GROUP BY Bills.ID;";
                    $stmt=$pdo->prepare($sql);
                    $stmt->bindValue(':id',$_POST['company_id']);
                    $stmt->execute();
                    
                    while($row=$stmt->fetch()){
                        $output="<tr>";
                        $output.="<td>{$row['BillID']}</td>";
                        $output.="<td>{$row['BillDate']}</td>";
                        $output.="<td>{$row['Amount']}</td>";
                        $output.="<td><a href=\"view_bill.php?bill_id={$row['BillID']}&company_id={$_POST['company_id']}\">View</a></td>";
                        $output.="</tr>";
                        echo $output;
                    }
                }catch(PDOException $e){
                    echo "<h1>Sorry we are unable to process your request</h1>";
                }
            }    
        ?>        
        
    </table>
    
</body>
</html>