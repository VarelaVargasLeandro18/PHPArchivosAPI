<?php

    interface iArchivosOBJ {

        public function insertOBJ($obj);
        public function readOBJwithValue($attrib);
        public function deleteOBJwithValue($attrib);
        public function readAllOBJ();

    }

?>