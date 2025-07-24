<?php
class RandomTable{

    public $IDr = 0 ;
    //Función que crea y devuelve un objeto de conexión a la base de datos y chequea el estado de la misma. 
    function conectarBD(){ 
            //variable que guarda la conexión de la base de datos
            $conexion = pg_connect("host=127.0.0.1 dbname=presidenciales port=5432 user=usr_presidenciales password=usr_presidenciales");
    // $conexion = pg_connect("host=localhost dbname=encuestas port=5432 user=postgres password=postgres"); 
            //Comprobamos si la conexión ha tenido exito
            if(!$conexion){ 
               echo 'Ha sucedido un error inesperado en la conexion de la base de datos<br>'; 
            } 
            //devolvemos el objeto de conexión para usarlo en las consultas  
            return $conexion; 
    }  
    /*Desconectar la conexion a la base de datos*/
    function desconectarBD($conexion){
            //Cierra la conexión y guarda el estado de la operación en una variable
            $close = pg_close($conexion);
            //Comprobamos si se ha cerrado la conexión correctamente
            if(!$close){  
               echo 'Ha sucedido un error inesperado en la desconexion de la base de datos<br>'; 
            }    
            //devuelve el estado del cierre de conexión
            return $close;         
    }

    //Devuelve un array multidimensional con el resultado de la consulta
    function getArraySQL($sql, $request){
        //Creamos la conexión
        $conexion = $this->conectarBD();
        //generamos la consulta
        if(!$result = pg_query($conexion, $sql)) die();

        $rawdata = array();
        //guardamos en un array multidimensional todos los datos de la consulta
        $i=0;
        while($row = pg_fetch_array($result))
        {   
            //Consultamos todos los votos de la primera opcion
            $consultaMuyBueno = "SELECT calificacion FROM encuesta WHERE calificacion = '1' ";
            $resultado_1 = pg_query($consultaMuyBueno);
            //Contamos el numero de registros que tiene (votos)
            $muyBueno = pg_num_rows($resultado_1);
            //Consultamos todos los votos de la segunda opcion
            $consultaBueno = "SELECT calificacion FROM encuesta WHERE calificacion = '2' ";
            $resultado_2 = pg_query($consultaBueno);
            //Contamos el numero de registros que tiene (votos)
            $bueno = pg_num_rows($resultado_2);
            //Consultamos todos los votos de la tercera opcion
            $consultaRegular = "SELECT calificacion FROM encuesta WHERE calificacion = '3' ";
            $resultado_3 = pg_query($consultaRegular);
            //Contamos el numero de registros que tiene (votos)
            $regular = pg_num_rows($resultado_3);
            //Consultamos todos los votos de la cuarta opcion
            $consultaMalo = "SELECT calificacion FROM encuesta WHERE calificacion = '4' ";
            $resultado_4 = pg_query($consultaMalo);
            //Contamos el numero de registros que tiene (votos)
            $malo = pg_num_rows($resultado_4);
            //Consultamos todos los votos de la quinta opcion
            $consultaMuyMalo = "SELECT calificacion FROM encuesta WHERE calificacion = '5' ";
            $resultado_5 = pg_query($consultaMuyMalo);
            //Contamos el numero de registros que tiene (votos)
            $muyMalo = pg_num_rows($resultado_5);
            //guardamos en rawdata todos los vectores/filas que nos devuelve la consulta
            $rawdata[$i] = $row;

            $i++;
        }
        //Cerramos la base de datos
        $this->desconectarBD($conexion);
        //devolvemos rawdata
        return array($rawdata,$muyBueno,$bueno,$regular,$malo,$muyMalo);
    }
    
    function getAllInfo(){
        //Creamos la consulta
        $sql = "SELECT * FROM encuesta;";
        //obtenemos el array con toda la información
        return $this->getArraySQL($sql);
    }
}


?>
