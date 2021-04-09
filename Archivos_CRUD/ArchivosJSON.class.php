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

        public function readOBJwithValue($value) {
            $arr_file = $this->readFile();
            $nrLine = $this->findNrLineWithStr($value);
            return ($nrLine !== FALSE) ? $arr_file[$nrLine] : false;
        }

        public function deleteOBJwithValue($value) {
            $nrLine = $this->findNrLineWithStr($value);
            return $this->deleteLine($nrLine);
        }

    }

?>