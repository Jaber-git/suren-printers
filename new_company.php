<?php
    include_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        $connString="mysql:host=".DBHOST.";dbname=".DBNAME;
        $user=DBUSER;
        $pass=DBPASS;
        $company=$_POST['company'];
        $address=$_POST['address'];
        try{
            
            $pdo=new PDO($connString,$user,$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $sql="INSERT INTO Companies (CompanyName,Address) VALUES(:company,:address)";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(':company',$company);
            $stmt->bindValue(':address',$address);
            $success=$stmt->execute();
            if($success){
                echo "<h1>The Company was added successfully!</h1><br/>";
                echo "<a href=\"index.php\">Home Page</a>";
            }else{
                echo "<h1>Sorry! the there was an error please try again</h1><br/>";
                echo "<a href=\"index.php\">Home Page</a>";
            }

        }catch(PDOException $e){
            echo "<h1>Sorry! the there was an error please try again</h1><br/>";
            echo "<a href=\"index.php\">Home Page</a>";
        }
    ?>
    
</body>
</html>