<?php

    class Usuario {

        private $nombre;
        private $clave;
        private $email;

        public function __construct ($nombre, $clave, $mail) {
            $this->nombre = $nombre;
            $this->clave = $clave;
            $this->email = $mail;
        }

    }

?>