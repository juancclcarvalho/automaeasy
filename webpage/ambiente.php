<?php
	require_once 'conexao.php';
    $ambiente = null;
	if (!empty($_GET['acao'])) {

		if ($_GET['acao'] == 'excluir'){

			$id = $_GET['id'];
	
			$ambiente = remove('ambiente', $id);
			header('location: index.php');

		} else {

			$id = $_GET['id'];
	
			$ambiente = find('ambiente', $id);
		}

	} else if (!empty($_POST['id'])) {

		$ambiente = $_POST['ambiente'];

		update('ambiente', $_POST['id'], $ambiente);
		header('location: index.php');
		
	} else if (!empty($_POST['ambiente'])) {

		$ambiente = $_POST['ambiente'];

		save('ambiente', $ambiente);
		header('location: index.php');
	}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="_css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="_css/navbar-style.css" />
    <link rel="stylesheet" href="_css/field-style.css" />
    <link rel="stylesheet" href="_css/button-style.css" />
</head>

<form action="ambiente.php" method="post">
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-light fixed-top">
        <a class="navbar-brand" href="index.php">
            <img class="logo" src="_imagens/lampada-automaeasy-logo.png" alt="automaeasy"/>
        </a>
        <span class="navbar-text">Automaeasy</span>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
            <span class="navbar-toggler-icon"></span>
        </button>
        

        <div class="collapse navbar-collapse" id="collapse_target">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="ambiente.php">Adicionar Ambientes</a>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item">
                    <a class="nav-link" href="controle.php">Adicionar controle</a>
                </li>
            </ul>
        </div>
    </nav>
    <hr>
    <hr>
    <hr>
    <div class="interface">

            <input type="hidden" name="id" value="<?php echo $ambiente['id']; ?>">

            <input class="field-automaeasy" name="ambiente['nome']" value="<?php echo $ambiente['nome']; ?>"
				id="environment" placeholder="  Insira aqui o nome do novo ambiente" maxlength="20">

            <input class="field-automaeasy" name="ambiente['endmacxbee']" value="<?php echo $ambiente['endmacxbee']; ?>"
				id="adress" placeholder="  Insira aqui o MAC do modulo" maxlength="17">

            <input type="submit" class="btn btn-automaeasy btn-center p" id="salvar-button" value="Salvar" />

            <a href="index.php" class="btn btn-automaeasy btn-center p" id="voltar-button" value="Cancelar">Cancelar</a>
        
    </div>
</body>
</form>
</html>