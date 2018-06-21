<?php
    include 'config.php';
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
</head>
<body>
    <ul>
        <li><a href="companies.php">List All Companies</a></li>
        <li><a href="unpaid.php">Unpaid Bills</a></li>
    </ul>
    <form method="post" action="company_unpaid.php" >
        <select id="company_name" >
            <?php
                try{
                    $connString="mysql:host=".DBHOST.";dbname=".DBNAME;
                    $user=DBUSER;
                    $pass=DBPASS;
                    $pdo=new PDO($connString,$user,$pass);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                    $sql="SELECT ID,CompanyName FROM Companies";
                    $stmt=$pdo->prepare($sql);
                    $stmt->execute();
                    
                    while($row=$stmt->fetch()){
                        echo "<option value={$row['ID']}> {$row['CompanyName']}</option>";
                    }
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
                                
            ?>            
        </select>
        <br/>
        <input type="submit" value="Submit"/>
    </form>
</body>
</html>