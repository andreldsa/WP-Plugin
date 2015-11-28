<?php
include 'config.php';
function connectDB() {	
	$link = mysqli_connect ( $host, $user, $password ) or die ( 'Could not connect to the database server' . mysqli_connect_error () );
	mysqli_select_db ( $link, $database ) or die ( "BD não existe!" );
	return $link;
}
function getPontuacao($pos) {
	if ($pos == 0) {
		return 0;
	} else if ($pos >= 7) {
		return 0;
	}
	$pos = $pos - 1;
	return 10 + (((5 - $pos) * (5 - $pos + 1)) / 2);
}
function getPontuacaoTotal($pontos1, $pontos2) {
	return $pontos1  + $pontos2;
}
function getQueryResultadoCategoria($idCategoria, $numEtapa, $ano ) {
	return "select * from
			    resultado_categoria
			where
			    Categoria = ".$idCategoria."
			    and Etapa_numEtapa = ".$numEtapa."
			    and Etapa_ano = ".$ano."
			order by pontos1 + pontos2 desc";
}
function getQueryTodosResultados($idCategoria, $ano) {
	return "SELECT * FROM pontos where Categoria_idCategoria = " . $idCategoria . " and ano = " . $ano . " order by pontuacao desc";
}
function getIntPontuacao($pontos) {
	$retorno = $pontos;
	return (int) $retorno;
}
function getNomeCategoria($idCategoria) {
	$link = connectDB ();
	$query = "SELECT nomeCategoria FROM categoria where idCategoria = " . $idCategoria;
	$retorno = mysqli_fetch_assoc ( mysqli_query ( $link, $query ) );
	mysqli_close ( $link );
	return $retorno ['nomeCategoria'];
}
function getCategorias() {
	$link = connectDB ();
	$query = "SELECT * FROM categoria order by idCategoria desc";
	$retorno = array ();
	$result = mysqli_query ( $link, $query ) or die ( "Impossível executar a busca.... " );
	while ( $row = mysqli_fetch_array ( $result ) ) {
		$retorno [$row ['idCategoria']] = $row ['nomeCategoria'];
	}
	mysqli_close ( $link );
	return $retorno;
}
function getPilotos() {
	$link = connectDB ();
	$query = "SELECT * FROM piloto ORDER BY piloto.nomePiloto";
	$retorno = array ();
	$result = mysqli_query ( $link, $query ) or die ( "Impossível executar a busca.... " );
	$count = 0;
	while ( $row = mysqli_fetch_array ( $result ) ) {
		$retorno [$row ['idPiloto']] = $row ['nomePiloto'];
		$count++;
	}
	mysqli_close ( $link );
	return $retorno;
}
function inserePiloto($nomeNovoPiloto) {
	$link = connectDB ();
	$query = "INSERT INTO `piloto` (`nomePiloto`) VALUES ('".$nomeNovoPiloto."')";
	mysqli_query ( $link, $query ) or die ( "Impossível executar o cadastro do piloto.... ".mysqli_error($link));
	mysqli_close ( $link );
}
function insereResultado($idPiloto,$idCategoria,$idEtapa,$posbt1,$tempobt1,$posbt2,$tempobt2) {
	$link = connectDB ();
	$query = "INSERT INTO `resultado` (`Piloto_idPiloto`, `Categoria_idCategoria`, `Etapa_idEtapa`, `tempobt1`, `posbt1`, `tempobt2`, `posbt2`) VALUES ('".$idPiloto."', '".$idCategoria."','".$idEtapa."','".$tempobt1."','".$posbt1."','".$tempobt2."','".$posbt2."')";
	mysqli_query ( $link, $query ) or die (mysqli_error($link));
	mysqli_close ( $link );
}
function getIdPiloto($piloto) {
	$link = connectDB ();
	$query = "SELECT `idPiloto` FROM `piloto` WHERE `nomePiloto` = '".$piloto."'";
	$result = mysqli_query ( $link, $query ) or die (mysqli_error($link));
	$retorno = mysqli_fetch_assoc ($result);
	mysqli_close ( $link );
	return $retorno ['idPiloto'];
}
function getIdCategoria($categoria) {
	$link = connectDB ();
	$query = "SELECT idCategoria FROM categoria WHERE nomeCategoria = " . $categoria;
	$result = mysqli_query ( $link, $query ) or die ("Impossivel buscar id da categoria");
	$retorno = mysqli_fetch_assoc ($result);
	mysqli_close ( $link );
	return $retorno ['idCategoria'];
}
function getAnos() {
	$link = connectDB ();
	$query = "SELECT * FROM etapa group by ano desc";
	$retorno = array ();
	$result = mysqli_query ( $link, $query ) or die ( "Impossível executar a busca.... " );
	while ( $row = mysqli_fetch_array ( $result ) ) {
		$retorno [$row ['ano']] = $row ['ano'];
	}
	mysqli_close ( $link );
	return $retorno;
}
function getEtapas() {
	$link = connectDB ();
	$query = "SELECT * FROM etapa ORDER BY etapa.data DESC";
	$retorno = array ();
	$result = mysqli_query ( $link, $query ) or die ( "Impossível executar a busca.... " );
	$count = 0;
	while ( $row = mysqli_fetch_array ( $result ) ) {
		$retorno [$row ['idEtapa']] = $row ['cidade']." -> ".$row['data'];
		$count++;
	}
	mysqli_close ( $link );
	return $retorno;
}
?>