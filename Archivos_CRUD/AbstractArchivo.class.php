<?php

    /**
     * Clase que permitirá manejar la creación de archivos para Alta, Baja y Modificación de objetos en el mismo.
     * @abstract
     * @author Varela Vargas Leandro Gastón
     */
    abstract class AbstractArchivo {

        /**
         * Atributo que contendrá el PATH hacia el archivo.
         * @var String
         */
        private $str_pathToFile;

        /**
         * Atributo que contendrá el TIPO de archivo.
         * @var String
         */
        private $str_fileType;

        /**
         * Función constructura de la clase.
         * @param String $str_pathToFile PATH del archivo.
         * @param String $str_fileType TIPO de archivo.
         */
        protected function __construct ( $str_pathToFile, $str_fileType ) {
            
            $isAnyNull = !(isset($str_pathToFile) && isset($str_fileType));
            
            if ( $isAnyNull )
                throw new Exception("Ningún atributo puede ser NULL.");
            
            $this->str_pathToFile = $str_pathToFile;

            if ( !( str_ends_with($str_pathToFile, $str_fileType) ) ) {
                if ( !( str_ends_with($str_pathToFile, $str_fileType) ) ) 
                    $this->str_pathToFile .= ".";
                $this->str_pathToFile .= $str_fileType;
            }

            $this->str_fileType = $str_fileType;

        }

        // ========= GETTERS =========

        /**
         * Getter del atributo str_pathToFile.
         * @return String atributo str_pathToFile.
         */
        public final function getPathToFile() {
            return $this->str_pathToFile;
        }

        /**
         * Getter del atributo str_fileType.
         * @return String atributo str_fileType.
         */
        public final function getFileType() {
            return $this->str_fileType;
        }

        // ========= FIN GETTERS =========

        /**
         * Función que permite la creación u apertura del archivo (de ser posible).
         * @param String $modo modo en el que el archivo se abrirá.
         * @return FILE|bool puntero al archivo. En caso de error devuelve false.
         */
        protected final function crear_abrirArchivo( $modo ) {
            return fopen($this->str_pathToFile, $modo, false);
        }

        /**
         * Función que permitirá cerrar un puntero al archivo-
         * @param FILE $ar puntero al archivo.
         * @return bool TRUE si se pudo cerrar el archivo. FALSE caso contrario.
         */
        protected final function cerrarArchivo( $ar ) {
            return fclose($ar);
        }

    }

?>