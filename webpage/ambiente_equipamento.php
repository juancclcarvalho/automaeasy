<?php
	require_once 'conexao.php';
	$idambiente = null;
	$equipamento = null;
	$nome = null;
	$porta = null;
	$equip = null;
	$idEquipamento = null;
	$controle = null;

	if (!empty($_GET['idambiente'])) {
		$idambiente = $_GET['idambiente'];
	} else {
		$idambiente = $_POST['idambiente'];
	}


echo '<br><br><br><br>';
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
	$equip = find('equipamento', $idEquipamento);

	if ($equip['status'] == 1) {
		$equip['status'] = 0;
	} else {
		$equip['status'] = 1;
	}
	sleep(2);
	//$serial->sendMessage(0013a200.414f36f9.13,1);

	$serial->deviceClose(); //encerra a conexao serial

	update('equipamento', $idEquipamento, $equip);
}

if(isset($_POST['tecla'])){

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

	$valorBotao = explode("/", $_POST['tecla']);
	
	$msgSerial = $valorBotao[1];
//	$idEquipamento = $valorBotao[0];
	echo $msgSerial.'<br>';
	$serial->sendMessage($msgSerial);

	$serial->deviceClose(); //encerra a conexao serial
}

$equipamentos = findIdFk('equipamento', 'id_ambiente', $idambiente);
$ambiente = find('ambiente', $idambiente);

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

<form action="ambiente_equipamento.php?idambiente=<?php echo $_GET['idambiente']; ?>" method="post">
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
					
		<?php 
			if(!$equipamento['id_controle'] > 0){
				echo '<button type="submit" name="btn-onoff" class="btn btn-automaeasy p" 
						value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$equipamento['status'].','.$equipamento['porta'].'">'.($equipamento['status'] == 1 ? "ligado" : "desligado").'</button>';

			}
					
		?>
						<a href="equipamento.php?id=<?php echo $equipamento['id']; ?>&idambiente=<?php echo $_GET['idambiente']; ?>&acao=editar" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i><img class="glyph-icon" src="_imagens/si-glyph-pencil.svg"/></a>
						<!--<a href="#" class="btn btn-sm btn-automaeasy" data-toggle="modal" data-target="#confirm"><img class="glyph-icon" src="_imagens/si-glyph-trash.svg"/></a>-->
						<a href="javascript: confirmaExclusao(<?php echo $equipamento['id']; ?>, '<?php echo $equipamento['nome']; ?>');" class="btn btn-sm btn-automaeasy"><img class="glyph-icon" src="_imagens/si-glyph-trash.svg"/></a>
					</li>
				</ul>
			</td>
		</tr>
		
		<?php 
			if($equipamento['id_controle'] > 0){
				
				$controle = find('controle', $equipamento['id_controle']);
				
				echo '<tr class="panel hide">
				<td>
					<div class="container-ctrl">
						<div class="keyboard">
							<div class="function">
								<div>
									<!-- On/Off -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['onoff'].'">
										<img class="glyph-icon" src="_imagens/si-glyph-turn-off.svg" />
									</button>
									<!--<button type="submit" name="tecla" class="tecla" 
							 value="'.$equipamento['id'].'/'.$controle['onoff'].'">
						 <img class="glyph-icon" src="_imagens/si-glyph-turn-off.svg"/>
						 </button>-->
			
									<!-- Mudo -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['mute'].'">
										<img class="glyph-icon" src="_imagens/si-glyph-sound-mute.svg" />
									</button>
			
									<!-- Modo -->
									<!--<input type="hidden" name="controle[\'modo\']" value="<?php echo $controle[\'modo\'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="modo">
							 Mode
						 </button>-->
			
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['modo'].'">
										Mode
									</button>
								</div>
			
			
								<div>
									<!-- F1 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['func1'].'">
										F1
									</button>
			
									<!-- Volume + -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['voltempup'].'">
										Vol +
									</button>
			
									<!-- F2 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['func2'].'">
										F2
									</button>
			
								</div>
								<div>
									<!-- Canal - -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['canalfandw'].'">
										<img class="glyph-icon" src="_imagens/si-glyph-remove.svg" />
									</button>
			
									<!-- Enter -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['enter'].'">
										<img class="glyph-icon" src="_imagens/si-glyph-triangle-right.svg" />
									</button>
			
									<!-- Canal + -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['canalfanup'].'">
										<img class="glyph-icon" src="_imagens/si-glyph-plus.svg" />
									</button>
								</div>
								<div>
									<!-- F3 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['func3'].'">
										F3
									</button>
			
									<!-- Volume - -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['voltempdw'].'">
										Vol -
									</button>
			
									<!-- F4 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['func4'].'">
										F4
									</button>
								</div>
							</div>
							<div class="num">
								<div>
									<!-- 1 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['num1'].'">
										1
									</button>
			
									<!-- 2 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['num2'].'">
										2
									</button>
			
									<!-- 3 -->                       
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['num3'].'">
										3
									</button>
								</div>
								<div>
									<!-- 4 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['num4'].'">
										4
									</button>
			
									<!-- 5 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['num5'].'">
										5
									</button>
			
									<!-- 6 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['num6'].'">
										6
									</button>
								</div>
								<div>
									<!-- 7 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['num7'].'">
										7
									</button>
			
									<!-- 8 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['num8'].'">
										8
									</button>
			
									<!-- 9 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['num9'].'">
										9
									</button>
								</div>
								<div>
									<!-- F5 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['func5'].'">
										F5
									</button>
			
									<!-- 0 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['num0'].'">
										0
									</button>
									
									<!-- F6 -->
									<button type="submit" name="tecla" class="tecla" value="'.$equipamento['id'].'/1.'.$ambiente['endmacxbee'].'.'.$controle['func6'].'">
										F6
									</button>
								</div>
							</div>
			
						</div>
					</div>
				</td>
			</tr>';
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

		/*function teclasNumericas(num){
			
		}

		function confirmaEnvio(){

		}*/
	</script>
</form>
</body>
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