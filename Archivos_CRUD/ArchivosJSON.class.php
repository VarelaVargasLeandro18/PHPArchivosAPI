<?php

    require_once 'AbstractArchivo.class.php';

    class ArchivoJSON extends AbstractArchivo {
        
        public function __construct($str_pathToFile) {
            parent::__construct($str_pathToFile, "json");
        }
        
    }

?>