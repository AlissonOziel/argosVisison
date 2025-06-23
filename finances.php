<?php
    session_start();

    include ("back/inicia.php");
    include("process/protected.php");

    $PDO = db_connect();

    protectedAdm();

    $id = $_SESSION['adm'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];

    //retunrAccounts
    $sql = "SELECT  a.id,
                    a.created_at,
                    a.value,

                    b.name AS user

                FROM accounts as a
                    JOIN users as b on a.user = b.id
                        WHERE a.user = :id
                            ORDER BY a.id desc"; 

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

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

    //getSumSales
    $gss = "SELECT SUM(total) AS total_A
                FROM sales as a
                    WHERE a.user = :id "; 

    $sa_sum = $PDO->prepare($gss);
    $sa_sum->bindParam(':id', $id);
    $sa_sum->execute(); 
    $sum_sa = $sa_sum->fetchColumn();


?>

<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Argos Vision</title>

        <!-- CSS FILES -->      
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;700&display=swap" rel="stylesheet">

        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/apexcharts.css" rel="stylesheet">

        <link href="css/tooplate-mini-finance.css" rel="stylesheet">

    </head>
    
    <body>

        <!-- Header -->
        <header class="navbar sticky-top flex-md-nowrap">

            <div class="col-md-3 col-lg-3 me-0 px-3 fs-6">
                <a class="navbar-brand" href="index.php">
                    <!-- <i class="bi-box"></i> -->
                    <img src="images/argosPNG.png" class="profile-image img-fluid" alt="">
                    Argos Vision
                </a>
            </div>

            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--BTN Cadastrar-->
            <div class="custom-form header-form ms-lg-3 ms-md-3 me-lg-auto me-md-auto order-2 order-lg-0 order-md-0">
                <a href="cadAccounts.php" >
                    <button type="submit" class="form-control">Cadastar</button>
                </a>
            </div>

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
                                <a class="dropdown-item ms-0 me-0" href="process/exit.php">
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
                                <a class="nav-link" aria-current="page" href="index.php">
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
                                <a class="nav-link" href="attribution.php">
                                    <i class="bi bi-boxes me-2"></i>
                                    Atribuir
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="sales.php">
                                    <i class="bi bi-currency-dollar me-2"></i>
                                    Vendas
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="users.php">
                                    <i class="bi bi-people me-2"></i>
                                    Vendedores 
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="finances.php">
                                    <i class="bi bi-pie-chart me-2"></i>
                                    Finaceiro
                                </a>
                            </li>

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

                <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">

                    <div class="title-group mb-3">
                        <h1 class="h2 mb-0">Finaceiro</h1>
                    </div>

                    <!--Dashboard-->
                    <div class="row my-4">

                        <!--Total Money-->
                        <div class="col-lg-4 col-12">

                            <div class="custom-block">

                                <small>Carteira</small>

                                <h2 class="mt-2 mb-3">
                                    <?php echo $sum_sa; ?>
                                </h2>

                            </div>
                        </div>

                        <!--Total Sales-->
                        <div class="col-lg-4 col-12">

                            <div class="custom-block">

                                <small>Total a Pagar</small>

                                <h2 class="mt-2 mb-3">
                                    <?php echo $totalCommission - $totalCommissionPaid?>
                                </h2>

                            </div>

                        </div>

                        <!--Total Sum Sales-->
                        <div class="col-lg-4 col-12">

                            <div class="custom-block">

                                <small>Total pago </small>

                                <h2 class="mt-2 mb-3">
                                    <?php echo $totalCommissionPaid; ?>
                                </h2>

                            </div>

                        </div>

                        <!--Total Sales-->
                        <div class="col-lg-12 col-12">

                            <div class="custom-block">

                                <small>Caixa</small>

                                <h2 class="mt-2 mb-3">
                                    R$<?php echo $sum_sa - $totalCommissionPaid; ?>
                                </h2>

                            </div>

                        </div>

                        <!--Table Sales-->
                        <div class="col-lg-12 col-12">

                            <div class="custom-block bg-white">

                                <h5 class="mb-4">Comissões pagas</h5>

                                <div class="table-responsive">

                                    <table class="account-table table">

                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>

                                                <th scope="col">Nome</th>

                                                <th scope="col">Valor</th>

                                                <th scope="col">Data</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php 
                                                while($sales = $stmt->fetch(PDO::FETCH_ASSOC)): 
                                            ?>

                                                <tr>
                                                    <td scope="row"><?php echo $sales['id']; ?></td>

                                                    <td scope="row"><?php echo $sales['user']; ?></td>

                                                    <td scope="row">R$<?php echo $sales['value']; ?></td>

                                                    <td scope="row"><?php echo $sales['created_at']; ?></td>
                                                </tr>

                                            <?php 
                                                endwhile;
                                            ?>

                                        </tbody>
                                    </table>
                                </div>

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
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/apexcharts.min.js"></script>
        <script src="js/custom.js"></script>
    </body>
</html>