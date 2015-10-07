<?php
/**
* [Descrição do arquivo].
*
* [mais informações precisa ter 1 [ENTER] para definir novo parágrafo]
*
* [pode usar quantas linhas forem necessárias]
* [linhas logo abaixo como esta, são consideradas mesmo parágrafo]
*
* @package [Nome do pacote de Classes, ou do sistema]
* @category [Categoria a que o arquivo pertence]
* @name [Apelido para o arquivo]
* @author Renato Nascimento <renato@r8tecnologia.com.br>
* @copyright [Informações de Direitos de Cópia]
* @license [link da licença] [Nome da licença]
* @link [link de onde pode ser encontrado esse arquivo]
* @version [Versão atual do arquivo]
* @since [Arquivo existe desde: Data ou Versao]
*/
include_once ("lib/MVC/Controller.php");
include_once ("lib/MVC/View.php");
include_once ("model/dados/ModelDados.php");

class ControllerDados extends Controller
{
	public static function seLogado()
	{
		if(!$_SESSION['usuarioLogado']){
			$controllerUsuario = new controllerUsuario();
			$controllerUsuario->login();
			die();
		}
	}

	public function acaoPadrao($parametros)
	{
		$this->usuarioHome($parametros);
	}

	public function insertPlanilha(){

		$objeto = new ModelDados();
		$execute = $objeto->uploadCSV();
		//$execute = $objeto->uploadCSV($nomeoferta, $codigooferta, $categoriaoferta);
	}

	public function planilha(){
		$view = new View();
		$data = array(); //data e uma variavel global padrao, que esta em lib/MVC/View.php
		$data['alunos'] = $execute; //o array dados tem o indice 'alunos'. isso vai ser tratado em listagem.html no foreach..
		$view->data = $data;
		$view->carregar("dados/uploadData.html"); //chama a view
		$view->mostrar();
	}


}
?>
