<?php
//Importar FPDF e conectar ao banco de dados
require_once '../fpdf/fpdf.php';
require '../fpdf/caracteres.php';
require_once '../config/dbcon.php';

$q = "SELECT * FROM pedido";
$qr = mysqli_query($con, $q);

if(isset($_POST['gerar'])) //Após clicar no botão para gerar o PDF
{
    //Criar o PDF com celulas de titulos, header, footer, número de páginas e fonte
    $pdf = new NovoFPDF('P','mm','A4');
    $pdf->AliasNbPages('{paginas}');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B', 14);
    $pdf->Cell(195, 10, 'Pedidos', 1, 1, 'C');
    $pdf->Cell(10, 10, 'Id', 1, 0, 'C');
    $pdf->Cell(35, 10, 'Item', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Preço', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Qnt', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Data', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Status', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Total', 1, 1, 'C');
}

$pdf->SetFont('Arial','', 14);
while($linha = mysqli_fetch_assoc($qr)) // Buscar no banco de dados
{
    //Inserir dados na tabela
    $data = date('d/m/Y', strtotime($linha['data_criado']));
    $pdf->Cell(10, 10, $linha['id'], 1, 0, 'C');
    $pdf->Cell(35, 10, $linha['item'], 1, 0, 'C');
    $pdf->Cell(25, 10, 'R$'.$linha['preco'], 1, 0, 'C');
    $pdf->Cell(20, 10, $linha['qnt'], 1, 0, 'C');
    $pdf->Cell(40, 10, $data, 1, 0, 'C');
    $pdf->Cell(40, 10, $linha['status'], 1, 0, 'C');
    $pdf->Cell(25, 10, 'R$'.$linha['total'], 1, 1, 'C');

}

//Calcular o rendimento total dos pedidos ENTREGUES
$q2 = "SELECT sum(total) AS total FROM pedido WHERE status='Entregue'";
$qr2 = mysqli_query($con, $q2);
$c = mysqli_fetch_assoc($qr2);
$rendimento = $c['total'];
$pdf->Multicell(0,2,"\n\n"); 
$pdf->Cell(155, 10, 'Rendimento Total:', 0, 0, 'R');
$pdf->Cell(40, 10, 'R$'.$rendimento, 'B', 1, 'R');


$pdf->Output();
?>