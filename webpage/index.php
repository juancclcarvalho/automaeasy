<?php
	require_once 'conexao.php';
	
	$ambientes = find_all('ambiente');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<title>Automaeasy</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="_css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="_css/navbar-style.css" />
    <link rel="stylesheet" href="_css/amb-mod-style.css" />
	<link rel="stylesheet" href="_css/button-style.css" />
	<link rel="stylesheet" href="_css/table-style.css" />
</head>

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
	<br/><br/><br/>
	<?php if (!empty($_SESSION['message'])) : ?>
		<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo $_SESSION['message']; ?>
		</div>
		<?php clear_messages(); ?>
	<?php endif; ?>
	<div class="window">
		<table>
			<tbody>
				<?php if ($ambientes) : ?>
				<?php foreach ($ambientes as $ambiente) : ?>
					<tr class="el">
						<td>
							<ul>
								<a href="ambiente_equipamento.php?idambiente=<?php echo $ambiente['id']; ?>"><li class="_col amb-equip"><?php echo $ambiente['nome']; ?></li></a>
								<li class="_col text-right">
									<a href="ambiente.php?id=<?php echo $ambiente['id']; ?>&acao=editar" class="btn btn-sm btn-primary"><img class="glyph-icon" src="_imagens/si-glyph-pencil.svg"/></a>
									<a href="javascript: confirmaExclusao(<?php echo $ambiente['id']; ?>, '<?php echo $ambiente['nome']; ?>');" class="btn btn-sm btn-automaeasy"><img class="glyph-icon" src="_imagens/si-glyph-trash.svg"/></a>
								</li>
							</ul>
						</td>
					</tr>
				<?php endforeach; ?>
				<?php else : ?>
					<tr>
						<td colspan="6">Nenhum registro encontrado.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<script>
		function confirmaExclusao(id, nome){
			if (confirm('Deseja excluir o ambiente ' + nome + '?')){
				// Faz o processamento necessário para exclusão
				location.replace('ambiente.php?id='+ id +'&acao=excluir');
			}
		}
	</script>
</body>	

</html>