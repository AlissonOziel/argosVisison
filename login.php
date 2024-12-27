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

        <link href="css/tooplate-mini-finance.css" rel="stylesheet">

    </head>
    
    <body>


        <div class="container-fluid">
            
            <div class="row">

                <main class="col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4">

                    <div class="title-group mb-3">
                        <h1 class="h2 mb-0">Login</h1>
                    </div>

                    <div class="row">

                        <div class="col-lg-9 col-9">

                            <div class="custom-block custom-block-profile">
                                <div class="row">

                                    

                                    <form action="process/login.php" method="POST" lass="custom-form password-form">
            
                                        <div class="col-lg-9 col-12">

                                

                                            <p class="d-flex flex-wrap mb-2">
                                                <strong>Email:</strong>
                                                
                                                <input type="email" name="email" id="email" class="form-control" placeholder="Preço" required="">
                                            </p>

                                            <p class="d-flex flex-wrap mb-2">
                                                <strong>Password:</strong>
                                                
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Quantidade" required="">
                                            </p>

                                            <p class="d-flex flex-wrap mb-2">
                                                <button type="submit" class="form-control">
                                                    Login
                                                </button>
                                            </p>

                                        </div>

                                    </form>
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
        <script src="js/custom.js"></script>

    </body>
</html>