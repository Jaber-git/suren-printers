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
    <title>All Bills | Suren Printers</title>
</head>
<body>
    <h1>All Bills</h1>
    <table>
        <tr>
            <th>Bill No.</th>
            <th>Company Name</th>
            <th>Bill Date</th>
            <th>Payment Status</th>
            <th>Price</th>
            <th>View</th>
        </tr>
        <?php
            $sql="SELECT Companies.ID AS CID, Bills.ID AS ID, Companies.CompanyName AS Name, Bills.BillDate AS Date,Bills.PayStatus AS Status, SUM(Items.Price) AS Price FROM Bills,Companies,Items WHERE Companies.ID=Bills.CompanyID AND Bills.ID = Items.BillID GROUP BY Bills.ID;";
            $stmt=$pdo->prepare($sql);
            $stmt->execute();
            while($row=$stmt->fetch()){
                $output="<tr>";
                $output.="<td>{$row['ID']}</td>";
                $output.="<td>{$row['Name']}</td>";
                $output.="<td>{$row['Date']}</td>";
                
                if($row['Status']){
                    $output.="<td>Paid</td>";
                }else{
                    $output.="<td>Not Paid</td>";
                }
                $output.="<td>{$row['Price']}</td>";
                $output.="<td><a href=\"view_bill.php?bill_id={$row['ID']}&company_id={$row['CID']}\">View</a></td>";
                $output.="</tr>";
                echo $output;
            }
            $pdo=null;
        ?>
    </table>

    
</body>
</html>