<?php
// importa el modelo reporte, donde se encuentra la logica para obtener los datos de la base de datos
require_once __DIR__ . '/../Modelo/Reporte.php';

//define la clase ReporteControlador que se encargara de controlar la logica de los reportes
class ReporteControlador {

    //funcion publica que consulta las ventas de una fecha especifica
    public function consultarPorFecha($fecha_inicio, $fecha_fin) {
        $modelo = new Reporte(); // crea una instancia del modelo reporte
        //llama al metodo del modelo para obtener las ventas de esa fecha
        return $modelo->obtenerVentasPorFecha($fecha_inicio,$fecha_fin);
    }


    //con esta funcion se registran los informes una vez se haya imprimido
    //se guarda la informacion en la tabla infromes con todos los datos necesarios
    // esto se hace para llevar un control y validacion de quien genera los reportes
    public function registrarInforme($fecha_inicio, $fecha_fin, $descripcion, $idAdmin){
        $modelo = new Reporte();
        return $modelo->guardarInforme($fecha_inicio, $fecha_fin, $descripcion, $idAdmin);
    }

    
}
