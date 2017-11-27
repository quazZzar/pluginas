<?php
// http://www.mandomarketing.com/mapgen/make.php?typ=ss-ticket

$tmpName = $_FILES['csv']['tmp_name'];
$csv = array_map('str_getcsv', file($tmpName));

require_once('fpdf.php');
require_once('fpdi.php');

$grey['r'] = 95;
$grey['g'] = 95;
$grey['b'] = 95;

$Xadj = 0;
$Yadj = 0;

$pdf = new FPDI();

$pdf->AddFont('Lato','','Lato-Regular.php');
$pdf->AddFont('Lato Bold','','Lato-Bold.php');


//$pdf->SetLeftMargin(100);

$pageCount = $pdf->setSourceFile('templates/' . $_POST['typ'] . '.pdf');
$tmpl_pg1 = $pdf->importPage(1);
$tmpl_pg2 = $pdf->importPage(2);


$rows = array(1,2);

$skip = true; //always skip 1st one - i.e. col heading
foreach($csv as $crow){
	
	if( 1 ){
	
		$skip = false;
		
		$pdf->addPage();
		$pdf->useTemplate($tmpl_pg1, -8+$Xadj, -1+$Yadj, 230);
		$pdf->SetFont('Lato', '' , 12);
	
	
		$pdf->Text(19+$Xadj, 72+$Yadj, 'Craig Myers'); //agent name
		$pdf->Text(19+$Xadj, 77+$Yadj, 'CR Myers & Associates'); //practice name	
		$pdf->Text(19+$Xadj, 82+$Yadj, '27777 Franklin Rd.'); //practice address1	
		$pdf->Text(19+$Xadj, 87+$Yadj, '#700'); //practice address2
		$pdf->Text(19+$Xadj, 92+$Yadj, 'Southfield, MI 48034'); //practice city state zip	
		$pdf->Text(19+$Xadj, 97+$Yadj, '(866) 401-8292'); //practice phone	
		$pdf->Text(19+$Xadj, 110+$Yadj, date("m.d.y") ); //date	

		//salutation
		$pdf->SetFillColor(255,255,255);
		$pdf->Rect(17+$Xadj, 119+$Yadj, 65 ,10 , 'F');	
		$pdf->Text(19+$Xadj, 125+$Yadj, "Dear {$crow[0]} {$crow[1]},"); //attendee	

		//Sincerely
		//$pdf->Rect(17+$Xadj, 219+$Yadj, 65 ,15 , 'F');		
		$pdf->Text(19+$Xadj, 221+$Yadj, 'Craig Myers'); //agent name
		$pdf->Text(19+$Xadj, 226+$Yadj, 'CR Myers & Associates'); //practice name	

		//Page 1 footer
		$pdf->SetFont('Lato Bold','',18);
		$pdf->SetTextColor(130, 185, 65);	
		$pdf->Text(19+$Xadj, 244+$Yadj, 'Thu, December 1, 2016'); //workshop Date (green)
		
		$pdf->SetFont('Lato','',16);
		$pdf->SetTextColor(0, 0, 0);		
		$pdf->Text(19+$Xadj, 251+$Yadj, '6:00 PM – 7:30 PM EST'); //workshop time
		$pdf->Text(19+$Xadj, 258+$Yadj, 'Walsh College - Novi Campus'); //workshop venue
		$pdf->Text(19+$Xadj, 265+$Yadj, '41500 Gardenbrook Road Novi, MI 48375-1313'); //workshop full address
		
		if(1){	
			
			$pdf->Text(19+$Xadj, 272+$Yadj, 'Room 507'); //workshop room number
		}
	}
}

$pdf->Output();

/*
Array ( [0] => Nick Maggard [1] => Maggard and Menefee Law Firm LLC [2] => 7310 Turfway Road [3] => Suite 550 [4] => Florence KY 41042 [5] => 859-372-6674 [6] => 9-Nov-16 [7] => 10:00 am - 12:00 pm EST [8] => Kenton County Library [9] => 1992 Walton-Nicholson Road Independence KY 41051 [10] => null [11] => 1992 Walton-Nicholson Road [12] => null [13] => Independence KY 41051 [14] => Robert [15] => Messmer [16] => kyclays54@gmail.com [17] => 1 [18] => RSVP Here [19] => Free Order [20] => 0 [21] => 0 [22] => 0 [23] => Attending [24] => 15721 Violet Rd [25] => null [26] => Crittenden [27] => KY [28] => 41030 [29] => US [30] => 8599911172 ) 
*/