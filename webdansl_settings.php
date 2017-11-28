<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class MapGenAdminSettings{
	
	public function __construct(){
		add_action('admin_menu', array($this, 'mapgen_add_settings_page'));
		add_action('admin_enqueue_scripts', array($this, 'mapgen_enqueue_goods'));
	}

	public function mapgen_enqueue_goods(){
		wp_enqueue_script( 'gmap', 'http://maps.google.com/maps/api/js?key=AIzaSyDCLogJN6E_s1uNso1FDiB90qGFHVOjd9w&libraries=geometry&key=AIzaSyAj6epYmqWIaIGd_gJ4lwjXFePWBq6fVAg', array( 'jquery' ), false, true );
		wp_enqueue_script( 'snapshotmap', plugin_dir_url( __FILE__ ).'mapgen/src/snapshotcontrol.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'imagejs', plugin_dir_url( __FILE__ ).'mapgen/MapRoadImg7.js', array( 'jquery' ), false, true );
		wp_enqueue_style( 'mapgen_style', plugin_dir_url(__FILE__).'mapgen/style.css', array(), false, 'all' );
	}

	public function mapgen_add_settings_page() {
		add_menu_page(
			__( 'MapGen Settings', 'mapgen' ),
			'MapGen',
			'manage_options',
			'webdansl_mapgen_settings',
			array($this, 'mapgen_add_settings_page_callback'),
			'dashicons-location',
			115
		);
		add_submenu_page( 'webdansl_mapgen_settings', __( 'MapGen Settings', 'mapgen' ), 'Map Generator', 'manage_options', 'webdansl_mapgen_settings', array($this, 'mapgen_add_settings_page_callback'));
		add_submenu_page( 'webdansl_mapgen_settings', __( 'PDF creator', 'mapgen' ), 'PDF Generator', 'manage_options', 'webdansl_mapgen_pdf_gen', array($this, 'mapgen_add_pdfgen_page_callback'));
	}

	public function mapgen_add_settings_page_callback(){ ?>

		<h3>MapGen Page</h3>

		<div id="map_canvas"></div>
		<form action="<?php echo admin_url('admin.php?page=webdansl_mapgen_pdf_gen'); ?>" method="post">
		1)<br>
		Workshop Venue: <input id="workvenu" type="text" name="workvenu" value="M&O Marketing"/><br>			
		Workshop Street: <input id="workaddr" type="text" name="workaddr" value="27777 Franklin Rd"/><br>	
		Workshop City/State/Zip: <input id="workcity" type="text" name="workcity" value="Southfield, MI 48034"/><br><br>
		<input type="submit" value="Generator" style="margin-left:30px;">	
		</form>
		<br><br><br>			
		
		
		2) <input id="sortpicture" type="file" name="sortpic" /><br><br>		
		3) <button id="upload" data-script_path="<?php echo plugin_dir_url( __FILE__ ).'mapgen/upload.php' ?>">Upload</button><br><br>
		4) <button id="GetData" data-csv_path="<?php echo plugin_dir_url( __FILE__ ).'mapgen/csvFile.csv' ?>">GetData</button><br><br>
		5) <button id="SaveImg" data-script_path="<?php echo plugin_dir_url( __FILE__ ).'mapgen/imgUpload.php' ?>">SaveImg</button>
	<?php
	}

	public function mapgen_add_pdfgen_page_callback(){ ?>
		<form action="<?php echo plugin_dir_url( __FILE__ ).'mapgen/make.php' ?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" target="_blank">
			Template:
			<select name="typ">
			  <option value="ss-ticket">Social Security</option>
			  <option value="ss-ticket-runestad">Social Security - Runestad</option>
			  <option value="ss-ticket-pruemm">Social Security - Pruemm</option>
			  <option value="ss-ticket-crmyers">Social Security - CR Myers</option>
			  <option value="ss-ticket-nolan">Social Security - Marc Nolan</option>
			  <option value="ss-ticket-fort">Social Security - Justin Fort</option>
			  <option value="ss-ticket-bclark">Social Security - Brad Clark</option>
			  <option value="ss-ticket-mnolan">Social Security - Marc Nolan</option>
			  <option value="ss-ticket-hill">Social Security - Dan Hill</option>
			  <option value="ss-ticket-lee">Social Security - Oliver Lee</option>  
			   <option value="ss-ticket-rongue">Social Security - Ron Guevarra</option>
			  <option value="ss-ticket-nickmag">Social Security - Nick Maggard</option>
			<option value="ss-ticket-jklau">Social Security - Jeff Klauenberg</option>  
			  <option value="ira-ticket">IRA</option>
			  <option value="ira-ticket-speir">IRA - Jim Speir</option>
			  <option value="ira-ticket-oray">IRA - Greg Oray</option>
			  <option value="ira-ticket-runes">IRA - Ric Runestad</option>   
			  <option value="ira-ticket-fort">IRA - Justin Fort</option>
			  <option value="ira-ticket-nickmag">IRA - Nick Maggard</option>
			  <option value="ira-ticket-q-pearcy">IRA - Quince Pearcy</option>
			  <option value="ira-ticket-npetersn">IRA - Nick Peterson</option> 
			  <option value="ira-ticket-nolan">IRA - MarC Nolan</option>
			  <option value="ira-ticket-sha">IRA - Neel Sha</option>
			</select>
			<br><br>

			Agent Name: <input type="text" name="agent-name" value="" /><br><br>
			Practice Name: <input type="text" name="practice-name" value="" /><br>
			Agent Address 1: <input type="text" name="agent-address-1" value="" /><br>
			Agent Address 2: <input type="text" name="agent-address-2" value="" /><br>
			Agent City/State/ZIP: <input type="text" name="agent-city" value="" /><br>
			Agent Phone: <input type="text" name="agent-phone" value="" /><br><br>

			Workshop Venue: <input type="text" name="workshop-venue" value="<?php echo $_POST['workvenu']; ?>" /><br>
			Workshop Room: <input type="text" name="workshop-room" value="" /><br>
			Workshop Address 1: <input type="text" name="workshop-add1" value="<?php echo $_POST['workaddr']; ?>" /><br>
			Workshop Address 2: <input type="text" name="workshop-add2" value="" /><br>
			Workshop date: <input type="text" name="workshop-date" value="" /><br>
			Workshop time: <input type="text" name="workshop-time" value="" /><br>
			Workshop State: <input type="text" name="workshop-state" value="" /><br>
			Workshop zip: <input type="text" name="workshop-zip" value="" /><br>
			Workshop City/State/ZIP: <input type="text" name="workshop-city" value="<?php echo $_POST['workcity']; ?>" /><br>
			<input type="file" name="csv" value="" />
			<input type="submit" name="submit" value="Save" />
		</form>
	<?php
	}
}