<?php
	require_once 'conexao.php';
	$nome = null;
	$porta = null;

	if (!empty($_GET['acao'])) {

		if ($_GET['acao'] == 'excluir'){

			$id = $_GET['id'];
	
			$equipamento = remove('equipamento', $id);
			header('location: ambiente_equipamento.php?idambiente='.$_GET['idambiente']);

		} else {

			$id = $_GET['id'];
	
			$equipamento = find('equipamento', $id);
		}

	} else if (!empty($_POST['id'])) {

		$equipamento = $_POST['equipamento'];

		update('equipamento', $_POST['id'], $equipamento);
		header('location: ambiente_equipamento.php?idambiente='.$_POST['idambiente']);
		
	} else if (!empty($_POST['equipamento'])) {

		$equipamento = $_POST['equipamento'];

		save('equipamento', $equipamento);
		header('location: ambiente_equipamento.php?idambiente='.$_POST['idambiente']);
	}else{
		$equipamento['id_ambiente'] = $_GET['idambiente'];
	}

	$controls = find_all('controle');

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
    <script>
        function enable(campo, idCampo) {
		    document.getElementById(idCampo).disabled = campo.checked;
	    }
        function limita(numero){
        var max_numeros = 2;
        if(numero.value.length > max_numeros) {
            numero.value = numero.value.substr(0, max_numeros);
        }
        }
    </script>
</head>

<form action="equipamento.php" method="post">
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
                    <a class="nav-link" href="ambiente.php">Adicionar Ambientes</a>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item">
                    <a class="nav-link" href="controle.php">Adicionar controle</a>
                </li>
            </ul>
        </div>
    </nav>
    <hr>
    
    <div class="interface">
     
        <input type="hidden" name="id" value="<?php echo $equipamento['id']; ?>">

	    <input type="hidden" name="equipamento['id_ambiente']" value="<?php echo $equipamento['id_ambiente']; ?>">
	    <input type="hidden" name="idambiente" value="<?php echo $_GET['idambiente']; ?>">

            <input class="field-automaeasy" name="equipamento['nome']" value="<?php echo $equipamento['nome']; ?>"
				id="environment" placeholder="  Insira aqui o nome do novo equipamento"/>

            <input type="number" class="field-automaeasy" name="equipamento['porta']" value="<?php echo $equipamento['porta']; ?>"
				id="adress" placeholder="  Insira aqui a porta do modulo" required onkeydown="limita(this);" onkeyup="limita(this);"/>
            
            <select id="controles" class="field-automaeasy" name="equipamento['id_controle']" value="<?php echo $equipamento['id_controle']; ?>">
                <option>
                    Selecione um controle
                </option>
		
		<?php if ($controls) : ?>
		<?php foreach ($controls as $control) : ?>
			<option <?php if ($equipamento['id_controle'] == $control['id'] ) echo 'selected' ; ?> 
					value="<?php echo $control['id']; ?>"> 
				<?php echo $control['nome']; ?>
			</option>
		<?php endforeach; ?>
		<?php endif; ?>

            </select>
            <div class="check"><input type="checkbox" onclick="javascript: enable(this, 'controles');"/>&nbsp;O equipamento não possui controle remoto</div>
            <input type="submit" class="btn btn-automaeasy btn-center p" id="salvar-button" value="Salvar" />

            <a href="index.php" class="btn btn-automaeasy btn-center p" id="voltar-button" value="Cancelar">Cancelar</a>
    
    </div>
</body>
</form>
</html>