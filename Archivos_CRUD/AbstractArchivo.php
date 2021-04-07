<?php

    abstract class AbstractArchivo {

        private $file;
        private $str_pathToFile;
        private $str_fileType;

        public function __construct ( $file, $str_pathToFile, $str_fileType ) {
            
            $isAnyNull = !(isset($file) && isset($str_pathToFile) && isset($str_fileType));
            
            if ( $isAnyNull )
                throw new Exception("Ningún atributo puede ser NULL.");

            $this->file = $file;
            
            $this->str_pathToFile = $str_pathToFile;
            
            if ( !str_ends_with($str_pathToFile, "/" . $file["name"]) ) { // Si el PATH NO termina con el nombre del archivo...

                if ( !str_ends_with($str_pathToFile, "/") ) { // Si el PATH no termina con "/"...
                    $this->str_pathToFile .= "/"; // Le agregamos "/"
                }

                $this->str_pathToFile .= $file["name"]; // Le agregamos el nombre del archivo.

            }
            
            $this->str_fileType = $str_fileType;

        }

    }

?>