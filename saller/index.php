<?php

    session_start();

    include ("../back/inicia.php");
    include("../process/protected.php");

    $PDO = db_connect();

    protectedAdm();

    $id = $_SESSION['adm'];

    $name = $_SESSION['name'];
    $email = $_SESSION['email'];

    //Retorna a quantidade total de estoque por categoria e o valor total investido em cada categoria
    $sql = "SELECT  a.id,
                    SUM(a.quantity) AS stoke,

                    c.category 
                        FROM products AS a 
                            JOIN stokes as b ON a.stoke = b.id
                            JOIN categorys AS c ON b.category = c.id
                                WHERE a.user = :id
                                    GROUP BY c.category 
                                        ORDER BY a.id DESC";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Retorna a soma total de quantidades e o valor total do estoque
    $total = "SELECT 
                    SUM(quantity) AS total_stock_quantity
                        FROM products as a
                            WHERE a.user = :id;";

    $rTotal = $PDO->prepare($total);
    $rTotal->bindParam(':id', $id);
    $rTotal->execute();

    $resultTotal = $rTotal->fetch(PDO::FETCH_ASSOC);
    $totalQuantity = $resultTotal['total_stock_quantity'];

    // Retorna a receita agrupada por método de pagamento
    $pays = "SELECT p.pay AS payment_method, 
                    SUM(a.total) AS revenue 
                        FROM sales as a
                            JOIN pays as p ON a.pay = p.id
                                WHERE a.user = :id
                                    GROUP BY p.pay;";

    $rPay = $PDO->prepare($pays);
    $rPay->bindParam(':id', $id);
    $rPay->execute();

    // Retorna a soma total das vendas realizadas
    $gss = "SELECT SUM(total) AS total_A 
                        FROM sales
                            WHERE user = :id";

    $sumSales = $PDO->prepare($gss);
    $sumSales->bindParam(':id', $id);
    $sumSales->execute();

    $result = $sumSales->fetch(PDO::FETCH_ASSOC);
    $sumTotalSales = $result['total_A'];

    // Retorna a soma total das quantidades vendidas
    $gsq = "SELECT SUM(quantity) AS sum_A 
                        FROM sales
                            WHERE user = :id"; 

    $qu_sum = $PDO->prepare($gsq);
    $qu_sum->bindParam(':id', $id);
    $qu_sum->execute(); 
    $sum_qu = $qu_sum->fetchColumn();

    // Retorna a quantidade total de vendas realizadas
    $cts = "SELECT COUNT(id) AS count_sales 
                        FROM sales
                            WHERE user = :id";

    $countSales = $PDO->prepare($cts);
    $countSales->bindParam('id', $id);
    $countSales->execute();

    $result = $countSales->fetch(PDO::FETCH_ASSOC);
    $countTotalSales = $result['count_sales'];


    // Retorna a atribuição total de produtos por usuário
    $rt = "SELECT   u.id AS id_user, 
                    u.name, 
                    SUM(p.quantity) AS totalAttribuition 
                        FROM products p
                            JOIN users AS u ON p.USER = u.id
                                WHERE p.user = :id
                                    GROUP BY u.NAME;";

    $ra = $PDO->prepare($rt);
    $ra->bindParam(':id', $id);
    $ra->execute();

    $rAttribuition = $ra->fetch(PDO::FETCH_ASSOC);
    // $attribuition = $rAttribuition['count_sales'];


    //getCommissionPay
    $gcp = "SELECT SUM(a.comission)
                    FROM sales as a
                        WHERE a.user = :id";

    $sumCommission = $PDO->prepare($gcp);
    $sumCommission->bindParam(':id', $id);
    $sumCommission->execute();
    $totalCommission = $sumCommission->fetchColumn();

    //getCommissionPaid
    $gcpd = "SELECT SUM(a.value)
                    FROM accounts as a
                        WHERE a.user = :id";

    $sumCommissionPaid = $PDO->prepare($gcpd);
    $sumCommissionPaid->bindParam(':id', $id);
    $sumCommissionPaid->execute();
    $totalCommissionPaid = $sumCommissionPaid->fetchColumn();

?>

