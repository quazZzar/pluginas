<?php 
if ( defined( 'ABSPATH' ) && class_exists('RWMB_Loader') ) {
	class MapGenMeta{
		public function __construct(){
			add_filter( 'rwmb_meta_boxes', array( $this, 'add_meta_boxes_to_agents' ));
			add_filter( 'rwmb_meta_boxes', array( $this, 'add_meta_boxes_to_venues' ));
			add_filter( 'rwmb_meta_boxes', array( $this, 'add_meta_boxes_to_templates' ));
		}

		public function add_meta_boxes_to_agents($meta_boxes){
			$prefix = 'agents_';
			$meta_boxes[] = array(
				'id'         => 'agents_meta',
				'title'      => 'Agent Options',
				'post_types' => 'agents',
				'context'    => 'normal',
				'priority'   => 'high',

				'fields' => array(
					array(
						'name'  => 'Practice Name',
						'id'    => $prefix . 'practice_name',
						'type'  => 'text'
					),
					array(
						'name'  => 'Address 1',
						'id'    => $prefix . 'address_one',
						'type'  => 'text'
					),
					array(
						'name'  => 'Address 2',
						'id'    => $prefix . 'address_two',
						'type'  => 'text'
					),
					array(
						'name'  => 'City/State/ZIP',
						'id'    => $prefix . 'city_state_zip',
						'type'  => 'text'
					),
					array(
						'name'  => 'Phone',
						'id'    => $prefix . 'phone',
						'type'  => 'text'
					)
				)
			);
			return $meta_boxes;
		}
		public function add_meta_boxes_to_venues($meta_boxes){
			$prefix = 'venues_';
			$meta_boxes[] = array(
				'id'         => 'venues_meta',
				'title'      => 'Venues Options',
				'post_types' => 'venues',
				'context'    => 'normal',
				'priority'   => 'high',

				'fields' => array(
					array(
						'name'  => 'Workshop Room',
						'id'    => $prefix . 'workshop_room',
						'type'  => 'text'
					),
					array(
						'name'  => 'Workshop Address 1',
						'id'    => $prefix . 'workshop_address_one',
						'type'  => 'text'
					),
					array(
						'name'  => 'Workshop Address 2',
						'id'    => $prefix . 'workshop_address_two',
						'type'  => 'text'
					),
					array(
						'name'  => 'Workshop City/State/ZIP',
						'id'    => $prefix . 'workshop_city_state_zip',
						'type'  => 'text'
					)
				)
			);
			return $meta_boxes;
		}
		public function add_meta_boxes_to_templates($meta_boxes){
			$prefix = 'templates_';
			$meta_boxes[] = array(
				'id'         => 'templates_meta',
				'title'      => 'Templates Options',
				'post_types' => 'templates',
				'context'    => 'normal',
				'priority'   => 'high',

				'fields' => array(
					array(
						'name'  => 'Tesxt Color',
						'id'    => $prefix . 'text_color',
						'type'  => 'color'
					),
				)
			);
			return $meta_boxes;
		}
	}
}
