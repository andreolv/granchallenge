<?php

/*
 * @author André Oliveira de Araujo
*/ 

use \Smalot\PdfParser\Parser;

define('CONCURSO_PATTERN_PDF', "/([0-9]+,\s*[a-z0-9 \s*]+\s*,\s*[0-9]+,\s*[0-9 .]+)/i");

class FileHelper
{
  public $parser;
  public $pdfFile;
  public $pdfText;

  public function __construct()
  {
    $this->parser = new Parser();
  }

  public function readPdfFile($filePath)
  {
    return $this->pdf = $this->parser->parseFile($filePath);
  }

  public function getPdfText()
  {
    return strip_tags($this->pdf->getText());
  }

  public function csvToXls($text)
  {
    return str_replace(',', ';', $text);
  }

  public function generateReport($nomeArquivo)
  {
    $this->pdfText = $this->getPdfText();

    // Extração de dados do PDF
    $noBreakLines = str_replace("\xc2\xa0", ' ', $this->pdfText);
    preg_match_all(CONCURSO_PATTERN_PDF, $noBreakLines, $candidatos, PREG_PATTERN_ORDER);

    // Agrupamento dos dados em array
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

    // Criação do diretório reports
    if(!is_dir('reports')){
      mkdir('reports');
    }

    // Criação do arquivo com o nome especificado
    $csvFile = fopen('reports/' . $nomeArquivo, "w");
    $extension = substr($nomeArquivo, -3);

    // Inserção dos dados no arquivo
    $header = "Inscrição,Nome,Acertos,Nota,Vaga Deficiência";
    $header = $extension === 'xls' ? $header : $this->csvToXls($header);
  
    fwrite($csvFile, utf8_decode($header));

    foreach ($arrCandidatos as $inscricao => $candidato) {
      $linha = "\n";
      $linha .= "{$inscricao},";
      $linha .= "{$candidato['nome']},";
      $linha .= "{$candidato['acertos']},";
      $linha .= "{$candidato['nota']},";
      $linha .= "{$candidato['cota']}";

      $linha = $extension === 'xls' ? $linha : $this->csvToXls($linha);

      fwrite($csvFile, utf8_decode($linha));
    }

    fclose($csvFile);
  }
}
