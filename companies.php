<?php
    include_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Company List | Suren Printers</title>
</head>
<body>
    <table>
        <tr>
            <th>Sl No.</th>
            <th>Company Name</th>
            <th>Address</th>
        </tr>
        <?php
            $connString="mysql:host=".DBHOST.";dbname=".DBNAME;
            $user=DBUSER;
            $pass=DBPASS;
            try{
                $pdo=new PDO($connString,$user,$pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $sql="SELECT ID,CompanyName,Address FROM Companies ORDER BY CompanyName;";
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
                while($row=$stmt->fetch()){
                    $tr="<tr>";
                    $tr.="<td> {$row['ID']} </td>";
                    $tr.="<td> {$row['CompanyName']} </td>";
                    $tr.="<td> {$row['Address']} </td>";
                    $tr.="</tr>";
                    echo $tr;
                }
                $pdo=null;
            }catch(PDOException $e){
                echo $e->getMessage();
            }            
        ?>
    </table>
    <br/><br/>
    <p>Fill this form and submit to add a new company:</p>
    <form method="post" action="new_company.php">
            <label>Company Name:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="company"/><br/>
            <label>Address:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="address"/><br/>
            <input type="Submit" value="Submit"/>
    </form>

    
</body>
</html>