<?php

    abstract class AbstractArchivo {

        private $str_pathToFile;
        private $str_fileType;

        public function __construct ( $str_pathToFile, $str_fileType ) {
            
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

        public function getPathToFile() {
            return $this->str_pathToFile;
        }

        public function getFileType() {
            return $this->str_fileType;
        }

        

    }

?>