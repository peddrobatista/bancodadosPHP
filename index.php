<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>PHP CRUD</title>
</head>
<body>
    <div class="container my-5">
        <h2>Lista de Clientes</h2>
        <a href="/bancodadosAjax/create.php" class="btn btn-primary" role="button">Novo Cliente</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Criado em</th>
                    <th>Ação</th>
                </tr>  
            </thead>
            <tbody>
                <?php
                    $servername = "localhost";
                    $username ="root";
                    $password = "";
                    $dbname = "phpcrud";

                    // Criando conexão
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        // Defina o modo de erro PDO como exeção
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        // Lendo todas as linhas da tabela
                        $stmt = $conn->prepare("SELECT * FROM clientes");
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                        foreach($result as $key => $value) {
                            echo "
                                <tr>
                                    <td>$value[id]</td>
                                    <td>$value[nome]</td>
                                    <td>$value[email]</td>
                                    <td>$value[telefone]</td>
                                    <td>$value[endereco]</td>
                                    <td>$value[created_at]</td>
                                    <td>
                                        <a href='/bancodadosAjax/edit.php?id=$value[id]' class='btn btn-primary btn-sm'>Editar</a>
                                        <a href='/bancodadosAjax/delete.php?id=$value[id]' class='btn btn-danger btn-sm'>Deletar</a>
                                    </td>
                                </tr>
                            ";
                        }
                        

                    } catch (PDOException $e) {
                        echo "Error ".$e->getMessage();
                    }
                    $conn = null;
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>