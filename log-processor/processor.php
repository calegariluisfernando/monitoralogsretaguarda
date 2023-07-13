<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

$urlLogs = "https://interno.bevicred.com.br/logs/bevicred-error.txt";
$urlApiLogs = "http://nginx/api";

$ch = curl_init("$urlApiLogs/remove-linha-logs/" . urlencode(date('Y-m-d')));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$dadosDeLogs = file_get_contents($urlLogs);
echo date('D M d') . PHP_EOL;
echo substr_count($dadosDeLogs, date('D M d')) . PHP_EOL;
$erros = explode(PHP_EOL, $dadosDeLogs);
$erros = array_filter($erros, function ($erro){ return !empty(trim($erro)); });
echo count($erros) . PHP_EOL;

$errosChunks = array_chunk($erros, 10);

foreach ($errosChunks as $linhas) {

    $jsonErros = [];
    $jsonErros['errors'] = $linhas;

    foreach ($linhas as $key => $linha) {
        $linha = extrairMensagemErro(trim($linha));
        $linhas[$key] = $linha;
    }

    $ch = curl_init("$urlApiLogs/log-error");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonErros));
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        echo 'Ocorreu um erro ao enviar as linhas de erro.' . PHP_EOL;
    } else {
        echo 'Linhas de erro enviadas com sucesso.' . PHP_EOL;
    }
}

function extrairMensagemErro($linhaLog) {
    $idxPrimeiroColchete    = strpos($linhaLog, '[');
    $linhaSemDataHora       = substr($linhaLog, $idxPrimeiroColchete + 1);
    $idxSegundoColchete     = strpos($linhaSemDataHora, ']');
    $linhaSemDataHora       = trim(substr($linhaSemDataHora, $idxSegundoColchete + 1));

    $linhaSemLevelErro      = trim($linhaSemDataHora);
    $idxTerceiroColchete    = strpos($linhaSemLevelErro, '[');
    $linhaSemLevelErro      = substr($linhaSemLevelErro, $idxTerceiroColchete + 1);
    $idxQuartoColchete      = strpos($linhaSemLevelErro, ']');
    $linhaSemLevelErro      = trim(substr($linhaSemLevelErro, $idxQuartoColchete + 1));

    $linhaSemPID            = trim($linhaSemLevelErro);
    $idxQuintoColchete      = strpos($linhaSemPID, '[');
    $linhaSemPID            = substr($linhaSemPID, $idxQuintoColchete + 1);
    $idxSextoColchete       = strpos($linhaSemPID, ']');
    $linhaSemPID            = substr($linhaSemPID, $idxSextoColchete + 1);

    $linhaSemCliente        = trim($linhaSemPID);
    $idxSetimoColchete      = strpos($linhaSemCliente, '[');
    $linhaSemCliente        = substr($linhaSemCliente, $idxSetimoColchete + 1);
    $idxOitavoColchete      = strpos($linhaSemCliente, ']');
    $linhaSemCliente        = trim(substr($linhaSemCliente, $idxOitavoColchete + 1));

    return $linhaSemCliente;
}
