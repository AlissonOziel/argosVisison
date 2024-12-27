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

    $total = $quantity * $price;

    //checkProducts
    $sqlCheckStock = "SELECT quantity 
                        FROM products 
                            WHERE id = :product";

    $stmtCheckStock = $PDO->prepare($sqlCheckStock);
    $stmtCheckStock->bindParam(':product', $product, PDO::PARAM_INT);
    $stmtCheckStock->execute();

    $stock = $stmtCheckStock->fetch(PDO::FETCH_ASSOC);

    if ($stock['quantity'] < $quantity) {
        echo "<script>
                alert('Erro: Quantidade insuficiente no estoque.');
                window.location.href = '../store.php';
            </script>";
        exit; 
    }

    //retunrCommission
    $rComission = "SELECT a.id, c.rate 
                    FROM products as a 
                        JOIN stokes as b ON a.stoke = b.id
                        JOIN categorys as c ON b.category = c.id
                            WHERE a.id = :product";

    $rc = $PDO->prepare($rComission);
    $rc->bindParam(':product', $product);
    $rc->execute();

    $valueCommission = $rc->fetch(PDO::FETCH_ASSOC);

    //getRate
    $commission_rate = $valueCommission['rate'];
    $commission = ($total * $commission_rate) / 100;

    $date = date('Y-m-d H:i:s');

    try {
        $PDO->beginTransaction();

        $sql = "INSERT INTO sales (quantity, 
                                   total, 
                                   created_at, 
                                   commission, 
                                   pay, 
                                   user, 
                                   product) 
                        VALUES (:quantity, 
                                :total, 
                                :date, 
                                :commission, 
                                :pay, 
                                :id, 
                                :product)";

        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':commission', $commission);
        $stmt->bindParam(':pay', $pay);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':product', $product);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao inserir venda.");
        }

        $sqlStoke = "UPDATE stokes 
                        SET quantity = quantity - :quantity
                        WHERE id = :product";

        $stmtStoke = $PDO->prepare($sqlStoke);
        $stmtStoke->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmtStoke->bindParam(':product', $product, PDO::PARAM_INT);

        if (!$stmtStoke->execute()) {
            throw new Exception("Erro ao atualizar estoque.");
        }

        $sqlProduct = "UPDATE products 
                            SET quantity = quantity - :quantity
                            WHERE id = :product";

        $stmtProduct = $PDO->prepare($sqlProduct);
        $stmtProduct->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmtProduct->bindParam(':product', $product, PDO::PARAM_INT);

        if (!$stmtProduct->execute()) {
            throw new Exception("Erro ao atualizar produto.");
        }

        $PDO->commit();
        echo "<script>
                alert('Venda cadastrada com sucesso.');
                window.location.href = '../store.php';
            </script>";

    } catch (Exception $e) {
        $PDO->rollBack();
        error_log($e->getMessage());
        header('Location: erro/erroCad.php');
    }

?>
