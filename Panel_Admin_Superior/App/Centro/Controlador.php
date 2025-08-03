<?php

// definición de la clase base controlador, común en el patrón MVC
class Controlador {

    //Método para cargar un modelo
    public function modelo($modelo) {
        //incluye el archivo modelo desde la carpeta /Modelo/
        require_once __DIR__ . '/../Modelo' . $modelo . '.php';

        //crea y retorna una nueva instancia del modelo
        return new $modelo();
    }

    // Metodo para cargar una vista
    public function vista($vista, $datos = []) {
    //incluye el archivo de la vista desde la carpeta /Vista/
    // la variable $datos (opcional) se puede usar dentro de la vista para pasar información
        require_once __DIR__ . '/../Vista' . $vista . '.php';
    }
}