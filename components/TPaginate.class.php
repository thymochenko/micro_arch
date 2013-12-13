<?php
/*
 * Author	Gilberto Albino
 * License	None
 * Date		2009-03-15
 */
/*
 * Pedimos para o PHP mostrar os erros, caso esteja desativado
 */



/*
 * Classe para paginação em PDO
 */
class TPaginate
{
  public $paginador = 'pag';
  private $solicitador;
  public $sql;
  public $limite;
  public $quantidade;

  // Construtor carrega a string usada para como paginador
  public function __construct()
  {
	@$this->solicitador = $_REQUEST["{$this->paginador}"];
  }

  // Retorna o número de resultados encontrados
  public function resultado()
  {
	$conn = TTransaction::get();
	$this->resultado = $conn->query(str_replace('*', 'COUNT(*)', $this->sql));
	$this->numeroResultados = $this->resultado->fetchColumn();
	return $this->numeroResultados;
  }
  // Imprime um texto amigável mostrando o status das paginas em relação ao resultado atual
  public function imprimeBarraResultados()
  {
	if($this->resultado() > 0) {
	  echo '<p class="info_resultado_busca">';
	  echo 'Exibindo pagina <b style="font-size:20px">' . $this->paginaAtual()
	  . '</b> de <b style="font-size:20px">' . $this->paginasTotais()
	  . '</b> disponiveis para <b style="font-size:20px">'
	  . $this->resultado() . '</b> resultados encontrados.</p>';
	} else {
      echo '<p class="info_resultado_busca">Não foram encontrados resultados para sua busca.</p>';
	}
  }
  // Calcula o número total de páginas
  public function paginasTotais()
  {
    if($this->resultado() == 0 OR $this->limite == 0){
	    return FALSE;
	}
	if(is_array($this->limite))
	{
	    $this->limite=$this->limite['limite'];
	}
	$paginasTotais = ceil($this->resultado() / $this->limite);
	return $paginasTotais;
  }
  // Procura o número da página Atual
  public function paginaAtual()
  {
	if (isset($this->solicitador) && is_numeric($this->solicitador)) {
	  $this->paginaAtual = (int) $this->solicitador;
	} else {
      $this->paginaAtual = 1;
	}

	if ($this->paginaAtual > $this->paginasTotais()) {
      $this->paginaAtual = $this->paginasTotais();
	}

	if ($this->paginaAtual < 1) {
      $this->paginaAtual = 1;
	}

	return $this->paginaAtual;
  }
  // Calcula o offset da consulta
  private function offset()
  {
    if(is_array($this->limite)): $this->limite=$this->limite['limite']; endif;
	$offset = ($this->paginaAtual() - 1) * $this->limite;
	return $offset;
  }
  // Retorna o SQL para trabalhar posteriormente
  public function sql($criteria=NULL)
  {
    if($this->limite == 0 OR $this->offset() == 0){
	    $sql = $this->sql .  "";
	    return $sql;
	}
  else{
    $sql = $this->sql .  " LIMIT {$this->limite} OFFSET {$this->offset()} ";
	return $sql;
   }
  }
  // Imprime a barra de navegação da paginaçaõ
  public function imprimeBarraNavegacao()
  {
     $method = $_GET['method'];
     $method = htmlspecialchars(addslashes($method));
	if($this->resultado() > 0) {
	  echo '<div>';
      if ($this->paginaAtual() > 1) {
		echo " <a href='?" . $this->paginador . "=1"
		. $this->reconstruiQueryString($this->paginador) ."&method=$method" . "'>Primeira</a> ";
		$anterior = $this->paginaAtual() - 1;
		echo " <a href='?" . $this->paginador . "=" . $anterior
		. $this->reconstruiQueryString($this->paginador) .  "&method=$method" ."'>Anterior</a> ";
	  }

	  for ($x = ($this->paginaAtual() - $this->quantidade); $x <
	  (($this->paginaAtual() + $this->quantidade) + 1); $x++) {
		if (($x > 0) && ($x <= $this->paginasTotais())) {
		  if ($x == $this->paginaAtual()) {
			echo " [<b>$x</b>] ";
		  } else {
			echo " <a href='?" . $this->paginador . "=" . $x
			. $this->reconstruiQueryString($this->paginador) ."&method=$method" ."'>$x</a> ";
		  }
		}
	  }

	  if ($this->paginaAtual() != $this->paginasTotais()) {
		$paginaProxima = $this->paginaAtual() + 1;
		echo " <a href='?" . $this->paginador . "=" . $paginaProxima
		. $this->reconstruiQueryString($this->paginador) ."&method=$method". "'>Próxima</a> ";
		echo " <a href='?" . $this->paginador . "=" . $this->paginasTotais()
		. $this->reconstruiQueryString($this->paginador) ."&method=$method" ."'>Última</a> ";
	  }

	  echo '</div>';
	}
  }
  // Monta os valores da Query String novamente
  public function reconstruiQueryString($valoresQueryString) {
	if (!empty($_SERVER['QUERY_STRING'])) {
	  $partes = explode("&", $_SERVER['QUERY_STRING']);
	  #print_r($partes);
	  $novasPartes = array();
	  foreach ($partes as $val) {
	    if (stristr($val, $valoresQueryString) == false)  {
          array_push($novasPartes, $val);
		}
	  }
	  if (count($novasPartes) != 0) {
		  $queryString = "&".implode("&", $novasPartes);
	  } else {
		return false;
	  }
	  return $queryString; // nova string criada
	} else {
      return false;
	}
  }	

}


