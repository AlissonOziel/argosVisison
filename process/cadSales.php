<?php

session_start();

include '../back/inicia.php';
include_once("../back/conect.php");

$id = $_SESSION['adm'];
$PDO = db_connect();

$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
$pay = isset($_POST['pay']) ? $_POST['pay'] : null;
$product = isset($_POST['product']) ? $_POST['product'] : null;
$price = isset($_POST['price']) ? $_POST['price'] : null;

$price = filter_var($price, FILTER_VALIDATE_FLOAT);

// Validação do preço
if ($price === false) {
    echo "<script>
            alert('Erro: Preço inválido.');
            window.location.href = '../store.php';
          </script>";
    exit;
}

$total = $quantity * $price;

// Verifica estoque disponível no produto
$sqlCheckStock = "SELECT quantity FROM products WHERE id = :product";
$stmtCheckStock = $PDO->prepare($sqlCheckStock);
$stmtCheckStock->bindParam(':product', $product, PDO::PARAM_INT);
$stmtCheckStock->execute();

$stock = $stmtCheckStock->fetch(PDO::FETCH_ASSOC);

if (!$stock || $stock['quantity'] < $quantity) {
    echo "<script>
            alert('Erro: Quantidade insuficiente no estoque.');
            window.location.href = '../store.php';
          </script>";
    exit;
}

// Busca comissão com base na categoria
$rComission = "SELECT a.id, c.rate, b.id as stoke_id
               FROM products as a
               JOIN stokes as b ON a.stoke = b.id
               JOIN categorys as c ON b.category = c.id
               WHERE a.id = :product";

$rc = $PDO->prepare($rComission);
$rc->bindParam(':product', $product, PDO::PARAM_INT);
$rc->execute();

$valueCommission = $rc->fetch(PDO::FETCH_ASSOC);

// Validação da comissão
if (!$valueCommission || !isset($valueCommission['rate'])) {
    echo "<script>
            alert('Erro: Comissão não encontrada para o produto.');
            window.location.href = '../store.php';
          </script>";
    exit;
}

$commission_rate = $valueCommission['rate'];
$commission = ($total * $commission_rate) / 100;

$date = date('Y-m-d H:i:s');

try {
    $PDO->beginTransaction();

    // Inserir a venda
    $sql = "INSERT INTO sales (quantity, total, created_at, comission, pay, user, product)
            VALUES (:quantity, :total, :date, :commission, :pay, :id, :product)";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':total', $total);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':commission', $commission);
    $stmt->bindParam(':pay', $pay);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':product', $product);

    if (!$stmt->execute()) {
        throw new Exception("Erro ao inserir venda: " . implode(", ", $stmt->errorInfo()));
    }

    // Atualizar quantidade na tabela stokes
    $stokeId = $valueCommission['stoke_id']; // usa o id correto da tabela stokes

    $sqlStoke = "UPDATE stokes SET quantity = quantity - :quantity WHERE id = :stoke_id";
    $stmtStoke = $PDO->prepare($sqlStoke);
    $stmtStoke->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmtStoke->bindParam(':stoke_id', $stokeId, PDO::PARAM_INT);

    if (!$stmtStoke->execute()) {
        throw new Exception("Erro ao atualizar estoque: " . implode(", ", $stmtStoke->errorInfo()));
    }

    // Atualizar quantidade na tabela products
    $sqlProduct = "UPDATE products SET quantity = quantity - :quantity WHERE id = :product";
    $stmtProduct = $PDO->prepare($sqlProduct);
    $stmtProduct->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmtProduct->bindParam(':product', $product, PDO::PARAM_INT);

    if (!$stmtProduct->execute()) {
        throw new Exception("Erro ao atualizar produto: " . implode(", ", $stmtProduct->errorInfo()));
    }

    $PDO->commit();

    echo "<script>
            alert('Venda cadastrada com sucesso.');
            window.location.href = '../store.php';
          </script>";

} catch (Exception $e) {
    $PDO->rollBack();
    echo "<script>
            alert('Erro: " . addslashes($e->getMessage()) . "');
            window.location.href = '../store.php';
          </script>";
    exit;
}

?>
