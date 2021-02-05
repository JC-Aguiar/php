<?php

require 'vendor/autoload.php';

use App\Buscador\BuscadorGeral;
use App\Buscador\TextoFormatado;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$url = "https://www.sebrae.com.br";
$path = "/sites/PortalSebrae";
$filtro = 'section[class="sb-common-content__tab-temas-gestao"]';
echo "$url$path" . PHP_EOL;

$buscador = new BuscadorGeral($url);
$conteudo = $buscador->buscarString($path, $filtro);
echo (new TextoFormatado())->tratarTexto($conteudo) . PHP_EOL;
