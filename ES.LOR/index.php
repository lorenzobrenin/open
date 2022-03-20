<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DBtestFINAL</title>
</head>
<body>
<h2><b>Client record<a href="es_Car.php">s</a>: </b></h2>

    <form action="index.php" method="post" enctype="multipart/form-data" style = "background-color: #60f542";>  <!--invia dati a se' stesso as page-->
    <fieldset>
        <label for="cerca"><b>Search by field: </b></label>
        <input type="search" name="cerca" required><br><br>
        <input type="submit" value = "cerca"    style =" background-color: lightgreen";>
    </fieldset>
</form><br><br>
<!-- 3 add field search filter str cognome / parte del cognome -->
</body>
</html>

<?php
//  1° CONNECTION
    include_once 'connection.php'; //include once, set
    include 'library.php';
//#####################################################################################
//LETTURA CLIENTI
    try{
//  2° PREPARE  // $c == var connession in file connection.php
        $name = 'nome'; //associo argomenti
        $surname = 'cognome';

        $sql = "SELECT * FROM clienti";

        $st = $c->prepare($sql);    //obj c call its method "prepare" argument str "sql"
        /*
// 3° BIND
        $st -> bindParam('name',$name, PDO::PARAM_STR);
        $st -> bindParam('cognome',$surname, PDO::PARAM_STR);
        */
// 4° EXECUTE
        if(! $st -> execute()){ echo "Nella query sql";} //call method "execute"; //esegue
// 5° FETCH
        $records = $st -> fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e){
        echo "Exception catched. <br>"; // compare se exception verificata
        echo $e -> getMessage(); // extract private property
    }
    
    // -1,-2,-6 print clients: nome cognome
    $a1 = ['nome', 'cognome', 'dataNascita']; //array per scorrimento key (clienti)
    elenco_r($records,$a1); //call list el.clienti => nome, cognome

    // -4, -5 print M, m data nascita clienti (+ query link)
    $a2 = ['dataNascita', 'ID_cliente', 'nome']; //array per scorrimento key (data)
    y_o_est($records,$a2); //call list el.clienti => nome, cognome

    // -6 print M, m data nascita clienti
    /*
    $a2 = ['dataNascita']; //array per scorrimento key (data)
    if (b_d($records, $a2)){ //true or false
        echo "Oggi e' il compleanno del cliente";
    }   else "NON e' il g. del compleanno";
    */
    //#######################################################################################
    //#######################################################################################
    // ADD ONE el, client
        // INSERT INTO clienti(nome, cognome, data_Nascita, citta);
        // VALUES ('Mario', 'Rossi', '1999-03-16 00:00:00','261');
        try{
            $nome ='Gianpippone';
            $cognome ='Fragrustrosio';
            $data_Nascita ='2008-03-16 00:00:00';
            $citta ='261';
            $sql = "INSERT INTO clienti
                    (nome, cognome, dataNascita, citta)
                    VALUES (:nome, :cognome, :dataNascita, :citta)"; //preparo inserimento dati con bind, non uso variabili sql injection
                            //*se uso un delay aggiro questa protezione
    // 2° PREPARE
            $st = $c -> prepare($sql);
    // 3° BIND
            $st -> bindParam('citta', $citta,  PDO::PARAM_INT);
            $st -> bindParam('dataNascita', $dataNascita, PDO::PARAM_STR);
            $st -> bindParam('cognome', $cognome,  PDO::PARAM_STR);
            $st -> bindParam('nome', $nome,  PDO::PARAM_STR);
    // 4° EXECUTE
            //$st -> execute();
            echo "Cliente: <b>$nome</b> inserito correttamente.";
    // 5° FETCH solo con SELECT
            //la fetch non serve perche non abbiamo dati indietro   
        }catch(PDOException $e){
            echo $e -> getMessage();
        }
//#######################################################################################
//#######################################################################################
// query selezione singolo elemento 1979-07-03 00:00:00 dataNascita
    // 2° PREPARE
        $nome_confronto = 'Vincenzo';
        $ak = ['nome','cognome','dataNascita'];
        $parametro = " data nascita cliente $nome_confronto";
        try{
            // $data_confronto tra apici perchè rappresenta static value //Pericolo SQL injection da parte di user
            $sql = "SELECT * FROM clienti WHERE nome = :nomen"; //passo paramentro da BIND 3°
            //conviene assegnare str sql per pulizia codice in prepare argument
            $st = $c -> prepare($sql);   // vuole sql code eseguire 
    // 3 BIND //collega contenuto variabile in query, e contenuto vero = tipo dato vero che vogliamo ricevere
                //bind e' omissibile. MA in form / link dinamici / campi DB è consigliato per evitare sql code injection
                // bind (data_confronto input, contenuto DB...)
                // NON inserire may contenuto var dentro str sql!!  :data_confronto";
                    //$v = bindParam('nome', $variabile, PDO::PARAM_INT STR.. type.)
            // DELETE FROM regioni; //eliminerebbe dati
                $st -> bindParam('nomen',$nome_confronto, PDO::PARAM_STR);
    // 4 EXECUTE
            if(! $st -> execute()){ echo "Nella query sql";} // T success query | F insuccess in query
    // 5 FETCH prendo dati estratti
            $records = $st -> fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
                    echo "Exception catched. <br>"; // compare se exception verificata
                    echo $e->getMessage();  //method estrae proprieta' privata
                    echo $e->getcode(); //gestisce exception in base al caso | codice 1 = "errore numer X"
            }   
            $parametro = $nome_confronto;
            el_sing_par($records, $ak, $parametro);

            //function lettura record array, arrayk, titolo
function el_sing_par($a,$ks, $par){
    echo "<br><hr><b>Estratti ". count($a). " nomi cliente == $par: </b>";
    $x = 1; //counter
            foreach($a as $v){ //per ogni el array
                //echo "<b>$par</b><br>"; //stampa n- array key ('k2')
                echo "<br>$x ";
                foreach($ks as $k){
                    echo " ". $v[$k]." ";
                }
                $x++;
            }
        echo "<hr>";
    }



// Selezionare un tipo di parametro in base ad un altro N.stelle / costo_g

    //finisci lista ordinamento desc / ...
    //tabella di selezionamento (persinogolo tipo modello clienti prezzo nano giardino)