<?php
    class Utils{
        /**
         * Verifica se uma url é válida
         * @param url
         * @return boolean
         */
        public static function validateUrl($url){
            return preg_match("%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu", $url);
        }

        /**
         * Normaliza uma url colocando o protocolo http caso ela não possua nenhum
         * @param url A url não normalizada
         * @return string Url normalizada
         */
        public static function normalizeUrl($url) : string{
            if(! Utils::str_startWith($url, "http://") && ! Utils::str_startWith($url, "https://")){
                return "http://" . $url;
            }

            return $url;
        }

        /**
         * Checa se uma string começa com determinada sequencia de caracteres
         * @param str String original
         * @param start Caracteres iniciais para teste
         * @return boolean True caso tenha os caracteres no inicio, false caso contrario
         */
        public static function str_startWith($str, $start){
            return substr($str, 0, strlen($start)) === $start;
        }

        /**
         * Envia usuarios para a home caso seja necessario
         */
        public static function goToHome(){
            $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: $protocol$host$uri");
            
            die();
        }

        /**
         * Retorna a URL do servidor
         */
        public static function getHostUrl() : String{
            $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

            return "$protocol$host$uri";
        }

        /**
         * Testa colisões de urls encurtadas
         * @param lenght Tamanho do codigo curto
         * @param maxInteractions Quantidade de ids gerados para valiação
         */
        public static function testColision($lenght, $maxInterations){
            $a = array();
            $s = new Shorter($lenght);
            
            for($i = 1; $i < $maxInterations; $i++){
                $b = $s->encode(3);

                for($j = 0; $j < count($a); $j++){
                    if($a[$j] === $b){
                        echo "vetor[$j]: $a[$j] == vector[$i]: $b <br>";
                        break;
                    }
                }

                array_push($a, $b);
            }
            
            print_r($s->encode(3));
        }
    }
?>