<?php
  require('fpdf.php');
  include('../includes/dbh.inc.php');

  $sql = "SELECT * FROM users WHERE usersId > '3'";
  $result = mysqli_query($conn, $sql);
  $nrows = mysqli_num_rows($result);

  $column_usersId = "";
  $column_usersName = "";
  $column_usersEmail = "";
  $column_usersUid = "";

  while($row = mysqli_fetch_assoc($result))  {

    $Id = $row["usersId"];
    $Name = $row["usersName"];
    $Email = $row["usersEmail"];
    $Uid = $row["usersUid"];

    $userName = stripslashes($Name);
    $userName = iconv('UTF-8', 'windows-1252', $userName);

    $userUName = stripslashes($Uid);
    $userUName = iconv('UTF-8', 'windows-1252', $userUName);

    $column_usersId = $column_usersId.$Id."\n";
    $column_usersName = $column_usersName.$userName."\n";
    $column_usersEmail = $column_usersEmail.$Email."\n";
    $column_usersUid = $column_usersUid.$userUName."\n";

  }

  mysqli_close($conn);

  class PDF extends FPDF  {
    function Header() {
      $this->Image('logo.png',90,65,30);
      $this->SetFont('Arial','B',50);
      $this->Cell(20);
      $this->SetFillColor(252, 186, 3);
      $this->MultiCell(150, 40, 'Black Cat Users', 1,'C', true);
      $compweb = stripslashes("Composição Web");
      $compweb = iconv('UTF-8', 'windows-1252', $compweb);
      $this->SetFont('Arial','B',20);
      $this->Cell(45);
      $this->MultiCell(100, 20, $compweb, 0,'C');
      $this->SetFont('Arial','B',12);
      $this->Cell(46);
      $this->MultiCell(100, 55, 'Afonso Calinas - Fernando Gomes', 0,'C');
      $this->SetFont('Arial','B',10);
      $n = stripslashes("Nº46892");
      $n = iconv('UTF-8', 'windows-1252', $n);
      $this->SetY(98);
      $this->SetX(76);
      $this->Cell(20,10,$n,0,0,'C');
      $n = stripslashes("Nº45511");
      $n = iconv('UTF-8', 'windows-1252', $n);
      $this->SetY(98);
      $this->SetX(113);
      $this->Cell(20,10,$n,0,0,'C');
      $this->SetFont('Arial','B',12);
      $curso = stripslashes("Informática Web");
      $curso = iconv('UTF-8', 'windows-1252', $curso);
      $this->SetY(105);
      $this->SetX(94);
      $this->Cell(20,10,$curso,0,0,'C');
      $this->Ln(20);
    }

    function Footer() {
      $this->SetY(-15);
      $this->SetFont('Arial','I',8);
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
  }

  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->SetAuthor("Black Cat");
  $pdf->SetTitle("Black Cat's Users");
  $pdf->AddPage();
  $pdf->SetFillColor(232,232,232);
  $pdf->SetFont('Arial','B',12);
  $pdf->SetY(120); // was 20
  $pdf->SetX(25);
  $pdf->Cell(20,6,'UsersId',1,0,'L',1);
  $pdf->SetX(45);
  $pdf->Cell(40,6,'UsersName',1,0,'L',1);
  $pdf->SetX(85);
  $pdf->Cell(60,6,'UsersEmail',1,0,'L',1);
  $pdf->SetX(145);
  $pdf->Cell(40,6,'UsersUid',1,0,'L',1);
  $pdf->Ln();
  $pdf->SetFont('Arial','',12);

  $margin = 126; // was 26
  $pdf->SetFillColor(252, 186, 3);
  $pdf->SetFont('Arial','B',10);
  $pdf->SetY($margin);
  $pdf->SetX(25);
  $pdf->MultiCell(20,6,"1",1,'L', true);
  $pdf->SetY($margin);
  $pdf->SetX(45);
  $pdf->MultiCell(40,6,"Afonso",1,'L', true);
  $pdf->SetY($margin);
  $pdf->SetX(85);
  $pdf->MultiCell(60,6,"a46892@ubi.pt",1,'L', true);
  $pdf->SetY($margin);
  $pdf->SetX(145);
  $pdf->MultiCell(40,6,"YellowCat",1,'L', true);

  $margin = 132; // era 26
  $pdf->SetFillColor(252, 186, 3);
  $pdf->SetFont('Arial','B',10);
  $pdf->SetY($margin);
  $pdf->SetX(25);
  $pdf->MultiCell(20,6,"2",1,'L', true);
  $pdf->SetY($margin);
  $pdf->SetX(45);
  $pdf->MultiCell(40,6,"Fernando",1,'L', true);
  $pdf->SetY($margin);
  $pdf->SetX(85);
  $pdf->MultiCell(60,6,"a45511@ubi.pt",1,'L', true);
  $pdf->SetY($margin);
  $pdf->SetX(145);
  $pdf->MultiCell(40,6,"BlackCat",1,'L', true);

  $margin = 138; // era 26
  $pdf->SetFillColor(252, 186, 3);
  $pdf->SetFont('Arial','B',10);
  $pdf->SetY($margin);
  $pdf->SetX(25);
  $pdf->MultiCell(20,6,"3",1,'L', true);
  $pdf->SetY($margin);
  $pdf->SetX(45);
  $nome = stripslashes("Sebastião");
  $nome = iconv('UTF-8', 'windows-1252', $nome);
  $pdf->MultiCell(40,6,$nome,1,'L', true);
  $pdf->SetY($margin);
  $pdf->SetX(85);
  $pdf->MultiCell(60,6,"sebastiao@di.ubi.pt",1,'L', true);
  $pdf->SetY($margin);
  $pdf->SetX(145);
  $pdf->MultiCell(40,6,"Professor",1,'L', true);

  $margin = 144; // era 26
  $pdf->SetFont('Arial','B',10);
  $pdf->SetY($margin);
  $pdf->SetX(25);
  $pdf->MultiCell(20,6,$column_usersId,1);
  $pdf->SetY($margin);
  $pdf->SetX(45);
  $pdf->MultiCell(40,6,$column_usersName,1);
  $pdf->SetY($margin);
  $pdf->SetX(85);
  $pdf->MultiCell(60,6,$column_usersEmail,1,'L');
  $pdf->SetY($margin);
  $pdf->SetX(145);
  $pdf->MultiCell(40,6,$column_usersUid,1,'L');

  $i = 0;
  $pdf->SetY($margin);
  while ($i < $nrows)
  {
    $pdf->SetX(25);
    $pdf->MultiCell(160,6,'',1);
    $i = $i+1;
  }

  $pdf->Output("Black Cat's Users.pdf", "i");
?>
