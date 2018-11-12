<?php
    class DBExecError extends Exception{
        public function __construct() {
            parent::__construct("Ocorreu um erro ao inserir o dado no DB", 0, null);
        }

        // personaliza a apresentação do objeto como string
        public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
        }
    }

    class DBQueryError extends Exception{
        public function __construct() {
            parent::__construct("Ocorreu um erro ao buscar um dado no DB", 0, null);
        }

        // personaliza a apresentação do objeto como string
        public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
        }
    }
?>