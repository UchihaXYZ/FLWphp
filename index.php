<?php
    require_once("./Core/AltoRouter.php");
    require_once("./Core/Shorter.php");
    require_once("./Core/Configs.php");
    require_once("./Core/Utils.php");

    $router = new AltoRouter();                                 // Instancia gerenciador de rotas
    $router->setBasePath(Configs::BASE_PATH);                   // Configura caminho do projeto
    $router->addMatchTypes(array("short" => "[a-zA-Z0-9]{5}")); // Cria expressao regular para rota de redirecionamento
    $shorter = new Shorter(5);                                  // Instancia o ecurtador

    // Cria rota para a home
    $router->map( "GET", "/", function() {
        include_once("./home.php");
    }, "home");

    // Cria rota para processar pedidos de informação sobre link encurtado
    $router->map("GET", "/info/[short:short]", function($short) {
        
    }, "info");

    // Cria rota para processar pedidos de redirecionamento
    $router->map("GET", "/[short:short]", function($shorter, $short) {
        $link = $shorter->getShortData($short);

        if($link){
            //echo "voce foi redirecionado, pode acreditar\nid: $link->ID | url: $link->URL";

            $shorter->updateShortClicks($link->ID);
            header("Location: $link->URL");
            die();
        }else
            Utils::goToHome();

    }, "short");

    // Cria rota para processar pedidos de encurtamento
    $router->map("POST", "/save", function($shorter) {
        $url = $_POST["url"];
        $url = filter_var($url, FILTER_SANITIZE_URL);   // Remove os caracteres ilegais
        $url = Utils::normalizeUrl($url);               // Coloca protocolo http caso não possua

        header('Content-type: application/json');       // Define o tipo de conteudo para JSON

        // Checa se é uma url valida
        if(Utils::validateUrl($url)){
            $value = $shorter->insert($url);    // adiciona ao bd

            http_response_code(200);
            echo $shorter->generateResponse(Shorter::OK, Utils::getHostUrl() . "/$value", "a");
        }
        else{
            http_response_code(400);
            echo $shorter->generateResponse();
        }

        die();

    }, "save");

    $match = $router->match();  // Checa se alguma das rotas foi alcansada
    
    // Processa de acordo com a rota
    switch($match["name"]){
        case "home":
            $match["target"]();
            break;
        case "short":
            $param = $match["params"]["short"];
            $match["target"]($shorter, $param);
            break;
        case "info":
            $param = $match["params"]["short"];
            $match["target"]($param);
            break;
        case "save":
            $match["target"]($shorter);
            break;
        default:
            Utils::goToHome();
            break;
    }

    die();
?>