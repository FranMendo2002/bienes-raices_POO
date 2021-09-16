<?php 

namespace App;

class Activerecord {
    
        // Base de datos
        protected static $db;
        protected static $columnasDB = [];
        protected static $tabla = '';

        // Validacion
        protected static $errores = [];

        // Definir la conexion a la BD
        public static function setDB($database) {
            self::$db = $database;
        }

        public function guardar() {
            if( empty($this->id) ) { // Actualizando - Devuelve true si la variable esta vacia
                $resultado = $this->crear();
                
            } else { // Creando
                $resultado = $this->actualizar();
            }
            return $resultado;
        }

        public function actualizar() {
            // Sanitizar la entrada de los datos
            $atributos = $this->sanitizarDatos();
            $valores = [];
            

            foreach($atributos as $key=> $value) {
                $valores[] = "$key = '{$value}'";
            }
            $stringUpdate = join(', ', $valores);
            $query = "UPDATE ". static::$tabla . " SET {$stringUpdate} WHERE id=" . self::$db->escape_string($this->id) . " LIMIT 1";
            $resultado = self::$db->query($query);
            
            if ($resultado) {
                // Redireccionar al usuario
                header('Location: /admin?resultado=2');
            }
        }

        public function crear() {
            // Sanitizar la entrada de los datos
            $atributos = $this->sanitizarDatos();
            $columnas = join(", ", array_keys($atributos));
            $valores = join("', '", array_values($atributos) );

            $query = "INSERT INTO " . static::$tabla ." (${columnas}) VALUES ('${valores}')";
            $resultado = self::$db->query($query);
            return $resultado;
        }

        // Identificar y unir los atributos de la base de datos
        public function atributos() {
            $atributos = [];
            foreach(static::$columnasDB as $columna) {
                if($columna === 'id') continue;
                $atributos[$columna] = $this->$columna;
            }
            return $atributos;
        }
        
        // Eliminar un registro
        public function eliminar() {
            $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
            $resultado = self::$db->query($query);
            if($resultado) {
                $this->borrarImagen();
                header('Location: /admin?resultado=3');
            }
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
            // Eimina la imagen previa
            $this->borrarImagen();
            if($imagen) {
                    $this->imagen = $imagen;
                }
        }

        // Eliminar archivo
        public function borrarImagen() {
            $existeImg = file_exists(CARPETA_IMAGENES . $this->imagen);
            if( $existeImg ) { // Si existe la imagen. En el crear todavia no esta subida asi que no entraria aca
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }

        // Validación
        public static function getErrores() {
            return static::$errores;
        }

        public function validar() {
            static::$errores = [];
            return static::$errores;
        }

        // Listar todos los registros
        public static function all() {
            $query = "SELECT * FROM " . static::$tabla;
            $resultado = self::consultarSQL($query);
            return $resultado;
        }

        // Busca un registro por su id
        public static function find($id) {
            $query = "SELECT * FROM " . static::$tabla . " WHERE id=${id}";
            $resultado = self::consultarSQL($query);
            return array_shift($resultado);
        }

        public static function consultarSQL($query) {
            // Consultar la BD
            $resultado = self::$db->query($query);
            // Iterar los resultados
            $array = [];
            while($registro = $resultado->fetch_assoc() ) {
                $array[] = static::crearObjeto($registro);
            }

            // Liberar la memoria
            $resultado->free();

            // Retornar los resultados
            return $array;
        }

        protected static function crearObjeto($registro) {
            $objeto = new static;
            
            foreach($registro as $key => $value){
                // que una propiedad exista, toma 2 parametros
                if( property_exists($objeto, $key) ) { 
                    $objeto->$key = $value;
                }
            }
            return $objeto;
        }

        // Sincroniza el objeto en memoria con los cambios realizados por el usuario
        public function sincronizar($args = []) {
            foreach($args as $key => $value) {
                if( property_exists($this, $key) && !is_null($value)){
                    $this->$key = $value;
                }
            }
        }
}