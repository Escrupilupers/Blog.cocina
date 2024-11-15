<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="C:\xampp\htdocs\blog.cocina\assets\style.css">
</head>
<?php require "../config/Conexion.php";
$query="select * from recetas";
$result=mysqli_query($conexion,$query);

?>
<body>
    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="C:\xampp\htdocs\Projecto web\Recetario\index.html">A Cocinar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="C:\xampp\htdocs\Projecto web\Recetario\index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="C:\xampp\htdocs\Projecto web\Recetario\blog.html">Recetas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="C:\xampp\htdocs\Projecto web\Recetario\tips.html">Tips de cocina</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="C:\xampp\htdocs\Projecto web\Recetario\sobre-nosotros.html">Sobre nosotros</a>
                    </li>
                </ul>
                <button class="btn btn-warning ms-3">Subscríbete</button>
            </div>
        </div>
    </nav>

    <div class="row mx-3">
        <div class="col-md-1"></div>
        <div class="col-md-11 turquoise-box">
            <div class="row">
                <div class="col-md-6">
                    <h3>Explora la variedad</h3>
                    <p>Si es un entusiasta del desayuno, un conocedor de delicias saladas o busca postres irresistibles, nuestra cuidada selección tiene algo para satisfacer todos los paladares.</p>
                </div>
                <div class="col-md-6 icon-center"></div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <img src="https://cdn-icons-png.flaticon.com/256/563/563889.png" alt="Desayuno" style="max-width: 30px;"><br>Desayuno
                        </div>
                        <div class="col-md-2 text-center">
                            <img src="https://cdn-icons-png.flaticon.com/256/1046/1046893.png" alt="Almuerzo" style="max-width: 30px;"><br>Almuerzo
                        </div>
                        <div class="col-md-2 text-center">
                            <img src="https://cdn-icons-png.flaticon.com/256/3106/3106992.png" alt="Cena" style="max-width: 30px;"><br>Cena
                        </div>
                        <div class="col-md-2 text-center">
                            <img src="https://cdn-icons-png.flaticon.com/256/2965/2965574.png" alt="Postre" style="max-width: 30px;"><br>Postre
                        </div>
                        <div class="col-md-2 text-center">
                            <img src="https://cdn-icons-png.flaticon.com/256/5718/5718873.png" alt="Antojo" style="max-width: 30px;"><br>Antojo!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <section class="container my-5">
        <h2 class="mb-4">Recetas Populares</h2>
        <div class="row">

<?php foreach( $result as $text){ ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="" class="card-img-top" alt="<?php echo $text ['categoria']; ?>" style="height: 300px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $text ['titulo']; ?> </h5>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>

<!-- Pie de página -->
<footer class="bg-dark text-white text-center py-4">
    <p>&copy; 2024 A Cocinar. Todos los derechos reservados.</p>
    <p>Síguenos en nuestras redes sociales</p>
    <div class="social-icons">
        <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook">
        <img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" alt="Instagram">
        <img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="YouTube">
    </div>
</footer>
</body>
</html>
