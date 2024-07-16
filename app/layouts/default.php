<?php

// Configurações do banco de dados
$dbHost = 'localhost';
$dbName = 'jornalweb'; // Substitua pelo nome do seu banco de dados
$dbUser = 'root';
$dbPass = '';

// Conexão MySQLi
$db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Verifica a conexão
if ($db->connect_error) {
    die("Erro na conexão: " . $db->connect_error);
}

// Determina o idperfil do usuário
$idPerfil = 96; // Suponha que seja o id do perfil do usuário

// Consulta para obter categorias onde idperfil é menor que $idPerfil ou idperfil é igual ao $idPerfil
$queryCategorias = "SELECT * FROM menu_categorias WHERE idperfil <= ? ORDER BY ordenacao";
$stmtCategorias = $db->prepare($queryCategorias);
$stmtCategorias->bind_param("i", $idPerfil);
$stmtCategorias->execute();
$resultCategorias = $stmtCategorias->get_result();

// Consulta para obter itens de menu associados às categorias permitidas
$queryItens = "SELECT * FROM menu_itens WHERE idperfil <= ? ORDER BY idcategoria";
$stmtItens = $db->prepare($queryItens);
$stmtItens->bind_param("i", $idPerfil);
$stmtItens->execute();
$resultItens = $stmtItens->get_result();

// Array para armazenar categorias e seus itens correspondentes
$menu = array();

// Processa categorias
while ($categoria = $resultCategorias->fetch_assoc()) {
    $menu[$categoria['idcategoria']] = array(
        'icone' => $categoria['icone'],
        'descricao' => $categoria['descricao'],
        'itens' => array()
    );
}

// Processa itens de menu e associa aos respectivos categorias
while ($item = $resultItens->fetch_assoc()) {
    if (isset($menu[$item['idcategoria']])) {
        $menu[$item['idcategoria']]['itens'][] = $item;
    }
}

// Fechar resultados e conexão
$stmtCategorias->close();
$stmtItens->close();
$db->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Padrão Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="accordion" id="accordionExample">
                    <?php foreach ($menu as $key => $categoria): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?php echo $key; ?>">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $key; ?>" aria-expanded="true" aria-controls="collapse<?php echo $key; ?>">
                                    <span class="<?php echo $categoria['icone']; ?>"></span>
                                    <?php echo $categoria['descricao']; ?>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $key; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $key; ?>" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="nav flex-column">
                                        <?php foreach ($categoria['itens'] as $item): ?>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?php echo $item['module']; ?>">
                                                    <span class="<?php echo $item['icon']; ?>"></span>
                                                    <?php echo $item['descricao']; ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </nav>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <!-- Inclua outros arquivos JavaScript necessários -->
</body>
</html>