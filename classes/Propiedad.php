<?php

    namespace App;


class Propiedad {

        // Base de datos
        protected static $db;
        protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

        // Validacion
        protected static $errores = [];

        public $id;
        public $titulo;
        public $precio;
        public $imagen;
        public $descripcion;
        public $habitaciones;
        public $wc;
        public $estacionamiento;
        public $creado;
        public $vendedorId;

        // Definir la conexion a la BD
        public static function setDB($database) {
            self::$db = $database;
        }

        public function __construct($args = []) {
            $this->id = $args["id"] ?? '';
            $this->titulo = $args["titulo"] ?? '';
            $this->precio = $args["precio"] ?? '';
            $this->imagen = $args["imagen"] ?? '';
            $this->descripcion = $args["descripcion"] ?? '';
            $this->habitaciones = $args["habitaciones"] ?? '';
            $this->wc = $args["wc"] ?? '';
            $this->estacionamiento = $args["estacionamiento"] ?? '';
            $this->creado = date('Y/m-d');
            $this->vendedorId = $args["vendedorId"] ?? '';
        }

        public function guardar() {

            // Sanitizar la entrada de los datos
            $atributos = $this->sanitizarDatos();
            $columnas = join(", ", array_keys($atributos));
            $valores = join("', '", array_values($atributos) );

            $query = "INSERT INTO propiedades (${columnas}) VALUES ('${valores}')";
            $resultado = self::$db->query($query);
            return $resultado;
        }

        // Identificar y unir los atributos de la base de datos
        public function atributos() {
            $atributos = [];
            foreach(self::$columnasDB as $columna) {
                if($columna === 'id') continue;
                $atributos[$columna] = $this->$columna;
            }
            return $atributos;
        }

        public function sanitizarDatos() {
            $atributos = $this->atributos();
            $sanitizado = [];
            foreach($atributos as $key => $value){
                $sanitizado[$key] = self::$db->escape_string($value);
            }
            return $sanitizado;
        }

        // Subida de archivos
        public function setImagen($imagen) {
            // Asignamos al atributo el nombre de la imagen
            if($imagen) {
                $this->imagen = $imagen;
            }
        }

        // Validación
        public static function getErrores() {
            return self::$errores;
        }

        public function validar() {
            if (!$this->titulo) {
                self::$errores[] = "Debes añadir un titulo";
            }

            if (!$this->precio) {
                self::$errores[] = "El precio es obligatorio";
            }

            if (strlen($this->descripcion) < 50) {
                self::$errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
            }

            if (!$this->habitaciones) {
                self::$errores[] = "El número de habitaciones es obligatorio";
            }

            if (!$this->wc) {
                self::$errores[] = "El número de baños es obligatorio";
            }

            if (!$this->estacionamiento) {
                self::$errores[] = "El número de estacionamientos es obligatorio";
            }

            if (!$this->vendedorId) {
                self::$errores[] = "Elige un vendedor";
            }

            if(!$this->imagen){
                self::$errores[] = "La imagen es obligatoria";
            }
            
            return self::$errores;
        }

        // Listar todas las propiedades
        public static function all() {
            $query = "SELECT * FROM propiedades";
            self::consultarSQL($query);
        }

        public static function consultarSQL($query) {
            // Consultar la BD
            $resultado = self::$db->query($query);
            // Iterar los resultados
            $array = [];
            while($registro = $resultado->fetch_assoc() ) {
                $array[] = self::crearObjeto($registro);
            }
            debugear($array);
            // Liberar la memoria

            // Retornar los resultados
        }

        protected static function crearObjeto($registro) {
            $objeto = new self;
            
            foreach($registro as $key => $value){
                // que una propiedad exista, toma 2 parametros
                if( property_exists($objeto, $key) ) { 
                    $objeto->$key = $value;
                }
            }
            return $objeto;
        }

    }