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
    <form method="post" action="insert_bill.php">
        <br/><br/><br/>
        <label>Company:</label>
        <select name="company_id">
            <?php
                if(!is_null($pdo)){
                    $sql="SELECT ID,CompanyName FROM Companies";
                    $stmt=$pdo->prepare($sql);
                    $stmt->execute();
                    while($row=$stmt->fetch()){
                        echo "<option value={$row['ID']}>{$row['CompanyName']}</option>";
                    }
                }
                $pdo=null;
            ?>
        </select><br/>
        <label>Bil Date:</label>
        <input type="text" name="bill_date"/>
        <br/><br/><br/>

        <table>
            <tr>
                <th>Sl No.</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        
        <?php
            for($i=0;$i<30;$i++){
                $output="<tr>";
                $output.="<td>{$i}</td>";
                $output.="<td><input type=\"text\" name=\"name_{$i}\"/></td>";
                $output.="<td><input type=\"number\" name=\"quantity_{$i}\"/></td>";
                $output.="<td><input type=\"number\" name=\"price_{$i}\"/></td>";
                $output.="</tr>";
                echo $output;
            }
        ?>
        </table>
        <input type="Submit" value="Submit"/>
    </form>
    
</body>
</html>