<?php
require('FunctionPdf.php');
$nom="Babr";


function data_Vehicule ($Chemin,$nom,$Monadresse,$CodePostale,$ref,$NumClient,$date,$otherClientAdresse,$voiture,$marque,$prix)
{
    $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
    $pdf->AddPage();
    $pdf->addSociete( $nom,
    $Monadresse."\n".
                      $CodePostale."\n" );
    $pdf->fact_dev( "Facture ",$ref );
    $pdf->addDate( $date);
    $pdf->addClient("2+6");
    $pdf->addPageNumber("1");
    $pdf->addClientAdresse($otherClientAdresse);
    $pdf->addReglement("Stripe Reception de facture");
    $pdf->addReference("Facture due ");
    $cols=array( "REFERENCE"    => 23,
                 "DESIGNATION"  => 78,
                 "QUANTITE"     => 22,
                 "P.U. HT"      => 26,
                 "MONTANT H.T." => 30,
                 "TVA"          => 11 );
    $pdf->addCols( $cols);
    $cols=array( "REFERENCE"    => "L",
                 "DESIGNATION"  => "L",
                 "QUANTITE"     => "C",
                 "P.U. HT"      => "R",
                 "MONTANT H.T." => "R",
                 "TVA"          => "C" );
    $pdf->addLineFormat( $cols);
    $pdf->addLineFormat($cols);
    
    $y    = 109;
    $line = array( "REFERENCE"    => $ref,
                   "DESIGNATION"  => $voiture."\n" .
                                     $marque."\n",
                   "QUANTITE"     => "1",
                   "P.U. HT"      => $prix,
                   "MONTANT H.T." => $prix,
                   "TVA"          => "1" );
    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;

    $pdf->Output($Chemin.".pdf","F");

}
?>