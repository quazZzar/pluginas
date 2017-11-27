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
	
	if( !$skip ){
	
		$skip = false;
		
		$pdf->addPage();
		$pdf->useTemplate($tmpl_pg1, -8+$Xadj, -1+$Yadj, 230);
		$pdf->SetFont('Lato', '' , 12);
		
		$pdf->Text(19+$Xadj, 72+$Yadj, $crow[0]); //agent name
		$pdf->Text(19+$Xadj, 77+$Yadj, $crow[1]); //practice name	
		$pdf->Text(19+$Xadj, 82+$Yadj, $crow[2]); //practice address1	
		$pdf->Text(19+$Xadj, 87+$Yadj, $crow[3]); //practice address2
		$pdf->Text(19+$Xadj, 92+$Yadj, $crow[4]); //practice city state zip	
		$pdf->Text(19+$Xadj, 97+$Yadj, $crow[5]); //practice phone	
		$pdf->Text(19+$Xadj, 110+$Yadj, date("m.d.y") ); //date	

		//salutation
		$pdf->SetFillColor(255,255,255);
		$pdf->Rect(17+$Xadj, 119+$Yadj, 65 ,10 , 'F');	
		$pdf->Text(19+$Xadj, 125+$Yadj, "Dear {$crow[14]} {$crow[15]},"); //attendee	

		//Sincerely
		//$pdf->Rect(17+$Xadj, 219+$Yadj, 65 ,15 , 'F');		
		$pdf->Text(19+$Xadj, 221+$Yadj, $crow[0]); //agent name
		$pdf->Text(19+$Xadj, 226+$Yadj, $crow[1]); //practice name	

		//Page 1 footer
		$pdf->SetFont('Lato Bold','',18);
		$pdf->SetTextColor(130, 185, 65);	
		$pdf->Text(19+$Xadj, 244+$Yadj, $crow[6]); //workshop Date (green)
		
		$pdf->SetFont('Lato','',16);
		$pdf->SetTextColor(0, 0, 0);		
		$pdf->Text(19+$Xadj, 251+$Yadj, $crow[7]); //workshop time
		$pdf->Text(19+$Xadj, 258+$Yadj, $crow[8]); //workshop venue
		$pdf->Text(19+$Xadj, 265+$Yadj, $crow[9]); //workshop full address
		
		if($crow[10] != 'null' && !empty($crow[10])){	
			
			$pdf->Text(19+$Xadj, 272+$Yadj, $crow[10]); //workshop room number
		}
		
		//page 2
		$pdf->addPage();
		$pdf->useTemplate($tmpl_pg2, $Xadj-8, $Yadj-1, 230);	

		$pdf->SetFont('Lato','',12);	
		$pdf->Text(164+$Xadj, 40+$Yadj, $crow[14]); //attendee first
		$pdf->Text(164+$Xadj, 45+$Yadj, $crow[15]); //attendee last
		
		$pdf->SetFont('Lato Bold', '', 16);
		$pdf->SetTextColor(130, 185, 65);	
		$pdf->Text(44+$Xadj, 66+$Yadj, $crow[6]); // workshop Date (green)
		$pdf->SetFont('Lato Bold', '', 13);	
		$pdf->SetTextColor(0, 0, 0);	
		$pdf->Text(44+$Xadj, 71+$Yadj, $crow[7]); // workshop time		

		$pdf->SetFont('Lato Bold','',11);	
		$pdf->SetTextColor(0, 0, 0);	
		$pdf->Text(104+$Xadj, 65+$Yadj, $crow[8]); //workshop venue
		$pdf->Text(104+$Xadj, 71+$Yadj, $crow[11]); //workshop add1
		if( $crow[12] != 'null' && !empty($crow[12]) ){
			
			$pdf->Text(104+$Xadj, 76+$Yadj, $crow[12]); //workshop add2
			$pdf->Text(104+$Xadj, 81+$Yadj, $crow[13]); //workshop city state zip
			
			if($crow[10] != 'null' && !empty($crow[10])){
				
				$pdf->Text(104+$Xadj, 86+$Yadj, $crow[10]); //workshop room number		
			}		
		}
		else{
			$pdf->Text(104+$Xadj, 76+$Yadj, $crow[13]); //workshop city state zip

			if($crow[10] != 'null' && !empty($crow[10])){
				
				$pdf->Text(104+$Xadj, 81+$Yadj, $crow[10]); //workshop room number		
			}			
		}
			
		$map = 'directory/maps/' . $crow[14] . '-' . $crow[15] . '.jpg';
		
		if(@fopen($map, "r")){
			
			$pdf->Image($map, 19+$Xadj,143+$Yadj,175.2,139, 'PNG');
		}
		
		$pdf->SetFillColor(255,255,255);
		$pdf->SetDrawColor(130, 185, 65);
		$pdf->Rect(18.4+$Xadj, 133+$Yadj, 176.4 ,9 , 'DF');
		$pdf->SetFont('Lato','',10);
		$pdf->Text(21+$Xadj, 137+$Yadj, "From: {$crow[24]} {$crow[26]} {$crow[27]} {$crow[28]}" ); //from
		$pdf->Text(21+$Xadj, 140.5+$Yadj, "To: {$crow[9]}" ); //to
	
	}
}

$pdf->Output();

/*
Array ( [0] => Nick Maggard [1] => Maggard and Menefee Law Firm LLC [2] => 7310 Turfway Road [3] => Suite 550 [4] => Florence KY 41042 [5] => 859-372-6674 [6] => 9-Nov-16 [7] => 10:00 am - 12:00 pm EST [8] => Kenton County Library [9] => 1992 Walton-Nicholson Road Independence KY 41051 [10] => null [11] => 1992 Walton-Nicholson Road [12] => null [13] => Independence KY 41051 [14] => Robert [15] => Messmer [16] => kyclays54@gmail.com [17] => 1 [18] => RSVP Here [19] => Free Order [20] => 0 [21] => 0 [22] => 0 [23] => Attending [24] => 15721 Violet Rd [25] => null [26] => Crittenden [27] => KY [28] => 41030 [29] => US [30] => 8599911172 ) 
*/