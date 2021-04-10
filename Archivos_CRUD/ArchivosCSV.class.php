<?php

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
                $ret = fputcsv($this->getFile(),
                                $obj);
            }
            
            return $ret > 0;
        }

        public function readOBJwithValue($value) {
            $ret = NULL;
            $arr_file = $this->readFile();
            $lineFileOBJ = $this->findNrLineWithStr($value);
            $ret = (isset($arr_file) && 
                    $lineFileOBJ !== FALSE ) ? 
                    $arr_file[$lineFileOBJ] : NULL;

            if ( $lineFileOBJ !== FALSE && 
                    isset($this->header) &&
                    isset($ret) ) { // Si se encuentra una coincidencia...

                $attribs = strtoupper($this->tableHeader);
                $attribsArr = str_getcsv($attribs); // Separamos los valores del header.

                $valueToUpper = strtoupper($value);

                $posEndAtt = strpos($valueToUpper, ":");
                $attribToUpper = substr($valueToUpper, 0, $posEndAtt);
                $attribToUpper = str_replace($attribToUpper, "\"", ''); 
                // Obtenemos el NOMBRE del atributo pedido.

                $posStartVal = $posEndAtt + 1;
                $valueToUpper = substr($valueToUpper, $posStartVal);
                // Obtenemos el VALOR del atributo pedido.

                $keyAttrib = array_search($attribToUpper, $attribsArr);
                // Buscamos que el NOMBRE del atributo
                // se encuentre en el array de atributos y obtenemos su posicion.
                
                // A continuación comparamos que el valor que tiene el objeto
                // en la posición del $keyAttrib coincida con $valueToUpper
                if ( $keyAttrib !== FALSE ) {
                    $retValue = $ret[$keyAttrib];
                    $retValueStr = '' . $retValue;
                    $retValueStr = strtoupper($retValueStr);
                    $ret = ($retValueStr == $valueToUpper) ? $ret : NULL;
                }

            } 
            
            return $ret;
        }

    }

?>