<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="Tooplate">

        <title>Argos Vision</title>

        <!-- CSS FILES -->      
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;700&display=swap" rel="stylesheet">

        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <link href="../css/bootstrap-icons.css" rel="stylesheet">

        <link href="../css/apexcharts.css" rel="stylesheet">

        <link href="../css/tooplate-mini-finance.css" rel="stylesheet">

        <?php
            //Tooplate 2135 Mini Finance

            //https://www.tooplate.com/view/2135-mini-finance

            //Bootstrap 5 Dashboard Admin Template
        ?>

    </head>
    
    <body>

        <!-- Header -->
        <header class="navbar sticky-top flex-md-nowrap">

            <div class="col-md-3 col-lg-3 me-0 px-3 fs-6">
                <a class="navbar-brand" href="index.php">
                    <!-- <i class="bi-box"></i> -->
                    <img src="../images/argosPNG.png" class="profile-image img-fluid" alt="">
                    Argos Vision
                </a>
            </div>

            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-nav me-lg-2">

                <div class="nav-item text-nowrap d-flex align-items-center">
                    
                    <!-- PROFILE -->
                    <div class="dropdown px-3">

                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-4"></i>
                        </a>
                        
                        <ul class="dropdown-menu bg-white shadow">
                            <li>
                                <div class="dropdown-menu-profile-thumb d-flex">
                                    <i class="bi bi-person-circle fs-4"></i>

                                    <div class="d-flex flex-column">
                                        <small>
                                            <?php echo $name; ?>
                                        </small>
                                        <a href="#">
                                            <?php echo $email; ?>
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <a class="dropdown-item" href="profile.php">
                                    <i class="bi-person me-2"></i>
                                    Perfil
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="store.php">
                                    <i class="bi bi-shop me-2"></i>
                                    Loja
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="help-center.php">
                                    <i class="bi-question-circle me-2"></i>
                                    Help
                                </a>
                            </li>

                            <li class="border-top mt-3 pt-2 mx-4">
                                <a class="dropdown-item ms-0 me-0" href="../process/exit.php">
                                    <i class="bi-box-arrow-left me-2"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </header>

        <div class="container-fluid">

            <div class="row">

                <!--Menu-->
                <nav id="sidebarMenu" class="col-md-3 col-lg-3 d-md-block sidebar collapse">

                    <div class="position-sticky py-4 px-3 sidebar-sticky">

                        <ul class="nav flex-column h-100">

                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">
                                    <i class="bi-house-fill me-2"></i>
                                    Home
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="store.php">
                                    <i class="bi bi-shop me-2"></i>
                                    Loja
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="products.php">
                                    <i class="bi-upc-scan me-2"></i>
                                    Produtos
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="sales.php">
                                    <i class="bi bi-currency-dollar me-2"></i>
                                    Vendas
                                </a>
                            </li>

                            <!-- <li class="nav-item">
                                <a class="nav-link" href="finances.php">
                                    <i class="bi bi-pie-chart me-2"></i>
                                    Finaceiro
                                </a>
                            </li> -->

                            <li class="nav-item">
                                <a class="nav-link" href="profile.php">
                                    <i class="bi bi-person-circle me-2"></i>
                                    Perfil
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="app/argos.apk" download>
                                <i class="bi bi-cloud-arrow-down me-2"></i>
                                    Download
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="help-center.php">
                                    <i class="bi-question-circle me-2"></i>
                                    Help Center
                                </a>
                            </li>

                            <!-- <li class="nav-item featured-box mt-lg-5 mt-4 mb-4">
                                <img src="images/argosPNG.png" class="img-fluid" alt="">

                                <strong>Argos Vision</strong>
                            </li> -->

                            <li class="nav-item border-top mt-auto pt-2">
                                <a class="nav-link" href="process/exit.php">
                                    <i class="bi-box-arrow-left me-2"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>

                    </div>
                </nav>
                
                <!--Content-->
                <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">

                    <!--Title Page-->
                    <div class="title-group mb-3">
                        <h1 class="h2 mb-0">Bem Vindo ao Argos</h1>

                        <small class="text-muted">Olá <?php echo $name; ?></small>
                    </div>

                    <!--Content Row-->
                    <div class="row my-4">

                        <!-- Col Left -->
                        <div class="col-lg-7 col-12">

                            <!--Carteira-->
                            <div class="custom-block custom-block-balance">
                                <small>Receber</small>

                                <h2 class="mt-2 mb-3">
                                    <?php echo $totalCommission - $totalCommissionPaid ?>
                                </h2>


                                <div class="d-flex">
                                    <div>
                                        <small>Recebido</small>
                                        <p>
                                            R$<?php echo $totalCommissionPaid; ?>
                                        </p>
                                    </div>

                                    <div class="ms-auto">
                                        <small>Total</small>
                                        <p>
                                            R$<?php echo $totalCommission; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!--Table Products-->
                            <div class="custom-block custom-block-exchange">
                                <h5 class="mb-4">Produtos</h5>

                                <?php while($product = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">

                                        
                                        <div class="d-flex align-items-center">

                                            <div>
                                                <p><?php echo $product['category']; ?></p>
                                                
                                            </div>
                                        </div>
                                        

                                        <div class="ms-auto me-4">
                                            <small>Estoque</small>
                                            <h6><?php echo $product['stoke']; ?></h6>
                                        </div>

                                    </div>
                                <?php endwhile; ?>
  
                            </div>

                            <!--Table Pays-->
                            <div class="custom-block custom-block-exchange">
                                <h5 class="mb-4">Pagamentos</h5>

                                <?php while($iPay = $rPay->fetch(PDO::FETCH_ASSOC)): ?>
                                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">

                                        
                                        <div class="d-flex align-items-center">

                                            <div>
                                                <p><?php echo $iPay['payment_method']; ?></p>
                                
                                            </div>
                                        </div>
                                        

                                        <div class="ms-auto me-4">
                                            <small>Vendido</small>
                                            <h6>R$<?php echo $iPay['revenue']; ?></h6>
                                        </div>

                                    </div>
                                <?php endwhile; ?>

                            </div>

                        </div>

                        <!--Col Right-->
                        <div class="col-lg-5 col-12">

                            <!--Sales-->
                            <div class="custom-block custom-block-profile-front custom-block-profile text-center bg-white">
                                
                                <span>Vendas</span>
                                <p class="d-flex flex-wrap mb-2">
                                    <strong>Total de Vendas:</strong>

                                    <span><?php echo $countTotalSales; ?></span>
                                </p>

                                <p class="d-flex flex-wrap mb-2">
                                    <strong>Produtos Vendidos:</strong>
                                    
                                    <span><?php echo $sum_qu; ?></span>
                                </p>

                            </div>

                            <!--Stoke-->
                            <div class="custom-block custom-block-profile-front custom-block-profile text-center bg-white">
                                
                                <span>Estoque</span>
                                <p class="d-flex flex-wrap mb-2">
                                    <strong>Total no Estoque:</strong>

                                    <span><?php echo $totalQuantity;  ?></span>
                                </p>

                            </div>

                            <!--Links-->
                            <div class="custom-block custom-block-bottom d-flex flex-wrap">
                                <div class="custom-block-bottom-item">
                                    <a href="products.php" class="d-flex flex-column">
                                        <i class="custom-block-icon bi-upc-scan"></i>

                                        <small>Produtos</small>
                                    </a>
                                </div>

                                <div class="custom-block-bottom-item">
                                    <a href="sales.php" class="d-flex flex-column">
                                        <i class="custom-block-icon bi bi-currency-dollar"></i>

                                        <small>Vendas</small>
                                    </a>
                                </div>

                                <div class="custom-block-bottom-item">
                                    <a href="store.php" class="d-flex flex-column">
                                        <i class="custom-block-icon bi bi-shop"></i>

                                        <small>Loja</small>
                                    </a>
                                </div>

                                <div class="custom-block-bottom-item">
                                    <a href="../app/Argos.apk" class="d-flex flex-column" download>
                                        <i class="custom-block-icon bi bi-cloud-arrow-down"></i>

                                        <small>Download</small>
                                    </a>
                                </div>
                            </div>

                            <!--Atribuition-->
                            <div class="custom-block custom-block-transations">

                                <h5 class="mb-4">Atribuição</h5>

                                <div class="d-flex flex-wrap align-items-center mb-4">
                                    <div class="d-flex align-items-center">
                                        
                                        <div>
                                            <p>
                                                <a href="detailUser.php?id=<?php echo $rAttribuition['id_user']; ?>">
                                                    <?php echo $rAttribuition['name']; ?>
                                                </a>
                                            </p>

                                        </div>
                                    </div>

                                    <div class="ms-auto">
                                        <small>Produtos</small>
                                        <strong class="d-block text-success"> <?php echo $rAttribuition['totalAttribuition']; ?></strong>
                                    </div>
                                </div>
                                <hr>
                                
                            </div>
                            
                        </div>

                    </div>
                    
                    <!--Footer-->
                    <footer class="site-footer">
                        <div class="container">
                            <div class="row">
                                
                                <div class="col-lg-12 col-12">
                                    <p class="copyright-text">Argos Vision 2024 
                                    - Design: <a rel="sponsored" href="https://www.pantheon.com" target="_blank">Pantheon</a></p>
                                </div>

                            </div>
                        </div>
                    </footer>

                </main>

            </div>

        </div>

        <!-- JAVASCRIPT FILES -->
        <div>
            <script src="../js/jquery.min.js"></script>
            <script src="../js/bootstrap.bundle.min.js"></script>
            <script src="../js/apexcharts.min.js"></script>
            <script src="../js/custom.js"></script>
        </div>

    </body>
</html>