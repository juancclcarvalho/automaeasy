<?php
	require_once 'conexao.php';

	$controls = find_all('controle');

	$controle = null;
	$idcontrole = null;
	$tecla = $_POST['tecla'];
	
	if (!empty($_GET['idcontrole'])) {
		$idcontrole = $_GET['idcontrole'];
		$controle = find('controle', $idcontrole);
	}
	

	if ($_POST['salvarbtn'] == 'Criar'){

		$controle = $_POST['controle'];

		if ($_POST['id'] == NULL) {
			save('controle', $controle);
		} else {
			update('controle', $_POST['id'], $controle);
		}

		header('location: index.php');

        } else if (!empty($_POST['tecla'])) {

	if ($_POST['tecla'] == 'onoff'){
            $IRCode = serialIR();
            $controle['onoff'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'num1'){
            $IRCode = serialIR();
            $controle['num1'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'num2'){
            $IRCode = serialIR();
            $controle['num2'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'num3'){
            $IRCode = serialIR();
            $controle['num3'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'num4'){
            $IRCode = serialIR();
            $controle['num4'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'num5'){
            $IRCode = serialIR();
            $controle['num5'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'num6'){
            $IRCode = serialIR();
            $controle['num6'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'num7'){
            $IRCode = serialIR();
            $controle['num7'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'num8'){
            $IRCode = serialIR();
            $controle['num8'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'num9'){
            $IRCode = serialIR();
            $controle['num9'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'num0'){
            $IRCode = serialIR();
            $controle['num0'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'func1'){
            $IRCode = serialIR();
            $controle['func1'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'func2'){
            $IRCode = serialIR();
            $controle['func2'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'func3'){
            $IRCode = serialIR();
            $controle['func3'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'func4'){
            $IRCode = serialIR();
            $controle['func4'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'func5'){
            $IRCode = serialIR();
            $controle['func5'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'func6'){
            $IRCode = serialIR();
            $controle['func6'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'voltempup'){
            $IRCode = serialIR();
            $controle['voltempup'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'voltempdw'){
            $IRCode = serialIR();
            $controle['voltempdw'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'canalfanup'){
            $IRCode = serialIR();
            $controle['canalfanup'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'canalfandw'){
            $IRCode = serialIR();
            $controle['canalfandw'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'enter'){
            $IRCode = serialIR();
            $controle['enter'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'mute'){
            $IRCode = serialIR();
            $controle['mute'] = $IRCode;
            echo $IRCode;
        }else if ($_POST['tecla'] == 'modo'){
            $IRCode = serialIR();
            $controle['modo'] = $IRCode;
            echo $IRCode;
        } 
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
    <link rel="stylesheet" href="_css/keyboard-style.css" />
    <link rel="stylesheet" href="_css/navbar-style.css" />
    <link rel="stylesheet" href="_css/field-style.css" />
    <link rel="stylesheet" href="_css/button-style.css" />
    
</head>
<form action="controle.php" method="post">

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
                    <a class="nav-link active" href="controle.php">Adicionar Controle</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="interface">
    <table class="controles_cadastrados_painel">   
        <?php if ($controls) : ?>
        <?php foreach ($controls as $control) : ?>
            <!--<tr class="accordion-button">
                <td>
                <ul>
                <a href="controle.php?idcontrole=<?php echo $control['id']; ?>">
                    <li class="col-index info"><?php echo $control['nome']; ?></li></a>
                </ul>
                </td>
            </tr>-->
        
                <tr>
                    <td class="controles_cadastrados_lista">
                        <a href="controle.php?idcontrole=<?php echo $control['id']; ?>">
                            <?php echo $control['nome']; ?>
                        </a>
                    <td>
                </tr>
            
        <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6">Nenhum controle encontrado.</td>
            </tr>
        <?php endif; ?>
    </table>


	    <input type="hidden" name="id" value="<?php echo $controle['id']; ?>">
            <input class="field-automaeasy" name="controle['nome']" value="<?php echo $controle['nome']; ?>" placeholder=" Insira aqui o nome do novo controle" maxlength="20"/>
            <?php echo $tecla; ?>
            <div class="container-ctrl">
				<fieldset class="keyboard"> 
					 <fieldset>
						 <!-- On/Off -->
						 <input type="hidden" name="controle['onoff']" value="<?php echo $controle['onoff'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="onoff">
						 <img class="glyph-icon" src="_imagens/si-glyph-turn-off.svg"/>
						 </button>
						 <!-- Mudo -->
						 <input type="hidden" name="controle['mute']" value="<?php echo $controle['mute'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="mute">
						 <img class="glyph-icon" src="_imagens/si-glyph-sound-mute.svg"/>
						 </button>
						 <!-- Modo -->
						 <input type="hidden" name="controle['modo']" value="<?php echo $controle['modo'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="modo">
							 Mode
						 </button>
					 </fieldset>
					 <fieldset>
						 <!-- F1 -->
						 <input type="hidden" name="controle['func1']" value="<?php echo $controle['func1'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func1">
							 F1
						 </button>
						 <!-- Volume + -->
						 <input type="hidden" name="controle['voltempup']" value="<?php echo $controle['voltempup'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="voltempup">
							 Vol +
						 </button>
						 <!-- F2 -->
						 <input type="hidden" name="controle['func2']" value="<?php echo $controle['func2'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func2">
							 F2
						 </button>
						 
					 </fieldset>
					 <fieldset>
						 <!-- Canal - -->
						 <input type="hidden" name="controle['canalfandw']" value="<?php echo $controle['canalfandw'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="canalfandw">
						 <img class="glyph-icon" src="_imagens/si-glyph-remove.svg"/>
						 </button>
						 <!-- Enter -->
						 <input type="hidden"name="controle['enter']" value="<?php echo $controle['enter'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="enter">
						 <img class="glyph-icon" src="_imagens/si-glyph-triangle-right.svg"/>
						 </button>
						 <!-- Canal + -->
						 <input type="hidden" name="controle['canalfanup']" value="<?php echo $controle['canalfanup'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="canalfanup">
						 <img class="glyph-icon" src="_imagens/si-glyph-plus.svg"/>
						 </button>
					 </fieldset>
					 <fieldset>
						 <!-- F3 -->
						 <input type="hidden" name="controle['func3']" value="<?php echo $controle['func3'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func3">
							 F3
						 </button>
						 <!-- Volume - -->
						 <input type="hidden" name="controle['voltempdw']" value="<?php echo $controle['voltempdw'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="voltempdw">
							 Vol -
						 </button>
						 <!-- F4 -->
						 <input type="hidden" name="controle['func4']" value="<?php echo $controle['func4'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func4">
							 F4
						 </button>
			
				 </fieldset>
				
					 <fieldset>
						 <!-- 1 -->
						 <input type="hidden" name="controle['num1']" value="<?php echo $controle['num1'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num1">1</button>
						 <!-- 2 -->
						 <input type="hidden" name="controle['num2']" value="<?php echo $controle['num2'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num2">2</button>
						 <!-- 3 -->
						 <input type="hidden" name="controle['num3']" value="<?php echo $controle['num3'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num3">3</button>
					 </fieldset>
					 <fieldset>
						 <!-- 4 -->
						 <input type="hidden" name="controle['num4']" value="<?php echo $controle['num4'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num4">4</button>
						 <!-- 5 -->
						 <input type="hidden" name="controle['num5']" value="<?php echo $controle['num5'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num5">5</button>
						 <!-- 6 -->
						 <input type="hidden" name="controle['num6']" value="<?php echo $controle['num6'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num6">6</button>
					 </fieldset>
					 <fieldset>
						 <!-- 7 -->
						 <input type="hidden" name="controle['num7']" value="<?php echo $controle['num7'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num7">7</button>
						 <!-- 8 -->
						 <input type="hidden" name="controle['num8']" value="<?php echo $controle['num8'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num8">8</button>
						 <!-- 9 -->
						 <input type="hidden" name="controle['num9']" value="<?php echo $controle['num9'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num9">9</button>
					 </fieldset>
					 <fieldset>
						 <!-- F5 -->
						 <input type="hidden" name="controle['func5']" value="<?php echo $controle['func5'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func5">
							 F5
						 </button>
						 <!-- 0 -->
						 <input type="hidden" name="controle['num0']" value="<?php echo $controle['num0'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="num0">0</button>
						 <!-- F6 -->
						 <input type="hidden" name="controle['func6']" value="<?php echo $controle['func6'] ?>" />
						 <button type="submit" name="tecla" class="tecla" value="func6">
							 F6
						 </button>
						 </fieldset>	 
				</fieldset>
			 </div>

    
    
    </div>
    <input type="submit" class="btn btn-automaeasy btn-center p save_control" id="create" name="salvarbtn" value="Criar" />
</body>
</form>
</html>

<?php
    function serialIR(){
        echo shell_exec("chmod a+rw /dev/ttyACM0");
        echo get_current_user();

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

            $serial->sendMessage("a"); //envia o caractere 'a' via Serial pro Arduino
            sleep(11); //delay para o Arduino enviar a resposta.
            $read = $serial->readPort(); 
            echo "<div style='clear: both; margin: 3em;'> Serial: " . $read . "</div>"; //echo para mostrar a resposta recebida do Arduino
            return $read;

        $serial->deviceClose();
    }
    function trataLeitura(){
        $IRCode = serialIR();
            if ($IRCode != 0){
                $controle['onoff'] = $IRCode;
            } else {
                echo '<script>alert("Nenhuma tecla pressionada");</script>';
            }
    }
?>