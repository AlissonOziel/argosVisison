<?php
    session_start();

    include ("../back/inicia.php");
    include("../process/protected.php");

    $PDO = db_connect();

    protectedAdm();

    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    
    //Return Details 
    $sql = "SELECT a.id,
                 a.name,
                 a.quantity,
                 a.value,
                 a.price,

                 b.category
           
            FROM stokes as a
              JOIN categorys as b ON a.category = b.id
                WHERE a.id = :id"; 

  $stmt = $PDO->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  //getCountSales
  $gcs = "SELECT COUNT(*) AS total_A
                    FROM sales as a
                        WHERE a.product = :id "; 

    $sa_count = $PDO->prepare($gcs);
    $sa_count->bindParam(':id', $id);
    $sa_count->execute(); 
    $total_sa = $sa_count->fetchColumn();

    //getSumSales
    $gss = "SELECT SUM(total) AS total_A
                FROM sales as a
                    WHERE a.product = :id"; 

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
                                <a class="nav-link active" href="products.php">
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
                                <a class="nav-link" href="../app/argos.apk" download>
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
                                <a class="nav-link" href="../process/exit.php">
                                    <i class="bi-box-arrow-left me-2"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>

                    </div>
                </nav>

                <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
                    <div class="title-group mb-3">
                        <h1 class="h2 mb-0">Detalhe do Produto</h1>
                    </div>

                    <div class="row my-4">

                        <div class="col-lg-7 col-12">

                            <div class="custom-block custom-block-profile bg-white">
                                <h6 class="mb-4">Informações</h6>

                                <p class="d-flex flex-wrap mb-2">
                                    <strong>#ID:</strong>

                                    <span>
                                        <?php echo $product['id']; ?>
                                    </span>
                                </p>

                                <p class="d-flex flex-wrap mb-2">
                                    <strong>Nome:</strong>

                                    <span>
                                        <?php echo $product['name']; ?>
                                    </span>
                                </p>

                                <p class="d-flex flex-wrap mb-2">
                                    <strong>Categoria:</strong>

                                    <span>
                                        <?php echo $product['category']; ?>
                                    </span>
                                </p>

                                <p class="d-flex flex-wrap mb-2">
                                    <strong>Preço:</strong>

                                    <span>
                                        <?php echo $product['price']; ?>
                                    </span>
                                </p>

                            </div>
                        </div>

                        <div class="col-lg-5 col-12">
                            <div class="custom-block custom-block-contact">
                                <h6 class="mb-4">Vendas</h6>

                                <p>
                                    <strong>Vendidos:</strong>
                                    <span>
                                        <?php echo $total_sa; ?>
                                    </span>
                                </p>

                                <p>
                                    <strong>Total de Vendas:</strong>
                                    <span>
                                        <?php echo $sum_sa; ?>
                                    </span>
                                </p>

                            </div>
                        </div>

                    </div>

                    <!-- <div class="row my-4">
                        <div class="col-lg-7 col-12">

                            <div class="custom-block custom-block-bottom d-flex flex-wrap">
                                <div class="custom-block-bottom-item">
                                    <a href="editProducts.php?id=<?php echo $product['id']; ?>" class="d-flex flex-column">
                                        <i class="custom-block-icon bi bi-pencil-square"></i>

                                        <small>Editar</small>
                                    </a>
                                </div>

                                <div class="custom-block-bottom-item">
                                    <a href="process/zeroProduct.php?id=<?php echo $product['id']; ?>" class="d-flex flex-column">
                                        <i class="custom-block-icon bi bi-trash"></i>

                                        <small>Zerar</small>
                                    </a>
                                </div>

                                <div class="custom-block-bottom-item">
                                    <a href="#" class="d-flex flex-column">
                                        <i class="custom-block-icon bi-send"></i>

                                        <small>Send</small>
                                    </a>
                                </div>

                                <div class="custom-block-bottom-item">
                                    <a href="#" class="d-flex flex-column">
                                        <i class="custom-block-icon bi-arrow-down"></i>

                                        <small>Request</small>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div> -->

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
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/custom.js"></script>

    </body>
</html>