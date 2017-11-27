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

$fidx = $_POST['first']-1;


//$pdf->SetLeftMargin(100);

$pageCount = $pdf->setSourceFile('templates/' . $_POST['typ'] . '.pdf');
$tmpl_pg1 = $pdf->importPage(1);
$tmpl_pg2 = $pdf->importPage(2);


$rows = array(1,2);

$skip = true; //always skip 1st one - i.e. col heading

$i = 0;
foreach($csv[0] as $a_header){
	
	if('First Name' == $a_header){
		
		$indx['Fname'] = $i;
	}
		
	if('Last Name' == $a_header){
		
		$indx['Lname'] = $i;
	}

	if('Date Attending' == $a_header){
		
		$indx['event'] = $i;
	}

	$i++;
}

if( empty($indx['event']) ){

	die('No "Date Attending" Column Found!');
}

foreach($csv as $crow){
	
	$Fname = ucwords(str_replace(' and ', ' & ', strtolower($crow[$indx['Fname']])));
	$Lname = $crow[$indx['Lname']];
		
	$tmp = explode(' at ', $crow[$indx['event']]);
	$event_date = date("D, F j Y", strtotime($tmp[0]));
	$event_time = $tmp[1];
	
	
	if( 1 ){
	
		$skip = false;
		
		$pdf->addPage();
		$pdf->useTemplate($tmpl_pg1, -8+$Xadj, -1+$Yadj, 230);
		$pdf->SetFont('Lato', '' , 12);
	
		$pdf->Text(19+$Xadj, 72+$Yadj, utf8_decode($_POST['agent-name'])); //agent name
		$pdf->Text(19+$Xadj, 77+$Yadj, $_POST['practice-name']); //practice name	
		$pdf->Text(19+$Xadj, 82+$Yadj, $_POST['agent-address-1']); //practice address1	
		
		if($_POST['agent-address-2'] != 'null' && !empty($_POST['agent-address-2'])){
			
			$pdf->Text(19+$Xadj, 87+$Yadj, $_POST['agent-address-2']); //practice address2
			$pdf->Text(19+$Xadj, 92+$Yadj, $_POST['agent-city']); //practice city state zip	
			$pdf->Text(19+$Xadj, 97+$Yadj, $_POST['agent-phone']); //practice phone	
			$pdf->Text(19+$Xadj, 110+$Yadj, date("m.d.y") ); //date			
		}
		else{
			// no address 2
			$pdf->Text(19+$Xadj, 87+$Yadj, $_POST['agent-city']); //practice city state zip	
			$pdf->Text(19+$Xadj, 92+$Yadj, $_POST['agent-phone']); //practice phone	
			$pdf->Text(19+$Xadj, 97+$Yadj, date("m.d.y") ); //date				
		}
	
		//salutation
		$pdf->SetFillColor(255,255,255);
		$pdf->Rect(17+$Xadj, 119+$Yadj, 65 ,10 , 'F');	
		$pdf->Text(19+$Xadj, 125+$Yadj, 'Dear ' . $Fname . ' ' .  $Lname . ','); //attendee	

		//Sincerely
		//$pdf->Rect(17+$Xadj, 219+$Yadj, 65 ,15 , 'F');		
		$pdf->Text(19+$Xadj, 221+$Yadj, utf8_decode($_POST['agent-name'])); //agent name
		$pdf->Text(19+$Xadj, 226+$Yadj, $_POST['practice-name']); //practice name	

		//Page 1 footer
		$pdf->SetFont('Lato Bold','',18);
		$pdf->SetTextColor(130, 185, 65);	
		$pdf->Text(19+$Xadj, 244+$Yadj, $_POST['workshop-date']); //workshop Date (green)
		
		$pdf->SetFont('Lato','',16);
		$pdf->SetTextColor(0, 0, 0);		
		$pdf->Text(19+$Xadj, 251+$Yadj, $_POST['workshop-time']); //workshop time		
		$pdf->Text(19+$Xadj, 258+$Yadj, $_POST['workshop-venue']); //workshop venue
		$pdf->SetFont('Lato','',16);
		
		if($_POST['workshop-addr2'] != 'null' && !empty($_POST['workshop-addr2'])){
			
			$pdf->Text(19+$Xadj, 263+$Yadj, $_POST['workshop-add1'] . ' '. $_POST['workshop-add2'] . ', ' . $_POST['workshop-city'] . ' ' . $_POST['workshop-state'] . ' ' . $_POST['workshop-zip']); //workshop full address
		}else{
			
			$pdf->Text(19+$Xadj, 263+$Yadj, $_POST['workshop-add1'] . ', ' . $_POST['workshop-city'] . ' ' . $_POST['workshop-state'] . ' ' . $_POST['workshop-zip']); //workshop full address
		}
		
		if($_POST['workshop-room'] != 'null' && !empty($_POST['workshop-room'])){	
			
			$pdf->Text(19+$Xadj, 269+$Yadj, '(' . $_POST['workshop-room'] . ')'); //workshop room number
		}
		
		//page 2
		$pdf->addPage();
		$pdf->useTemplate($tmpl_pg2, $Xadj-8, $Yadj-1, 230);	

		$pdf->SetFont('Lato','',12);

		if( strlen($Fname) > 12  ){
			
			$pdf->SetFont('Lato','',11);
		}

		if( strlen($Fname) > 15  ){
			
			$pdf->SetFont('Lato','',10);
		}
		
		if( strlen($Fname) > 18  ){
			
			$pdf->SetFont('Lato','',9);
		}		
		
		$pdf->Text(164+$Xadj, 40+$Yadj, $Fname); //attendee first
		$pdf->Text(164+$Xadj, 45+$Yadj, $Lname); //attendee last
		
		$pdf->SetFont('Lato Bold', '', 14);
		
		if( strrpos($_POST['typ'], 'ira') === false ){
			
			$pdf->SetTextColor(130, 185, 65); //green
		}
		else{
			
			$pdf->SetTextColor(217, 146, 95); //brown
		}
		
		
		$pdf->Text(43+$Xadj, 66+$Yadj, $event_date); // workshop Date
		$pdf->SetFont('Lato Bold', '', 14);	
		$pdf->SetTextColor(0, 0, 0);	
		$pdf->Text(43+$Xadj, 71+$Yadj, $event_time); // workshop time		

		$pdf->SetFont('Lato Bold','',11);	
		$pdf->SetTextColor(0, 0, 0);
		
		if( strlen($_POST['workshop-venue']) > 19  ){
			
			$pdf->SetFont('Lato Bold','',10);
		}

		if( strlen($_POST['workshop-venue']) > 24  ){
			
			$pdf->SetFont('Lato Bold','',9);
		}
		
		$pdf->Text(104+$Xadj, 65.5+$Yadj, $_POST['workshop-venue']); //workshop venue
		$pdf->Text(104+$Xadj, 71+$Yadj, $_POST['workshop-add1']); //workshop add1
		if( $_POST['workshop-add2'] != 'null' && !empty($_POST['workshop-add2']) ){
			
			$pdf->Text(104+$Xadj, 76+$Yadj, $_POST['workshop-add2']); //workshop add2
			$pdf->Text(104+$Xadj, 81+$Yadj, $_POST['workshop-city'] . ' ' . $_POST['workshop-state'] . ' ' . $_POST['workshop-zip']); //workshop city state zip
			
			if($_POST['workshop-room'] != 'null' && !empty($_POST['workshop-room'])){
				
				$pdf->Text(104+$Xadj, 86+$Yadj, '(' . $_POST['workshop-room'] . ')'); //workshop room number		
			}		
		}
		else{
			
			$pdf->Text(104+$Xadj, 76+$Yadj, $_POST['workshop-city'] . ' ' . $_POST['workshop-state'] . ' ' . $_POST['workshop-zip']); //workshop city state zip

			if($_POST['workshop-room'] != 'null' && !empty($_POST['workshop-room'])){
				
				$pdf->Text(104+$Xadj, 81+$Yadj, '(' . $_POST['workshop-room'] . ')'); //workshop room number		
			}			
		}
			
		$map = 'mapimgs/' . strtolower($crow[$indx['Fname']]) . '-' . strtolower($crow[$indx['Lname']]) . '.png';
		
		if(@fopen($map, "r")){
			
			try{
		
				$pdf->Image($map, 19+$Xadj,143+$Yadj,175.2,139.5, 'PNG');	
			}
			catch(Exception $e) {
				
				$map = 'mapimgs/default.png';
				$pdf->Image($map, 19+$Xadj,143+$Yadj,175.2,139.5, 'PNG');					
			}
		}	
	}
}

$pdf->Output();

/*
 
*/