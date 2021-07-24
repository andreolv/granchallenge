<?php
include 'vendor/autoload.php';
phpinfo();

use \Smalot\PdfParser\Parser;

$parser = new Parser();
$pdf    = $parser->parseFile('ED_6__2019__DPDF_DEFENSOR_RES_PROVISORIO_OBJETIVA.pdf');
$text = strip_tags($pdf->getText());
$newtry = str_replace("\xc2\xa0", ' ', $text);

$pattern = "/([0-9]+,\s*[a-z0-9 \s*]+\s*,\s*[0-9]+,\s*[0-9 .]+)/i";
preg_match_all($pattern, $newtry, $candidatos, PREG_PATTERN_ORDER);

$arrCandidatos = [];

foreach ($candidatos[0] as $candidato) {
  $candidatoInfo = explode(',', $candidato);

  $inscricao = trim($candidatoInfo[0]);

  $nome = preg_replace('/\s/', ' ', $candidatoInfo[1]);
  $nome = str_replace('  ', ' ', trim($nome));

  $acertos = trim($candidatoInfo[2]);
  $nota = trim($candidatoInfo[3]);

  $arrCandidatos[$inscricao]['cota'] = array_key_exists($inscricao, $arrCandidatos) ? 'Sim' : 'Não';
  $arrCandidatos[$inscricao]['nome'] = $nome;
  $arrCandidatos[$inscricao]['acertos'] = $acertos;
  $arrCandidatos[$inscricao]['nota'] = $nota;
}

print_r($arrCandidatos);
