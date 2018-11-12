function UIManager(){
    let button = document.getElementById("btn-short");
    let textBox = document.getElementById("tb-url");
    let msgInfo = document.getElementById("msg-info");
    let msgOK = document.getElementById("msg");

    /**
     * Valida um texto como sendo uma url
     * @param {string} input 
     */
    let validateUrl = function (input){
        let val = /^(?:http(s)?:\/\/)?[\w]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/gm;

        return val.test(input);
    }

    /**
     * Faz e lida com requisição ao backend
     * @param {string} url 
     */
    let sendData = function (url){
        let xhs = new XMLHttpRequest();

        xhs.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let m = JSON.parse(this.responseText);
                msgOK.innerHTML = m.short;
                msgOK.classList.remove("d-none");
            }
            else if(this.readyState == 4 && this.status == 400){
                setErrorMsg("Parece que temos um xerox homes por aqui!");
            }
        }

        xhs.open("POST", "./save", true);
        xhs.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhs.send("url="+ url);
    }

    /**
     * Tenta enviar ao backend a URL do textbox
     */
    let sendInputData = function (){
        let input = textBox.value;

        if(! input == ""){
            let res = validateUrl(input);

            if(res)
                sendData(input);
            else
                setErrorMsg("Usa uma URL válida ai parça...");
        }
    }

    /**
     * Seta mensagem de erro e estilizações a UI quando o texto não é uma URL válida
     * @param {string} text 
     */
    let setErrorMsg = function (text){
        button.disabled = true;
        textBox.classList.add("is-invalid");

        msgInfo.textContent = text;
        msgInfo.classList.replace("d-none", "text-danger");
        
        let handler = function(){
            button.disabled = false;
            msgInfo.classList.replace("text-danger", "d-none");
            textBox.classList.remove("is-invalid");
            textBox.removeEventListener("keyup", handler, false);
        }

        textBox.addEventListener("keyup", handler);
    }

    /**
     * Inicia elementos da interface, setando listeners
     */
    let setupElements = function (){
        // Envia dados ao clicar no botao
        button.addEventListener('click', function(){
            sendInputData();
        });

        // Envia dados ao pressionar tecla enter
        textBox.addEventListener('keyup', function (event){
            event.preventDefault();

            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                sendInputData();
            }
        });
    }

    /**
     * Chama as funções necessárias ao instanciar a classe
     */
    let init = function (){
        setupElements();
    }

    init();
}

ui = new UIManager();
