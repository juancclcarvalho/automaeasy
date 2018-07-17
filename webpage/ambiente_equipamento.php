<?php
	require_once 'conexao.php';
	$idambiente = null;
	$equipamento = null;
	$nome = null;
	$porta = null;

	if (!empty($_GET['idambiente'])) {
		$idambiente = $_GET['idambiente'];
	} else {
		$idambiente = $_POST['idambiente'];
	}


if(isset($_POST['btn-onoff'])){
	
	//Envia comando p/ o terminal, Dando permissao a porta ACM0
	echo shell_exec("chmod a+rw /dev/ttyACM0");
	
	include "PhpSerial.php"; //import da biblioteca de serial com php
	$read = "";
	
	$serial = new phpSerial(); //Cria um novo objeto para comunicacao serial
	$serial->deviceSet("/dev/ttyACM0"); //associa esse objeto com a serial do Arduino
	$serial->confBaudRate(9600); //configura baudrate em 9600
	$serial->confParity("none"); //sem paridade
	$serial->confCharacterLength(8); //8 bits de mensagem
	$serial->confStopBits(1); //1 bit de parada
	$serial->confFlowControl("none"); //sem controle de fluxo
	$serial->deviceOpen(); //abre o dispositivo serial para comunicacao

	$valorBotao = explode("/", $_POST['btn-onoff']);
	
	$msgSerial = $valorBotao[1];
	$idEquipamento = $valorBotao[0];
	echo $msgSerial.'<br>';
	$serial->sendMessage($msgSerial);
	
	$equip = find('equipamento', $idequipamento);

	if ($equip['status'] == 1) {
		$equip['status'] = 0;
	} else {
		$equip['status'] = 1;
	}
	
	//$serial->sendMessage(0013a200.414f36f9.13,1);

	$serial->deviceClose(); //encerra a conexao serial

	update('equipamento', $idEquipamento, $equip);
}

	$equipamentos = findIdFk('equipamento', 'id_ambiente', $idambiente);
	$ambiente = find('ambiente', $idambiente);

/*************************************************
if(isset($_POST['tecla'])){
	if($_POST['tecla'] == 'onoff'){
	//Envia comando p/ o terminal, Dando permissao a porta ACM0
	echo shell_exec("chmod a+rw /dev/ttyACM0");
	
	include "PhpSerial.php"; //import da biblioteca de serial com php
	$read = "";
	
	$serial = new phpSerial(); //Cria um novo objeto para comunicacao serial
	$serial->deviceSet("/dev/ttyACM0"); //associa esse objeto com a serial do Arduino
	$serial->confBaudRate(9600); //configura baudrate em 9600
	$serial->confParity("none"); //sem paridade
	$serial->confCharacterLength(8); //8 bits de mensagem
	$serial->confStopBits(1); //1 bit de parada
	$serial->confFlowControl("none"); //sem controle de fluxo
	$serial->deviceOpen(); //abre o dispositivo serial para comunicacao

	
	$controle = find('controle', $idcontrole);
	
	$serial->sendMessage($msgSerial);

	$serial->deviceClose(); //encerra a conexao serial

	}
}
**********************************************************/
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
	<link rel="stylesheet" href="_css/table-style.css" />
	<link rel="stylesheet" href="_css/keyboard-style.css" />
	<link rel="stylesheet" href="_css/amb-mod-style.css" />
</head>

