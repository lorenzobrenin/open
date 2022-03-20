<?php
//##########################################################################
//##########################################################################
// 1° connection
        //include config.php
        
    // 1.1° config.php set configuration DB
        $dsn = 'mysql:dbname=laravel;host=127.0.0.1';
        $user = "root";     //default
        $password = "";     //default
    // 1.2° connection.php
        //require_once 'config.php' | file 1.1°
        $where =""; //FONDAMNETALE se non faccio il search viene reinizializzato a str.void
        try {
            $connession = new PDO($dsn, $user, $password);
        } 
        catch(PDOException $e){
            echo "Exception found";
            echo $e -> getMessage();
        }
    // 1.3° include connection.php | file 1.2°
        //SEARCH    // $where nella query inserisce comando %str% e cerca IMPORTANTISSIMO * SEARCH
    if($_POST){ //check if form sent data
            if(array_key_exists('search',$_POST)){   //cerca i record con $_POST['search']
                $where = " WHERE brand LIKE '%{$_POST['search']}%' 
                        OR model LIKE '%{$_POST['search']}%'  ";
            }

        //ADD el.into.DB
            if(array_key_exists('model',$_POST) ){  //ADD record into DB => tab (k, k, k) values (:bind1, bind2)
                try{
                    $sql = "INSERT INTO cars (model, brand, engine_size) 
                            VALUES (:binded_model, :binded_brand, :binded_engine_size) ";
    //2° PREPARE
                    if( ($st = $connession->prepare($sql)) === FALSE){
                        echo "Errore nella prepare";
                    }
    //3° BIND   //set value sqr ()
                    $st->bindParam('binded_model',$_POST['model']);
                    $st->bindParam('binded_brand',$_POST['brand']);
                    $st->bindParam('binded_engine_size',$_POST['engine_size'],PDO::PARAM_INT);
                    //4 execute
                    if( ! ($st->execute())  ){
                        echo "errore nella query $sql";
                    }else {
                        echo "Car inserita correttamente";
                    }
                }catch(PDOException $e){
                    echo "Eccezione catturata. ";
                    echo $e->getMessage();
                }
    //END INSERT=========================================================================
//##########################################################################
//##########################################################################
            }
        }   else
                if($_GET && $_GET['order']){//gestisco il valore di order
                    $order = $_GET['order'];
                }
                if(! isset($order)){
                    $order = 'brand';
                }
            //ORDINE QUERY IN BASE A 'ORDER' ====================================================
    $records=[];  //FONDAMENTALE PER IL SEARCH STR
        try{
    //2 PREPARE
            //$sql="SELECT * FROM cars $where ORDER BY $order DESC";
            $sql="SELECT * FROM cars $where ORDER BY $order";
            $st= $connession->prepare($sql);
    //3 BIND
            //$st->bindParam('order',$order, PDO::PARAM_STR);
    //4 EXECUTE
            $st->execute() ;
    //5 FETCHaLL
            $records=$st->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Eccezione catturata. ";
            echo $e->getMessage();
        }
//##########################################################################
//##########################################################################
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            color:#333333;
            background-color: lightgoldenrodyellow;
        }
    </style>
    <title>Es_Tab_list</title>
</head>
<body>
<!--    BUILD FORM   --><!--  *required *k == k.DB
        1- set file recoursive
        2- set method POST GET
        3- label input (name = ' k ')
        4- input type='submit' value='send'>
-->
    <h1>ADD new-car</h1>    
    <form action="es_Tab_list.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <label for="model">Model:</label>
            <input type="text" name="model" id="model" required>
            <label for="brand">Brand:</label>
            <input type="text" name="brand" id="brand" required>
            <label for="engine">Engine Size</label>
            <input type="text" name="engine_size" id="engine" required> 
        </fieldset> 
        <input type="submit" value="Invia"> 
    </form>    
<!--    SEARCH FORM   --><!-- *required
        1- input type=text name='k'
        2- input type='submit' value='search'>
-->
    <h2>PRINT list cars </h2>
    <form action="es_Tab_list.php" method="post" enctype="multipart/form-data">
        <input type="text" name="search" id="search" required>
        <input type="submit" value="searchCar"> 
    </form>
<!--    PRINT TABLE   --><!-- *required
        1- input type=text name='k'
        2- input type='submit' value='search'>
        3- link send query str Reorder list
-->
    <table>
        <tr>
            <th> <a href="es_Tab_list.php?order=model ASC">Model</a><span>  <a href="es_Tab_list.php?order=model DESC"><button>v</button></a> </span></th>
            <th> <a href="es_Tab_list.php?order=brand ASC">Brand</a><span>  <a href="es_Tab_list.php?order=brand DESC"><button>v</button></a></span></th>
            <th> <a href="es_Tab_list.php?order=engine_size ASC">Engine Size</a><span>  <a href="es_Tab_list.php?order=engine_size DESC"><button>v</button></a></span></th>
        </th>
        
            <!-- <th> <a href="es_Tab_list.php?order= ' DESC'"><button>DESC</button></a> </th> -->
        </tr>
        <?php //print records DYNAMIC
        foreach ($records as $record){
            echo "<tr>";
                echo "<td>".$record['model']."</td>";
                echo "<td>".$record['brand']."</td>";
                echo "<td>".$record['engine_size']."</td>";
            echo "</tr>";
        }
        ?>

    </table>
</body>
</html>