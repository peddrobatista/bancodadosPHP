<?php
    $servername = "localhost";
    $username ="root";
    $password = "";
    $dbname = "phpcrud";
    $id = $nome = $email = $telefone = $endereco = "";
    $errorMessage = $successMessage = "";
    // Criando conexão

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Defina o modo de erro PDO como exeção
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            // Métod GET: Mostra os dados do cliente
            if (!isset($_GET["id"])) {
                header("location:/bancodadosAjax/index.php");
                exit;
            }
            $id = $_GET["id"];
             
            // Leia a linha do cliente selecionado da tabela do banco de dados
            
            $stmt = $conn->prepare("SELECT * FROM clientes WHERE id=$id");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                header("location: /bancodadosAjax/index.php");
                exit;
            }

            // Defina a matriz resultante como associativa

            foreach($result as $key => $value) {
                $nome = $value["nome"];
                $email = $value["email"];
                $telefone = $value["telefone"];
                $endereco = $value["endereco"];
              }
        } else {
            // Método POST: Atualiza os dados do cliente
            $id = $_POST["id"];
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $telefone = $_POST["telefone"];
            $endereco = $_POST["endereco"];

            do {
                // Verifica se todos os campos foram preenchidos
                if (empty($id) || empty($nome) || empty($email) || empty($telefone) || empty($endereco)) {
                    $errorMessage = "Todos os campos são obrigatórios!";
                    break;
                }
                $sql = "UPDATE clientes SET nome='$nome', email='$email', telefone='$telefone', endereco='$endereco' WHERE id=$id";

                // Preparando a declaração
                $result = $conn->prepare($sql);

                // Executando a consulta
                $result->execute();
                if (!$result) {
                    // Mensagem de erro se a atualização der errada
                    break; // A mensagem de erro será exibida na condição catch abaixo
                }
                $successMessage = "Registro atualizado com sucesso!";
                header("location:/bancodadosAjax/index.php");
            } while (false);
        }
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
    }
    $conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>PHP CRUD</title>
</head>
<body>
    <div class="container my-5">
        <h2>Novo Cliente</h2>
        <?php
        // Exibe a mensagem de erro caso os campos obrigatórios não sejam preenchidos
            if(!empty($errorMessage)) {
                echo "
                    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>$errorMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                ";
            } elseif (!empty($successMessage)) { // Exibe a mensagem de sucesso caso todos os campos sejam preenchidos
                echo "
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>$successMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>                
                ";
            }
        ?>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nome</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nome" value="<?php echo $nome; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Telefone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="telefone" value="<?php echo $telefone; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Endereço</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="endereco" value="<?php echo $endereco; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button class="btn btn-primary">Enviar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a href="/bancodadosAjax/index.php" class="btn btn-outline-primary" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>