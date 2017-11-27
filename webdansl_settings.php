<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class MapGenAdminSettings{
	
	public function __construct(){
		add_action('admin_menu', array($this, 'mapgen_add_settings_page'));
	}

	public function mapgen_enqueue_goods(){
		
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
	}

	public function mapgen_add_settings_page_callback(){ ?>

		<h3>MapGen Page</h3>

		<div id="map_canvas"></div>
		<form action="<?php echo plugin_dir_url(__FILE__).'mapgen/pdfer.php'; ?>" method="post">
		1)<br>
		Workshop Venue: <input id="workvenu" type="text" name="workvenu" value="M&O Marketing"/><br>			
		Workshop Street: <input id="workaddr" type="text" name="workaddr" value="27777 Franklin Rd"/><br>	
		Workshop City/State/Zip: <input id="workcity" type="text" name="workcity" value="Southfield, MI 48034"/><br><br>
		<input type="submit" value="Generator" style="margin-left:30px;">	
		</form>
		<br><br><br>			
		
		
		2) <input id="sortpicture" type="file" name="sortpic" /><br><br>		
		3) <button id="upload">Upload</button><br><br>
		4) <button id="GetData">GetData</button><br><br>
		5) <button id="SaveImg">SaveImg</button>
	<?php
	}
}