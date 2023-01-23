<?php
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $servername = "localhost";
        $username ="root";
        $password = "";
        $dbname = "phpcrud";
        try {
            // Criando conexão
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Defina o modo de erro PDO como exeção
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL para deletar um registro
            $sql = "DELETE FROM clientes WHERE id=$id";
            // Preparando a declaração
            $result = $conn->prepare($sql);

            // Executando a consulta 
            $result->execute();
        } catch (PDOException $e) {
            echo $sql."<br/>".$e->getMessage();
        }
        $conn = null;
    }
    header("location: /bancodadosAjax/index.php");
    exit;
?>