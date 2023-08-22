<?php

abstract class WPBTRegistrationMeta implements WPBTMeta {
	const META_ID = WPBTEvents::PREFIX . 'event_registration_meta_box';
	const META_NAMES = [
		'url' => self::META_ID . '_url'
	];

	static function add() {
		add_meta_box(
			self::META_ID,
			__( 'Registracije' ),
			[ self::class, 'html' ],
			WPBTEvents::POST_TYPE
		);
	}

	static function html( $post ) {
		$name  = self::META_NAMES['url'];
		$value = get_post_meta( $post->ID, $name, true );
		echo "
 		<div class='row g-3'>
        	<div class='col-12 col-md-6 field-group'>
            	<label>Online registracija URL</label>
            	<input class='form-control' type='text' name='$name' value='$value' />
        	</div>
    	</div>
		";
	}

	static function rest() {
		register_rest_field( 'events', 'registration', array(
			'get_callback' => function ( $post_arr ) {
				return array(
					'url' => get_post_meta( $post_arr['id'], self::META_NAMES['url'], true )
				);
			},
		) );
	}

	private static function validate( $url ) {
		$googleFormsURLPattern = '/^https:\/\/docs\.google\.com\/forms\/d\/[a-zA-Z0-9_-]+\/viewform/';

		if ( ! preg_match( $googleFormsURLPattern, $url ) ) {
			throw new Exception( 'URL za online registracije mora biti Google forma!' );
		}
	}

	/**
	 * @throws Exception
	 */
	static function save( $postId ) {
		$name = self::META_NAMES['url'];

		if ( array_key_exists( $name, $_POST ) ) {
			$input = $_POST[$name];
			self::validate($input);

			update_post_meta( $postId, $name, $_POST[ $name ] );
		}
	}
}

add_action( 'add_meta_boxes', [ '', 'add' ] );
add_action( 'save_post', [ '', 'save' ] );
add_action( 'init', [ '', 'rest' ] );