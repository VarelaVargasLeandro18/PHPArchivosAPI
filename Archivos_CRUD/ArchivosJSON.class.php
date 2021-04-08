<?php

    require_once 'AbstractArchivo.class.php';

    class ArchivoJSON extends AbstractArchivo implements iArchivosOBJ {
        
        public function __construct($str_pathToFile) {
            parent::__construct($str_pathToFile, "json");
        }
        
        public function insertOBJ($obj) {
            $str_insert = json_encode($obj);
            $ret = FALSE;

            if ( $str_insert ) {
                $this->create_openFile("a");
                $ret = $this->write_appendLine($str_insert);
            }
            
            return $ret;
        }

    }

?>