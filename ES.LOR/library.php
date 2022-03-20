<?php

/** ELENCO TABELLA ==lT (listTAB)
 * print list elements tab
 * @param $d aaaa-mm-gg  
 * @return $d gg/mm/aaaa
 */
/*
function lT($a,$ks){
    echo "<br><b>Estratte ". count($a) . " regioni del titolo: </b>";
    $x = 1;     //counter element
        foreach($a as $v){ //per ogni el array
                foreach($ks as $k){ //per ogni el array
                    echo "<br> $x- ".$v[$k]." <b>titolo</b>"; //stampa n- array key ('k2')
                    $x++;
                }
        }
        echo "<hr>";
    }
*/
// -1 ELENCO TUTTI Clienti, FIELDS nome, cognome.
function elenco_r($a,$ks){
    echo "<br><b>Lista di ". count($a)." clienti: </b><br><hr>"; // n.clienti
    $x = 1; $n_c = 0;
    foreach($a as $v){ //per ogni records tab clienti
        echo "<b>$x - </b>"; //counter list
        foreach($ks as $k){ //per ogni key(di array keys nome, cognome)
                if($k == 'nome'){
                    echo " <b>Name: </b> ".$v[$k]." ";
                }
                if($k == 'cognome'){
                    echo " <b>Surname: </b> ".$v[$k]." ";
                }
                
                if($k == 'dataNascita'){
                    if(birthday($v[$k])){
                        echo "<b> ================COMPLEANNO================</b>" .dateUE_conv($v[$k]);
                        $n_c++;
                    }
                }
                //echo "".$v[$k]." "; //stampa array key ('k') nome, cognome
        }
        $x++;
        echo "<br><hr>";
    }
    echo "<br><b>List of </b>".($x-1)." <b>elements.</b>"; // -2 Print n.el. printed
    echo "<br>Num. Birthday: ".$n_c ;   // print n. birthday today
}   
//#######################################################################################
// -4 young old Est Print Oldest && Youngest client: nome, cognome
//ciclo array data minore && data maggiore 'dataNascita'
function y_o_est($a,$ks){
    $M = 0;                         // M Maggiore
    $m = date('Y-m-d');      // m minore
    foreach($a as $v){ //per ogni records tab clienti
        foreach($ks as $k){ //per ogni key(di array key data)
            if($k == 'dataNascita'){
                //echo "".$v[$k]." "; //stampa array key ('k') data
                if($M < $v[$k]){
                    $M = $v[$k];    // date >
                    $nM=$v['nome'];
                    $sM=$v['cognome'];
                    $idM=$v['ID_cliente'];
                }
                if($m > $v[$k]){    // date <
                    $m = $v[$k];
                    $nm=$v['nome'];
                    $sm=$v['cognome'];
                    $idm=$v['ID_cliente'];
                }
            }
            // if($k == 'dataNascita'){
            //     echo "<hr>".$k['ID_cliente'];
            // }
            //echo "<br><hr>amburgo {$k['ID_cliente']}<hr>";
        }
    }
    echo "<hr><br> <b>Data Maggiore</b>: ".dateUE_conv($M)." <a href='premio.php?ID_cliente=$idm'>$nm $sm</a>"."<br>"; //&text={$k['text']}
    echo "<br> <b>Data minore: </b>".dateUE_conv($m)." <a href='premio.php?ID_cliente=$idM'>$nM $sM</a>"."<hr>";    // Print link " $nm $sm id:$idm<hr>";
}
//#######################################################################################
//#######################################################################################
/*
//confronto compleanno singolo
// -6 b_d birthday SE oggi == cliente compleanno => return true else false
function b_d($a, $ks){
    $t = "14-06";//date("d-m").'<br>';     // $t == today m-g "03-19"
    $d = 0; $m = 0; $n_c = 0;// day, month num.compleanni_oggi
    foreach($a as $v){ //per ogni records tab clienti
        foreach($ks as $k){ //per ogni key(di array key data)
            $dc = ($d = substr($v[$k], 8,2))."-".($m = substr($v[$k], 5,2));    // str $d-$m;
            if($dc == $t){
                echo "<br><b> => </b> born ".dateUE_conv($v[$k])."<b> Birthday</b>";
                $n_c++;
            }
        }
    }
    echo "<br><b>Num. Birthday today = $n_c</b>";
}
*/
//#######################################################################################
// funzione birthday stampa con condizione in ciclo inziale
    //funzione dentro funzione elenco_R per confronti
function birthday($data_nascita){ //$v[$k]
    $t = "14-06";//date("d-m").'<br>';     // $t == today m-g "03-19"
    $d = 0; $m = 0;// day, month
            $dc = ($d = substr($data_nascita, 8,2))."-".($m = substr($data_nascita, 5,2));    // str $d-$m;
            if($dc == $t){
                return true;
            } else return false;
}
//#######################################################################################
//#######################################################################################
//converti data
    /**
     *  Convert formato data  01 USA -> UE
     *  @param  $data aaaa-mm-dd   Y-m-d
     *  @return $data gg/mm/aaaa   d-m-Y
     * 
     */
    function dateUE_conv($data){
        $y = substr($data, 0, 4);
        $m = substr($data, 5, 2);
        $d = substr($data, 8, 2);
        
        return "$d-$m-$y"; //passo una stringa di valori
        // return ['d'=>'$giorno', 'm'=>'$mese', 'd'=>'anno']; //passo un array associativo
    }

?>
