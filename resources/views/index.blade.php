<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro de Corretores</title>
    <!-- Adicione o link para o arquivo CSS do Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<body>
<div class="container">
    <h1 class="text-center">Cadastro de Corretor</h1>
    <div id="statusMessage" class="mb-3"></div>
    <form id="corretorForm">
        <div class="input-group mb-2">
            <input type="hidden" name="id" />
            <input type="text" class="form-control mr-2" placeholder="Digite seu cpf" name="cpf" maxlength="11" required />
            <input type="text" class="form-control" placeholder="Digite seu creci" name="creci" maxlength="9" required />
        </div>

        <div class="mb-3">
            <input type="text" class="form-control mr-2" id="name" placeholder="Digite seu nome" name="name"/>
        </div>
            <button type="submit" class="btn btn-primary w-100 d-block">
                Enviar
            </button>
    </form>
    <table class="table" id="corretorTable">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">CPF</th>
            <th scope="col">Creci</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script>


document.addEventListener("DOMContentLoaded", function () {
    fazerRequisicaoGETTodos();
});

function fazerRequisicaoGETTodos() {
    var xhr = new XMLHttpRequest();
    var url = "http://localhost:8081/index";

    xhr.open("GET", url, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText)
            var resposta = JSON.parse(xhr.responseText);
            preencherTabela(resposta);
        }
    };
    xhr.send();
}


            function preencherTabela(corretores) {
    var tabela = document.querySelector("table tbody");
    tabela.innerHTML = "";

    corretores.forEach(function (corretor) {
        var row = document.createElement("tr");
        var idCell = document.createElement("td");
        idCell.textContent = corretor.id;
        row.appendChild(idCell);

        var nameCell = document.createElement("td");
        nameCell.textContent = corretor.name;
        row.appendChild(nameCell);

        var cpfCell = document.createElement("td");
        cpfCell.textContent = corretor.cpf;
        row.appendChild(cpfCell);

        var creciCell = document.createElement("td");
        creciCell.textContent = corretor.creci;
        row.appendChild(creciCell);

        var editCell = document.createElement("td");
        var editButton = document.createElement("button");
        editButton.classList.add("btn", "btn-secondary", "w-100", "d-block", "edit");
        editButton.textContent = "Editar";
        editCell.appendChild(editButton);
        row.appendChild(editCell);

        
        editButton.addEventListener("click", function (event) {
            event.preventDefault();
            var id = this.closest("tr").querySelector("td:first-child").innerText;
            fazerRequisicaoGET(id);
        });

        var deleteCell = document.createElement("td");
        var deleteButton = document.createElement("button");
        deleteButton.classList.add("btn", "btn-danger", "w-100", "d-block", "delete");
        deleteButton.textContent = "Excluir";
        deleteCell.appendChild(deleteButton);
        row.appendChild(deleteCell);

        deleteButton.addEventListener("click", function (event) {
            event.preventDefault();
            var id = this.closest("tr").querySelector("td:first-child").innerText;
            fazerRequisicaoDELETE(id);
        });


        tabela.appendChild(row);
    })
  };


            function mostrarMensagemStatus(mensagem, sucesso) {
                var statusMessage = document.getElementById("statusMessage");
                statusMessage.textContent = mensagem;
                statusMessage.classList.remove("text-success", "text-danger");
                statusMessage.classList.add(sucesso ? "text-success" : "text-danger");
            }

            function preencherCampos(cpf, creci, nome, id) {
                document.getElementsByName("cpf")[0].value = cpf;
                document.getElementsByName("creci")[0].value = creci;
                document.getElementsByName("id")[0].value = id;
                document.getElementById("name").value = nome;
                document.querySelector('button[type="submit"]').textContent = "Editar";
            }

          
            function fazerRequisicaoGET(id) {
                var xhr = new XMLHttpRequest();
                var url = "http://localhost:8081/" + id;

                xhr.open("GET", url, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var resposta = JSON.parse(xhr.responseText);
                        var cpf = resposta.cpf;
                        var creci = resposta.creci;
                        var nome = resposta.name;
                        var id = resposta.id;
                        preencherCampos(cpf, creci, nome, id);
                    }
                };
                xhr.send();
            }

            function fazerRequisicaoPOST(data) {
                var xhr = new XMLHttpRequest();
                var url = "http://localhost:8081/"; 
                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        console.log(xhr.status);
                        if (xhr.status === 200) {
                            mostrarMensagemStatus("Operação de cadastro realizada com sucesso.", true);
                            setTimeout(function () {
                                window.location.href = "/";
                            }, 1000);
                        } else {
                            mostrarMensagemStatus("Erro ao realizar operação de cadastro." + xhr.responseText, false);
                        }
                    }
                };
                xhr.send(JSON.stringify(data));
            }

            function fazerRequisicaoDELETE(id) {
                var xhr = new XMLHttpRequest();
                var url = "http://localhost:8081/" + id;

                xhr.open("DELETE", url, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            mostrarMensagemStatus("Operação de cadastro realizada com sucesso.", true);
                            setTimeout(function () {
                                window.location.href = "/";
                            }, 1000);
                        } else {
                            mostrarMensagemStatus("Erro ao realizar operação de cadastro.", false);
                        }
                    }
                };
                xhr.send();
            }



            var form = document.getElementById("corretorForm");
            form.addEventListener("submit", function (event) {
                event.preventDefault(); 
                var cpf = document.getElementsByName("cpf")[0].value;
                var creci = document.getElementsByName("creci")[0].value;
                var nome = document.getElementById("name").value;
                var id = document.getElementsByName("id")[0].value;

                console.log("reqeust");

                var data = {
                    id: id,
                    cpf: cpf,
                    creci: creci,
                    name: nome,
                };
                console.log(data)

                fazerRequisicaoPOST(data);
            });

        </script>
</body>
</html>
