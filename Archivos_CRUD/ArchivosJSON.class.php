<?php

    require_once 'AbstractArchivo.class.php';
    require_once 'iArchivosOBJ.php';

    class ArchivoJSON extends AbstractArchivo implements iArchivosOBJ {
        
        /**
         * Función constructora de la clase.
         * @param string $str_pathToFile
         * @author Varela Vargas Leandro
         */
        public function __construct($str_pathToFile) {
            parent::__construct($str_pathToFile, "json");
        }

        public function createFile() {
            $this->create_openFile('w');
            $this->closeFile();
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
            $ret = json_decode($arr_file[$nrLine], TRUE);
            return ($nrLine !== FALSE) ? $ret : NULL;
        }

        public function deleteOBJwithValue($value) {
            $nrLine = $this->findNrLineWithStr($value);
            return $this->deleteLine($nrLine);
        }

        public function readAllOBJ() {
            $arr = $this->readFile();
            $ret = array();

            foreach ( $arr as $key => $val ) {
                $aux = json_decode($val, TRUE);
                array_push($ret, $aux);
            }
            
            return $ret;
        }

    }

?>