<?php
    require_once("DBManager.php");
    require_once("Exceptions.php");

    class Shorter{
        private $dbm;
        private $base;
        private $baseSize;
        private $urlLength;

        const OK = 0;
        const ERROR = 1;

        public function __construct(int $urlLength){
            $this->dbm = new DBManager();
            $this->urlLength = $urlLength - 1;

            $lowcase = str_split("abcdefghijklmnopqrstuvwxyz");
            $uppercase = str_split(strtoupper("abcdefghijklmnopqrstuvwxyz"));
            $digits = str_split("0123456789");

            $this->base = array_merge($lowcase, $uppercase, $digits);
            $this->baseSize = count($this->base);
        }

        /**
         * Transforma um id em uma sequencia de caracteres curtos
         * @param num ID em tabela sql
         * @return string
         */
        private function encode(int $num) : string{
            $r = time() % $this->baseSize;
            $res = $this->base[$r];
            $q = floor($this->baseSize / $num);
            
            for ($i=0; $i < $this->urlLength; $i++) { 
                $r = ($q + time() + rand()) % $this->baseSize;
                $q = floor($this->baseSize + time() / $num + $i);
                $res = $this->base[$r] . $res;
            }
            
            return $res;
        }

        /**
         * Insere uma url no bd
         * @param url
         * @return string
         * @throws DBExecError
         * @throws DBQueryError
         */
        public function insert($url) : string{
            try{
                $command = "INSERT INTO WEB_URL(URL, ACCESS) VALUES ('$url', 0);";
                $this->dbm->exec($command);

                $id = $this->dbm->getLastInsertId();
                $short = $this->encode($id);

                $command = "UPDATE WEB_URL SET SHORT = '$short' WHERE ID = $id";
                $this->dbm->exec($command);

                return $short;
            }
            catch(DBExecError $e){
                echo $e;
            }
            catch(DBQueryError $e){
                echo $e;
            }
        }

        /**
         * Recupera o link original e o ID de uma url encurtada
         * @param short
         * @return object
         * @throws DBQueryError
         */
        public function getShortData($short){
            try{
                $command = "SELECT ID, URL FROM WEB_URL WHERE SHORT = '$short'";
                $res = $this->dbm->query($command);
                
                return $res;
            }
            catch(DBQueryError $e){
                echo $e;
            }
        }

        /**
         * Atualiza a quantidade de acessos a uma url encurtada
         * @param url
         * @throws DBExecError
         */
        public function updateShortClicks($id){
            try{
                $command = "UPDATE WEB_URL SET ACCESS = ACCESS + 1 WHERE ID = $id";
                $this->dbm->exec($command);
            }
            catch(DBExecError $e){
                echo $e;
            }
        }

        /**
         * Retorna JSON com a resposta para o front
         */
        public function generateResponse($type = Shorter::ERROR, $short = false, $msg = ""){
            if($type == Shorter::OK)
                return json_encode(array("status" => "ok", "short" => $short, "msg" => "Deu certo! :)"));
            else
                return json_encode(array("status" => "error", "short" => false, "msg" => "Deu ruim..."));
        }
    }
?>