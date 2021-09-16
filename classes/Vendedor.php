<?php

namespace App;

class Vendedor extends ActiveRecord {
    public static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono', 'imagen'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $imagen;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? '';
        $this->nombre = $args["nombre"] ?? '';
        $this->apellido = $args["apellido"] ?? '';
        $this->telefono = $args["telefono"] ?? '';
        $this->imagen = $args["imagen"] ?? '';
    }

    public function validar() {
            if (!$this->nombre) {
                self::$errores[] = "Debes añadir un nombre";
            }
            if (!$this->apellido) {
                self::$errores[] = "Debes añadir un apellido";
            }
            if (!$this->telefono) {
                self::$errores[] = "Debes añadir un telefono";
            }
            if(!$this->imagen){
                self::$errores[] = "La imagen es obligatoria";
            }

            if( !preg_match('/[0-9]{10}/', $this->telefono) ) {
                self::$errores[] = "El telefono debe tener 10 digitos";
            }
            
            return static::$errores;
        }
}