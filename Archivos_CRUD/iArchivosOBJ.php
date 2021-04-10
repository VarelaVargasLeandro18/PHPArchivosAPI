<?php

    interface iArchivosOBJ {

        public function insertOBJ($obj);
        public function readOBJwithValue($value);
        public function deleteOBJwithValue($value);
        public function readAllOBJ();

    }

?>