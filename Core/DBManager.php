<?php
    require_once("Configs.php");
    require_once("Exceptions.php");

    /**
     * SQLite connnection
     */
    class DBManager {
        private $pdo;
    
        public function __construct(){
            try{
                $this->connect();
                $this->check();
            }
            catch (PDOException $e){
                echo $e->getMessage();
            }
        }

        /**
         * Instancia um objeto PDO que se conecata ao BD SQLite
         */
        private function connect() {
            $this->pdo = new PDO("sqlite:" . Configs::PATH_TO_SQLITE_FILE);
        }

        /**
         * Cria tabela do BD caso seja necessário
         */
        private function check(){
            $command = "CREATE TABLE IF NOT EXISTS WEB_URL(
                ID INTEGER PRIMARY KEY AUTOINCREMENT,
                URL TEXT NOT NULL,
                SHORT TEXT,
                ACCESS INTEGER NOT NULL)";

            $this->pdo->exec($command);
        }

        /**
         * Executa comandos de alteração dos dados do BD
         * @param sql Pode ser uma consulta do tipo INSERT ou UPDATE
         * @throws DBExecError Caso ocorra um erro ou executar a consulta
         */
        public function exec($sql){
            $res = $this->pdo->exec($sql);
            
            if(! $res)
                throw new DBExecError();
        }

        /**
         * Executa o comando de busca SELECT
         * @param sql String contendo o comando
         * @return object Objeto com os compos requisitados no select
         * @throws DBQueryError Caso a consulta falhe
         */
        public function query($sql){
            $res = $this->pdo->query($sql);

            if($res)
                return $res->fetch(PDO::FETCH_OBJ);
            else
                throw new DBQueryError();
        }

        /**
         * Retorna o ID do ultimo elemento inserido
         * @return int
         */
        public function getLastInsertId() : int{
            return $this->pdo->lastInsertId();
        }
    }
?>