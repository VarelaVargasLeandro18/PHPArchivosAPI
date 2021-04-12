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
            $arr = NULL;
            $lineNr = $this->buscarLineaPorValor($value, $arr);

            $lineWithValue = ( isset($lineNr) ) ? $arr[$lineNr] : NULL;
            $ret = (isset($lineWithValue)) ? explode(",", $lineWithValue) : NULL;
            
            return $ret;
        }

        public function deleteOBJwithValue($value){
            $arr = NULL;
            $lineNr = $this->buscarLineaPorValor($value, $arr);

            if ( isset($lineNr) )
                $this->deleteLine($lineNr);
        }

        public function readAllOBJ(){
            $arr = $this->readfile();
            $ret = array();

            foreach ( $arr as $key => $val ) {
                $aux = str_getcsv($val);
                array_push($ret, $aux);
            }

            return $ret;
        }

        private function obtenerNombreAtributo($attribValue) {
            $both = ($attribValue);

            $posEndAtt = strpos($both, ":");
            $attribToUpper = substr($both, 0, $posEndAtt);
            $attribToUpper = str_replace('"', '', $attribToUpper);
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

        private function buscarLineaPorValor($value, &$fileContent) {
            $arr_file = $this->readFile();
            $nameAttrib = $this->obtenerNombreAtributo($value);
            $valueAttrib = $this->obtenerValorAtributo($value);

            $lineFileOBJ = $this->findNrLineWithStr($valueAttrib);
            
            $ret = (isset($arr_file) && 
                    $lineFileOBJ !== FALSE ) ? 
                    $arr_file[$lineFileOBJ] : NULL;

            if ( isset($this->tableHeader) &&
                    isset($ret) ) { // Si se encuentra una coincidencia y el csv tiene header...
                
                $attribsHeader = strtoupper(implode(',', $this->tableHeader));
                $attribsArrHeader = str_getcsv($attribsHeader); // Separamos los valores del header.

                $nameAttribToUpper = strtoupper($nameAttrib);
                $valueToUpper = strtoupper($valueAttrib);

                $indexAttribHeader = array_search($nameAttribToUpper, $attribsArrHeader);
                // Buscamos que el NOMBRE del atributo
                // se encuentre en el array de atributos y obtenemos su posicion.

                if ( $indexAttribHeader !== FALSE ) {
                    $retValue = $ret[$indexAttribHeader];
                    $retValueStr = '' . $retValue;
                    $retValueStr = strtoupper($retValueStr);
                    $ret = ($retValueStr == $valueToUpper) ? $ret : NULL;

                    $fileContent = $arr_file; 
                }
                // Comparamos que el valor que tiene el objeto
                // en la posición del $keyAttrib coincida con $valueToUpper
            } 

            return $lineFileOBJ;
        }

    }

?>