<form action="ambiente_equipamento.php?idambiente=<?php echo $_GET['idambiente']; ?>" method="post">
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
	<hr>
	<hr>
   	<div class="window">
	<table>
	<tbody>
	<input type="hidden" name="idambiente" value="<?php echo $idambiente; ?>">
	<?php if ($equipamentos) : ?>
	<?php foreach ($equipamentos as $equipamento) : ?>
		<tr class="info accordion accordion-button">
			<td>
				<ul>
					<li class="col-amb-equip"><?php echo $equipamento['nome']; ?></li>
					<li class="col-amb-equip actions text-right">
						<a href="equipamento.php?id=<?php echo $equipamento['id']; ?>&idambiente=<?php echo $_GET['idambiente']; ?>&acao=editar" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i><img class="glyph-icon" src="_imagens/si-glyph-pencil.svg"/></a>
						<!--<a href="#" class="btn btn-sm btn-automaeasy" data-toggle="modal" data-target="#confirm"><img class="glyph-icon" src="_imagens/si-glyph-trash.svg"/></a>-->
						<a href="javascript: confirmaExclusao(<?php echo $equipamento['id']; ?>, '<?php echo $equipamento['nome']; ?>');" class="btn btn-sm btn-automaeasy"><img class="glyph-icon" src="_imagens/si-glyph-trash.svg"/></a>
					</li>
				</ul>
			</td>
		</tr>
		
		<?php 
			if($equipamento['id_controle'] > 0){
				echo '<tr class="panel hide"><td> 
				<div class="container-ctrl">
				<div class="keyboard"> 
					<div class="function">
					 <div>
						 <!-- On/Off -->
						 <input type="hidden" name="controle[\'onoff\']" value="<?php echo $controle[\'onoff\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="onoff">
						 <img class="glyph-icon" src="_imagens/si-glyph-turn-off.svg"/>
						 </button>
						 <!-- Mudo -->
						 <input type="hidden" name="controle[\'mute\']" value="<?php echo $controle[\'mute\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="mute">
						 <img class="glyph-icon" src="_imagens/si-glyph-sound-mute.svg"/>
						 </button>
						 <!-- Modo -->
						 <input type="hidden" name="controle[\'modo\']" value="<?php echo $controle[\'modo\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="modo">
							 Mode
						 </button>
					 </div>
	 
	 
					 <div>
						 <!-- F1 -->
						 <input type="hidden" name="controle[\'func1\']" value="<?php echo $controle[\'func1\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func1">
							 F1
						 </button>
						 <!-- Volume + -->
						 <input type="hidden" name="controle[\'voltempup\']" value="<?php echo $controle[\'voltempup\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="voltempup">
							 Vol +
						 </button>
						 <!-- F2 -->
						 <input type="hidden" name="controle[\'func2\']" value="<?php echo $controle[\'func2\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func2">
							 F2
						 </button>
						 
					 </div>
					 <div>
						 <!-- Canal - -->
						 <input type="hidden" name="controle[\'canalfandw\']" value="<?php echo $controle[\'canalfandw\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="canalfandw">
						 <img class="glyph-icon" src="_imagens/si-glyph-remove.svg"/>
						 </button>
						 <!-- Enter -->
						 <input type="hidden"name="controle[\'enter\']" value="<?php echo $controle[\'enter\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="enter">
						 <img class="glyph-icon" src="_imagens/si-glyph-triangle-right.svg"/>
						 </button>
						 <!-- Canal + -->
						 <input type="hidden" name="controle[\'canalfanup\']" value="<?php echo $controle[\'canalfanup\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="canalfanup">
						 <img class="glyph-icon" src="_imagens/si-glyph-plus.svg"/>
						 </button>
					 </div>
					 <div>
						 <!-- F3 -->
						 <input type="hidden" name="controle[\'func3\']" value="<?php echo $controle[\'func3\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func3">
							 F3
						 </button>
						 <!-- Volume - -->
						 <input type="hidden" name="controle[\'voltempdw\']" value="<?php echo $controle[\'voltempdw\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="voltempdw">
							 Vol -
						 </button>
						 <!-- F4 -->
						 <input type="hidden" name="controle[\'func4\']" value="<?php echo $controle[\'func4\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func4">
							 F4
						 </button>
					 </div>
				 </div>
				 <div class="num">
					 <div>
						 <!-- 1 -->
						 <input type="hidden" name="controle[\'num1\']" value="<?php echo $controle[\'num1\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num1">1</button>
						 <!-- 2 -->
						 <input type="hidden" name="controle[\'num2\']" value="<?php echo $controle[\'num2\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num2">2</button>
						 <!-- 3 -->
						 <input type="hidden" name="controle[\'num3\']" value="<?php echo $controle[\'num3\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num3">3</button>
					 </div>
					 <div>
						 <!-- 4 -->
						 <input type="hidden" name="controle[\'num4\']" value="<?php echo $controle[\'num4\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num4">4</button>
						 <!-- 5 -->
						 <input type="hidden" name="controle[\'num5\']" value="<?php echo $controle[\'num5\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num5">5</button>
						 <!-- 6 -->
						 <input type="hidden" name="controle[\'num6\']" value="<?php echo $controle[\'num6\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num6">6</button>
					 </div>
					 <div>
						 <!-- 7 -->
						 <input type="hidden" name="controle[\'num7\']" value="<?php echo $controle[\'num7\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num7">7</button>
						 <!-- 8 -->
						 <input type="hidden" name="controle[\'num8\']" value="<?php echo $controle[\'num8\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num8">8</button>
						 <!-- 9 -->
						 <input type="hidden" name="controle[\'num9\']" value="<?php echo $controle[\'num9\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num9">9</button>
					 </div>
					 <div>
						 <!-- F5 -->
						 <input type="hidden" name="controle[\'func5\']" value="<?php echo $controle[\'func5\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func5">
							 F5
						 </button>
						 <!-- 0 -->
						 <input type="hidden" name="controle[\'num0\']" value="<?php echo $controle[\'num0\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num0">0</button>
						 <!-- F6 -->
						 <input type="hidden" name="controle[\'func6\']" value="<?php echo $controle[\'func6\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func6">
							 F6
						 </button>
						 </div>
					 </div>
					 
				</div>
			 </div></td></tr>';
			} else {
				echo '<tr class="panel hide">
					<td>
					
					<button type="submit" name="btn-onoff" class="btn btn-automaeasy btn-center p" 
						value="'.$equipamento['id'].'/'.$ambiente['endmacxbee'].'.'.$equipamento['porta'].','.$equipamento['status'].'">'.($equipamento['status'] == 1 ? "ligado" : "desligado").'</button></td></tr>';

					
					/*<button type="submit" name="btn-onoff" class="btn btn-automaeasy btn-center p" value="0013a200.414f36f9.13,1">ligar</button>
					<button type="submit" name="btn-onoff" class="btn btn-automaeasy btn-center p" value="0013a200.414f36f9.13,0">desligar</button>*/
			}
		?>
	<?php endforeach; ?>
	<?php else : ?>
		<tr>
			<td colspan="6">Nenhum registro encontrado.</td>
		</tr>
	<?php endif; ?>
	</tbody>
	</table>

	<a class="btn btn-automaeasy btn-center m" href="equipamento.php?idambiente=<?php echo $_GET['idambiente']; ?>">Adicionar Equipamentos</a>
	<div>
	<!--<div class="modal fade" id="confirm" role="dialog">
		<div class="modal-dialog modal-md">

			<div class="modal-content">
				<div class="modal-body">
						<p> Deseja excluir o equipamento?</p>
				</div>
				<div class="modal-footer">
					<a href="equipamento.php?id=<?php echo $equipamento['id']; ?>&idambiente=<?php echo $_GET['idambiente']; ?>&acao=excluir" type="button" class="btn btn-danger" id="delete">Excluir Equipamento</a>
						<button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
				</div>
			</div>

		</div>
	</div>-->
	<script>

		//Accordion
		var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
			acc[i].addEventListener("click", function() {
				var panel = this.nextElementSibling;
				
				if(panel.classList.contains("hide")){
					$('.panel').addClass("hide");
					$('.accordion').removeClass('active-accordion');
					$(this).addClass('active-accordion');
					panel.classList.remove("hide");
				}else{
					$('.panel').addClass('hide');
					$('.accordion').removeClass('active-accordion');
				}

			});
		}
		function confirmaExclusao(id, nome){
			if (confirm('Deseja excluir o equipamento ' + nome + '?')){
				// Faz o processamento necessário para exclusão
				location.replace('equipamento.php?id='+ id +'&acao=excluir');
			}
		}
	</script>
</body>
</form>
</html>

<?php
	function serialIR(){
        echo shell_exec("chmod a+rw /dev/ttyACM0");

        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
        ini_set('display_errors', '1');

        include "PhpSerial.php"; 
        $read = "";

        echo shell_exec("sudo chmod a+rw /dev/ttyACM0");

        $serial = new phpSerial();
        $serial->deviceSet("/dev/ttyACM0");
        $serial->confBaudRate(9600);
        $serial->confParity("none"); 
        $serial->confCharacterLength(8); 
        $serial->confStopBits(1); 
        $serial->confFlowControl("none"); 
        $serial->deviceOpen(); 

           

        $serial->deviceClose();
    }
?>