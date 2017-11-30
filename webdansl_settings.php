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
		<div class="map_gen_wrap">
			<div class="the_form">
				<form action="<?php echo admin_url('admin.php?page=webdansl_mapgen_pdf_gen'); ?>" method="post">
					<div class="input-field">
						<label for="workvenu">Workshop Venue:</label>
						<input id="workvenu" type="text" name="workvenu" value="M&O Marketing"/>
					</div>
					
					<div class="input-field">
						<label for="workaddr">Workshop Street:</label>			
						<input id="workaddr" type="text" name="workaddr" value="27777 Franklin Rd"/>
					</div>

					<div class="input-field">
						<label for="workcity">Workshop City:</label>
						<input id="workcity" type="text" name="workcity" value="Southfield"/>
					</div>

					<div class="input-field">
						<label for="workstate">Workshop State:</label>
						<input id="workstate" type="text" name="workstate" value="MI"/>
					</div>

					<div class="input-field">
						<label for="workzip">Workshop ZIP:</label>
						<input id="workzip" type="text" name="workzip" value="48034"/>
					</div>

					<div class="input-field">	
						<button type="submit">Go to the Generator</button>
					</div>
				</form>
				
				<input id="sortpicture" type="file" name="sortpic" /><br>	
				<button id="upload" data-script_path="<?php echo plugin_dir_url( __FILE__ ).'mapgen/upload.php' ?>">Upload</button>
				<button id="GetData" data-csv_path="<?php echo plugin_dir_url( __FILE__ ).'mapgen/csvFile.csv' ?>">GetData</button>
				<button id="SaveImg" data-script_path="<?php echo plugin_dir_url( __FILE__ ).'mapgen/imgUpload.php' ?>">SaveImg</button>
			</div>
			<div class="map_wrapper">
				<div id="map_canvas"></div>
			</div>
		</div>
	<?php
	}

	public function mapgen_add_pdfgen_page_callback(){ ?>
		<h3>MapGen Page</h3>
		<div class="map_gen_wrap">
			<div class="the_form">
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
				
					<div class="input-field">
						<label for="agent-name">Agent Name:</label>
						<input id="agent-name" type="text" name="agent-name" value=""/>
					</div>
					<div class="input-field">
						<label for="practice-name">Practice Name:</label>
						<input id="practice-name" type="text" name="practice-name" value=""/>
					</div>
					<div class="input-field">
						<label for="agent-address-1">Agent Address 1:</label>
						<input id="agent-address-1" type="text" name="agent-address-1" value=""/>
					</div>
					<div class="input-field">
						<label for="agent-address-2">Agent Address 2:</label>
						<input id="agent-address-2" type="text" name="agent-address-2" value=""/>
					</div>
					<div class="input-field">
						<label for="agent-city">Agent City:</label>
						<input id="agent-city" type="text" name="agent-city" value=""/>
					</div>
					<div class="input-field">
						<label for="agent-state">Agent State:</label>
						<input id="agent-state" type="text" name="agent-state" value=""/>
					</div>
					<div class="input-field">
						<label for="agent-state">Agent ZIP:</label>
						<input id="agent-zip" type="text" name="agent-zip" value=""/>
					</div>
					<div class="input-field">
						<label for="agent-phone">Agent ZIP:</label>
						<input id="agent-phone" type="text" name="agent-phone" value=""/>
					</div>

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
			</div>
		</div>
	<?php
	}
}