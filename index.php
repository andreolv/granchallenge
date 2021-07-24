<?php
echo "Iniciado...\n";
include 'vendor/autoload.php';

require_once './helpers/FileHelper.class.php';

$fileHelper = new FileHelper();
$fileHelper->readPdfFile('ED_6__2019__DPDF_DEFENSOR_RES_PROVISORIO_OBJETIVA.pdf');
$fileHelper->generateReport("relatorio_aprovados.csv");

echo "Fim da execução";