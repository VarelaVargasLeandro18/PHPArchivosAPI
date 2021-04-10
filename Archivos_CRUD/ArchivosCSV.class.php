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
            $this->closeFile();
        }
        
    }

?>