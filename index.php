<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

$host = "localhost";
$db   = "lista-a-fazer";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}


if (isset($_POST['add'])) {
    $nome = $_POST['Nometarefa'];
    $data = date('Y-m-d');

    $stmt = $pdo->prepare("INSERT INTO tarefas (Nometarefa, Datatarefa) VALUES (?, ?)");
    $stmt->execute([$nome, $data]);

    header("Location: index.php");
    exit;
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE IDtarefa = ?");
    $stmt->execute([$id]);

    header("Location: index.php");
    exit;
}


$editTask = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM tarefas WHERE IDtarefa = ?");
    $stmt->execute([$id]);
    $editTask = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['update'])) {
    $id = $_POST['IDtarefa'];
    $nome = $_POST['Nometarefa'];

    $stmt = $pdo->prepare("UPDATE tarefas SET Nometarefa = ? WHERE IDtarefa = ?");
    $stmt->execute([$nome, $id]);

    header("Location: index.php");
    exit;
}


$stmt = $pdo->query("SELECT * FROM tarefas ORDER BY IDtarefa DESC");
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

</body>

</html>