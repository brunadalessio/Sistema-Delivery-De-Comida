<?php
//Importar FPDF e conectar ao banco de dados
require_once '../fpdf/fpdf.php';
require '../fpdf/caracteres.php';
require_once '../config/dbcon.php';

$q = "SELECT * FROM cardapio";
$qr = mysqli_query($con, $q);


if(isset($_POST['gerar'])) //Após clicar no botão para gerar o PDF
{
    //Criar o PDF com celulas de titulos, header, footer, número de páginas e fonte
    $pdf = new NovoFPDF('P','mm','A4');
    $pdf->AliasNbPages('{paginas}');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B', 14);
    $pdf->Cell(195, 10, 'Cardápios', 1, 1, 'C');
    $pdf->Cell(10, 10, 'Id', 1, 0, 'C');
    $pdf->Cell(80, 10, 'Titulo', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Preço', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Categoria', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Destaque', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Status', 1, 1, 'C');
}

$pdf->SetFont('Arial','', 14);
while($linha = mysqli_fetch_assoc($qr)) // Buscar no banco de dados
{
    //Inserir dados na tabela
    $pdf->Cell(10, 10, $linha['id'], 1, 0, 'C');
    $pdf->Cell(80, 10, $linha['titulo'], 1, 0, 'C');
    $pdf->Cell(25, 10, 'R$'.$linha['preco'], 1, 0, 'C');
    $pdf->Cell(25, 10, $linha['categoria_id'], 1, 0, 'C');
    $pdf->Cell(25, 10, $linha['destaque'], 1, 0, 'C');
    $pdf->Cell(30, 10, $linha['status'], 1, 1, 'C');
}

$pdf->Output();
?>