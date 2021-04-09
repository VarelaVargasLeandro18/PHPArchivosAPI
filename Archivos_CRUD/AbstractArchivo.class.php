<?php

    /**
     * Clase que permitirá manejar la creación de archivos para Alta, Baja y Modificación de objetos en el mismo.
     * @abstract
     * @author Varela Vargas Leandro Gastón
     */
    abstract class AbstractArchivo {

        /**
         * Atributo que contendrá el PATH hacia el archivo.
         * @var string
         */
        private $str_pathToFile;

        /**
         * Atributo que contendrá el TIPO de archivo.
         * @var string
         */
        private $str_fileType;

        /**
         * Atributo que contendrá el MODO en que se ha abierto el archivo.
         * @var string
         */
        private $str_mode;

        /**
         * Atributo que contendrá el PUNTERO al archivo.
         * @var resource
         */
        private $file;

        /**
         * Atributo que contendrá la cantidad de líneas del archivo.
         * @var int
         */
        private $file_lines;

        /**
         * Función constructura de la clase.
         * @param string $str_pathToFile PATH del archivo.
         * @param string $str_fileType TIPO de archivo.
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
         * @return string atributo str_pathToFile.
         * @author Varela Vargas Leandro.
         */
        public final function getPathToFile() {
            return $this->str_pathToFile;
        }

        /**
         * Getter del atributo str_fileType.
         * @return string atributo str_fileType.
         * @author Varela Vargas Leandro.
         */
        public final function getFileType() {
            return $this->str_fileType;
        }

        /**
         * Getter del atributo file_lines.
         * @return int atributo file_lines.
         * @author Varela Vargas Leandro.
         */

        // ========= FIN GETTERS =========

        /**
         * Función que permite la creación u apertura del archivo (de ser posible).
         * @param string $str_mode modo en el que el archivo se abrirá.
         * @return bool TRUE en caso de éxito. Caso contrario FALSE.
         * @author Varela Vargas Leandro.
         */
        protected final function create_openFile( $str_mode ) {
            
            if ( isset($this->file) ) {
                fclose($this->file);
            }

            $this->str_mode = $str_mode;
            $this->file = fopen($this->str_pathToFile, $str_mode);
            return ( $this->file !== FALSE );
        }

        /**
         * Función que permitirá cerrar un puntero al archivo-
         * @return bool TRUE si se pudo cerrar el archivo. FALSE caso contrario.
         * @author Varela Vargas Leandro.
         */
        protected final function closeFile() {
            return fclose($this->file);
        }

        /**
         * Función que permitirá agregar una línea de ser posible.
         * @param string $str_line línea a agregar. NO debe incluir el salto de línea.
         * @param int $int_length cantidad de caracteres a ser agregados.
         * @return bool TRUE si se pudo agregar. FALSE caso contrario.
         * @author Varela Vargas Leandro.
         */
        public final function write_appendLine( $str_line, $int_length = null ) {
            fputs($this->file, $str_line . "\n", $int_length);
        }

        /**
         * Función que permitirá leer el documento completo. Si no está abierto lo abre automáticamente.
         * @return Array|bool un array con cada línea del documento. FALSE si no pudo leer el archivo.
         * @author Varela Vargas Leandro.
         */
        protected final function readFile() {
            $ret = file( $this->str_pathToFile );
            $this->file_lines = count($ret);

            return $ret;
        }

        /**
         * Función que permitirá sobreescribir un archivo completo.
         * @param mixed  $data datos a imprimir en el documento.
         * @return bool TRUE si pudo realizar la operación. FALSE caso contrario.
         * @author Varela Vargas Leandro.
         */
        protected final function writeFile($data) {
            file_put_contents( $this->str_pathToFile, $data );
        }

        /**
         * Función que permitirá rebobinar el archivo.
         * @return bool TRUE si pudo realizarse la operación. FALSE caso contrario.
         * @author Varela Vargas Leandro.
         */
        protected final function rewind() {
            return rewind($this->file);
        }

        /**
         * Función que permitirá, de ser posible, la sobreescritura de una línea dada.
         * NO USAR PARA ARCHIVOS GRANDES.
         * @param int $line_nr número de línea, comenzando en línea 0.
         * @param string $str nuevo valor de línea.
         * @return bool TRUE si se ha logrado sobreescribir la línea. FALSE caso contrario.
         * @author Varela Vargas Leandro.
         */
        protected final function rewriteLine($line_nr, $str) {
            $lines_count = 0;
            $ret = false;
            $lines = $this->readFile();
            
            if ( count($lines) >= $line_nr  ) {
                unset($lines[$line_nr]);
                $this->writeFile($lines);
            }
            
            return $ret > 0;
        }

        /**
         * Función que permitirá encontrar una línea que tenga una cadena de caracteres determinada.
         * Devuelve la primer coincidencia.
         * @param string $str Cadena a buscar.
         * @return int|bool Número de línea que contenga la cadena de caracteres especificada. FALSE si no encuentra nada.
         * @author Varela Vargas Leandro.
         */
        protected final function findNrLineWithStr($str) {
            $file_array = file($this->str_pathToFile, FILE_IGNORE_NEW_LINES);
            $ret = FALSE;

            foreach ( $file_array as $key => $val ) {
                if ( str_contains($val, $str) ) {
                    $ret = $key;
                    break;
                }
            }
            return $ret;
        }

        /**
         * Función que permitirá borrar una línea del archivo.
         * @param int $line_nr
         * @return bool TRUE si pudo efectuarse la operación.
         * @author Varela Vargas Leandro.
         */
        protected final function deleteLine($line_nr) {
            $lines_count = 0;
            $ret = false;
            $lines = $this->readFile();
            
            if ( count($lines) >= $line_nr  ) {
                unset($lines[$line_nr]);
                $this->writeFile($lines);
            }
            
            return $ret > 0;
        }

    }

?>