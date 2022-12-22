<?php
//Importar FPDF e conectar ao banco de dados
require_once '../fpdf/fpdf.php';
require '../fpdf/caracteres.php';
require_once '../config/dbcon.php';

$q = "SELECT * FROM administrador";
$qr = mysqli_query($con, $q);


if(isset($_POST['gerar'])) //Após clicar no botão para gerar o PDF
{
    //Criar o PDF com celulas de titulos, header, footer, número de páginas e fonte
    $pdf = new NovoFPDF('P','mm','A4');
    $pdf->AliasNbPages('{paginas}');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B', 14);
    $pdf->Cell(195, 10, 'Administradores', 1, 1, 'C');
    $pdf->Cell(25, 10, 'Id', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Nome', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Usuário', 1, 0, 'C');
    $pdf->Cell(90, 10, 'Senha', 1, 1, 'C');
}

$pdf->SetFont('Arial','', 14);
while($linha = mysqli_fetch_assoc($qr)) // Buscar no banco de dados
{
    //Inserir dados na tabela
    $pdf->Cell(25, 10, $linha['id'], 1, 0, 'C');
    $pdf->Cell(40, 10, $linha['nome'], 1, 0, 'C');
    $pdf->Cell(40, 10, $linha['usuario'], 1, 0, 'C');
    $pdf->Cell(90, 10, $linha['senha'], 1, 1, 'C');
}

$pdf->Output();
?>