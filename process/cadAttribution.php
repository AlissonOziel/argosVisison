<?php
    session_start();

    include '../back/inicia.php';
    include_once("../back/conect.php");

    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
    $product = isset($_POST['product']) ? $_POST['product'] : null;
    $user = isset($_POST['seller']) ? $_POST['seller'] : null;

    // Conexão com o banco de dados
    $PDO = db_connect();

    try {

        // Validação: verificar se os dados foram preenchidos
        if (empty($quantity) || empty($product) || empty($user)) {
            throw new Exception("Todos os campos são obrigatórios. Verifique as informações fornecidas.");
        }

            // Validação: verificar se a quantidade é um número positivo
            if (!is_numeric($quantity) || $quantity <= 0) {
                echo "<script>
                            alert('A quantidade deve ser um número maior que zero.');
                            window.location.href = '../attribution.php';
                        </script>";
            }

            // Verificar quantidade disponível no estoque
            $sqlCheck = "SELECT attribution FROM stokes WHERE id = :product";

            $stmtCheck = $PDO->prepare($sqlCheck);
            $stmtCheck->bindParam(':product', $product, PDO::PARAM_INT);
            $stmtCheck->execute();

            $stokeInfo = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if (!$stokeInfo) {
                echo "<script>
                            alert('Produto não encontrado no estoque.');
                            window.location.href = '../attribution.php';
                        </script>";
            
            }

            $quantityAvailable = $stokeInfo['attribution'];

            // Validação: verificar se a quantidade solicitada é maior que a disponível
            if ($quantity > $quantityAvailable) {
                echo "<script>
                            alert('Quantidade solicitada excede o estoque disponível.');
                            window.location.href = '../attribution.php';
                        </script>";
        
            }else{

                // Cadastrar distribuição para o vendedor
                $sqlInsert = "INSERT INTO products (quantity, stoke, user)
                                VALUES (:quantity, :product, :user)";
                            
                $stmtInsert = $PDO->prepare($sqlInsert);
                $stmtInsert->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmtInsert->bindParam(':product', $product, PDO::PARAM_INT);
                $stmtInsert->bindParam(':user', $user, PDO::PARAM_INT);

                if ($stmtInsert->execute()) {
                    // Atualizar a quantidade no estoque
                    $attribution = $quantityAvailable - $quantity;
                    
                    $sqlUpdate = "UPDATE stokes SET attribution = :attribution WHERE id = :product";
                    $stmtUpdate = $PDO->prepare($sqlUpdate);
                    $stmtUpdate->bindParam(':attribution', $attribution, PDO::PARAM_INT);
                    $stmtUpdate->bindParam(':product', $product, PDO::PARAM_INT);

                    if ($stmtUpdate->execute()) {
                        echo "<script>
                                alert('Distribuição cadastrada com sucesso! Estoque atualizado.');
                                window.location.href = '../attribution.php';
                            </script>";
                        exit;
                    } else {

                        echo "<script>
                                alert('Erro ao atualizar a quantidade no estoque.');
                                window.location.href = '../attribution.php';
                            </script>";
                        
                    }
                } else {
                    echo "<script>
                                alert('Erro ao cadastrar a distribuição para o vendedor.');
                                window.location.href = '../attribution.php';
                            </script>";
                    
                }
            }
    } catch (Exception $e) {
        echo "<script>
                alert('Erro: " . $e->getMessage() . "');
                window.history.back();
            </script>";
        exit;
    }
?>
