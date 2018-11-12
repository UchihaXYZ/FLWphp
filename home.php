<?php
    require_once("./Core/Configs.php");
    require_once("./Core/Utils.php");

    // Bloqueia acesso direto a esse arquivo (sem nenhuma razão especifica pra ser sincero =/)
    if(get_included_files()[0] == __FILE__)
        Utils::goToHome();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" media="screen" href="./src/css/style.css" />
        
        <title><?php echo Configs::TITLE . " | " . Configs::DESC; ?></title>
    </head>
    <body class="bg-dark text-light">
        <header class="container">
            <div class="row">
                <div class="col-sm text-center">
                    <h2><?php echo Configs::TITLE; ?></h2>
                </div>
            </div>
        </header>

        <main role="main" class="container">
            <div class="row">
                <div class="col-sm">
                    <div class="input-group mb-1">
                        <input id="tb-url" type="text" class="form-control" placeholder="Digite uma URL aí..." aria-label="Digite uma URL aí..." aria-describedby="URL a ser inserida">
                        <div class="input-group-append">
                            <button id="btn-short" class="btn btn-secondary" type="button">Encurtar!</button>
                        </div>
                    </div>
                    <span id="msg-info" class="d-none">info</span>

                    <div id="msg" class="alert alert-success d-none" role="alert">
                        Mensagem de resultado da operação tehe :P
                    </div>
                </div>
            </div>
        </main>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        Copyright &copy <?php echo date("Y") . " " . Configs::COPYRIGHT; ?>.
                    </div>
                    <div class="col-sm text-right">
                        <a href="#" title="">Sobre</a> <a href="#" title="">Estatisticas</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- JS Trash -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="./src/js/main.js"></script>
    </body>
</html>