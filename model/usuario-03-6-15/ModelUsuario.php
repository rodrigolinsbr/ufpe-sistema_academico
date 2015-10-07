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

include_once ("lib/MVC/Model.php");

class ModelUsuario extends Model
{
	public function __construct()
	{
		parent::__construct(); //esse construct e herdado da classe model..
	}



	public function cadastrarUsuario($nome, $login, $email, $senha, $endereco, $cpf, $sexo, $x, $y, $z, $j)
	{

				$sql = "INSERT INTO usuario(
											nome,
											login,
											email,
											senha,
											endereco,
											cpf,
											sexo,
											telefone_id_telefone,
											administrador_id_admin,
											professor_id_professor,
											aluno_id_aluno
											)
									 VALUES(
									 		'{$nome}',
	 								 		'{$login}',
	 								 		'{$email}',
	 								 		md5('{$senha}'),
	 								 		'{$endereco}',
	 								 		'{$cpf}',
	 								 		'{$sexo}',
	 								 		1,
	 								 		1,
	 								 		1,
	 								 		1); ";

			$acao    = $this->conexao->prepare($sql);
			$retorno['result'] = $acao->execute();


	// 	if(!$this->pesquisarPorEmail($email)){
	// 		//$usu_id = $this->conexao->nextId('usuario_seq');

	// 		$sql  = "
	// 					INSERT INTO usuario(
	// 										nome,
	// 										login,
	// 										email,
	// 										senha,
	// 										endereco,
	// 										cpf,
	// 										sexo,
	// 										telefone_id_telefone,
	// 										administrador_id_admin,
	// 										professor_id_professor,
	// 										aluno_id_aluno,
	// 										telefone_id_telefone
	// 										)
	// 								 VALUES(
	// 								 		'{$nome}',
	// 								 		'{$login}',
	// 								 		'{$email}',
	// 								 		md5('{$senha}'),
	// 								 		'{$endereco}',
	// 								 		'{$cpf}',
	// 								 		'{$sexo}',
	// 								 		'{$telefone}',
	// 								 		1,
	// 								 		1,
	// 								 		1,
	// 								 		1
	// 								 		);
	// 				";

	// 		$acao    = $this->conexao->prepare($sql);
	// 		$retorno['result'] = $acao->execute();
	// 	}else{
	// 		$retorno['result'] = false;
	// 		$retorno['msg']    = 'E-mail já utilizado.';
	// 	}

	// 	return $retorno;
	}

	public function pesquisarPorEmail($email)
	{

		echo "email: " .$email;
		$sql = "SELECT * from usuario where email = '{$email}' ";
		$rs  = $this->conexao->query($sql);
		if($rs){
        	$arr = $rs->fetchAll(PDO::FETCH_ASSOC);
        	$arr = $this->montarListaObjetos($arr, 'Usuario');
			return $arr;

		}else{
			return false;
		}
	}

	public function alterarRegistro($id, $nome, $codoferta, $cpf, $telefone, $email, $categoryid){

		$id = $_POST['id'];
		echo "funcao alterarRegistro... <br>";
		echo "nome dentro de alterara registro: " .$nome;
		echo "<br>";
		echo "Id no ModelUsuario: " .$id;
		$sql = "UPDATE sa_user_docs SET
		nome = '{$nome}' WHERE id = '{$id}' ";
		// $acao = $this->conexao->prepare($sql);
		// return $acao->execute();

		$acao    = $this->conexao->prepare($sql);
		$retorno['result'] = $acao->execute();

	}

	public function pesquisarTodos(){

		$sql = "SELECT ud.id, u.id as idmoodle, concat(u.firstname, ' ', u.lastname) as nome,
		uo.codoferta, ud.cpf, ud.telefone as telefone, u.email, cc.categoryid
				FROM sa_user_docs ud
				INNER JOIN sa_user_oferta uo ON uo.cpf = ud.cpf
				INNER JOIN mdl_user u ON u.username = ud.cpf
				INNER JOIN sa_oferta_course_categories cc ON cc.codoferta = uo.codoferta WHERE ud.flag = 0";
		$result = $this->conexao->query($sql);
		if ($result) {
			$linhas = $result->fetchAll(PDO::FETCH_ASSOC);
			$linhas = $this->montarListaObjetos($linhas, 'Usuario');

			return $linhas;
		}else{
			return false;
		}
	}


	//pesquisa informações de um usuário
	public function pesquisarId($id)
	{
		echo "id dentro de pesquisarId: " .$id;
//		$sql = "SELECT * from usuario where id_usuario = '$id' ";
		// $sql = "SELECT ud.id, u.id as idmoodle, concat(u.firstname, ' ', u.lastname) as nome,
		// uo.codoferta, ud.cpf, ud.telefone as telefone, u.email, cc.categoryid
		// 		FROM sa_user_docs ud
		// 		INNER JOIN sa_user_oferta uo ON uo.cpf = ud.cpf
		// 		INNER JOIN mdl_user u ON u.username = ud.cpf
		// 		INNER JOIN sa_oferta_course_categories cc ON cc.codoferta = uo.codoferta WHERE ud.flag = 0 and ud.id = '$id' ";

		$sql = "SELECT nome, codoferta, cpf, telefone,
		email, uf, ano_graduacao FROM sa_user_docs ud
		WHERE ud.id = '$id' ";

		$rs  = $this->conexao->query($sql);
		if($rs){
        	$arr = $rs->fetchAll(PDO::FETCH_ASSOC);
        	$arr = $this->montarListaObjetos($arr, 'Usuario');  //essa linha prepara os objetos para serem impressos os objetos na tela

        	// print_r($arr);
   			return $arr;

		}else{
			return false;
		}
	}







    public function consultarPorId($id)
    {
		$sql = "SELECT * from usuario where id_usuario = '{$id}'";
     	$rs  = $this->conexao->query($sql);
		if($rs && $rs->rowCount()){
        	$arr = $rs->fetchAll(PDO::FETCH_ASSOC);
			$arr = $this->montarListaObjetos($arr, 'Usuario');
            return $arr[0];
		}else{
			return false;
		}

    }

    public function alterarUsuario($arr)
    {
        if ($arr->senha != "**********"):
            $senha = ", senha = ".md5($arr->senha)."";
        endif;
        $sql = "UPDATE admin SET nome = '".addslashes($arr->nome)."', usu_nome = '".addslashes($arr->login)."' ".$senha." WHERE usu_id = ".$_SESSION['usuario']['id'];
        //echo $sql;
		$acao = $this->conexao->prepare($sql);
		return $acao->execute();
    }

}
?>
