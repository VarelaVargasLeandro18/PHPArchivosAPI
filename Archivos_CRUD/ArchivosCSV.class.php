<?php

    require_once "../iArchivosOBJ.php";
    require_once "../AbstractArchivo.class.php";

    class ArchivosCSV extends AbstractArchivo implements iArchivosOBJ {

        private $tableHeader;

        /**
         * Función constructora de la clase.
         * @param string $str_pathToFile. Path al archivo.
         * @param string $tableHeader. Encabezados de columnas.
         * @author Varela Vargas Leandro
         */
        public function __construct($str_pathToFile, $tableHeader= NULL) {
            parent::__construct($str_pathToFile, "csv");
            $this->tableHeader = $tableHeader;
        }

        public function createFile() {
            $this->create_openFile('w');
            
            if ( isset($this->tableHeader) ) {
                fputcsv($this->getFile(),
                        $this->tableHeader);
            }
                
            $this->closeFile();
        }

        public function insertOBJ($obj) {
            $ret = FALSE;

            if ( isset($obj) ) {
                $this->create_openFile('a');
                $ret = fputcsv( $this->getFile(),
                                $obj);
            }
            
            return $ret > 0;
        }

        public function readOBJwithValue($value) {
            $ret = NULL;
            $arr_file = $this->readFile();

            $nameAttrib = $this->obtenerNombreAtributo($value);
            $valueAttrib = $this->obtenerValorAtributo($value);

            $lineFileOBJ = $this->findNrLineWithStr($valueAttrib);
            
            $ret = (isset($arr_file) && 
                    $lineFileOBJ !== FALSE ) ? 
                    $arr_file[$lineFileOBJ] : NULL;

            if ( $lineFileOBJ !== FALSE && 
                    isset($this->tableHeader) &&
                    isset($ret) ) { // Si se encuentra una coincidencia...
                
                $attribs = strtoupper(implode(',', $this->tableHeader));
                $attribsArr = str_getcsv($attribs); // Separamos los valores del header.

                $nameAttribToUpper = strtoupper($nameAttrib);
                $valueToUpper = strtoupper($valueAttrib);

                $keyAttrib = array_search($nameAttribToUpper, $attribsArr);
                // Buscamos que el NOMBRE del atributo
                // se encuentre en el array de atributos y obtenemos su posicion.
                echo "<br/>";
                var_dump($attribsArr);
                echo "<br/>";
                var_dump($keyAttrib);
                echo "<br/>";
                var_dump($nameAttribToUpper);

                // A continuación comparamos que el valor que tiene el objeto
                // en la posición del $keyAttrib coincida con $valueToUpper
                if ( $keyAttrib !== FALSE ) {
                    $retValue = $ret[$keyAttrib];
                    $retValueStr = '' . $retValue;
                    $retValueStr = strtoupper($retValueStr);
                    $ret = ($retValueStr == $valueToUpper) ? $ret : NULL;
                }

            } 

            $ret = (isset($ret)) ? explode(",", $ret) : NULL;
            
            return $ret;
        }

        private function obtenerNombreAtributo($attribValue) {
            $both = ($attribValue);

            $posEndAtt = strpos($both, ":");
            $attribToUpper = substr($both, 0, $posEndAtt);
            var_dump($attribToUpper);
            $attribToUpper = str_replace('"', '', $attribToUpper);
            var_dump($attribToUpper);
            // Obtenemos el NOMBRE del atributo pedido.
            return $attribToUpper;
        }

        private function obtenerValorAtributo($attribValue) {
            $both = ($attribValue);
            $posEndAtt = strpos($both, ":");
            $posStartVal = $posEndAtt + 1;
            $valueToUpper = substr($attribValue, $posStartVal);
            // Obtenemos el VALOR del atributo pedido.
            return $valueToUpper;
        }

        public function deleteOBJwithValue($value){}

        public function readAllOBJ(){
            $arr = $this->readfile();
            $ret = array();

            foreach ( $arr as $key => $val ) {
                $aux = str_getcsv($val);
                array_push($ret, $aux);
            }

            return $ret;
        }

    }

?>