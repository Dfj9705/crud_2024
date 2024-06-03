<?php 

function validarNIT($nit) : bool{    
    $tamanio = strlen($nit);
    $validador = $nit[$tamanio-1];
    $validador = strtolower( $validador ) == 'k' ? 10 : $validador;
    $posicion = 2;
    $suma = 0;
    for($i = $tamanio -  2; $i >= 0 ; $i--){

        $suma += $nit[$i] * $posicion;
        // echo $nit[$i] . "pos: " . $posicion;
        // echo "<br>";
        $posicion++;
    }
    $residuo = $suma % 11;
    $resta = 11 - $residuo;
    $residuo2 = $resta % 11;
    return $residuo2 == $validador;
}

function estaVacio($array = []) : bool{
    //OBTENER EL LARGO DEL ARRAY 0
    $largo = count($array);
    //CONTADOR INICIALIZADO EN 0
    $contadorVacio = 0;
    //POR CADA ELEMENTO DEL ARRAY SE CUENTAN CUANTOS ESPACIOS VACIOS HAY
    foreach ($array as $key => $elemento) {
        if($elemento == ''){
            // INCREMENTA EL CONTADOR
            $contadorVacio++;
        }
    }
    // TODOS LOS ELEMENTOS ESTAN VACIOS?
    return $largo == $contadorVacio;
}