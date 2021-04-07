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
            $this->str_fileType = $str_fileType;

        }

        

    }

?>