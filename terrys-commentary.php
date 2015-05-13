<?php
/*
Plugin Name: Terry's commentary
Plugin URI: http://terrychay.com/wordpress-plugins/terrys-commentary
Description: Make commentary a tooltip, support tooltips
Version: 1.0
Author: terry chay
Author URI: http://terrychay.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
/**
 * 
 * 
 * @see  http://osvaldas.info/elegant-css-and-jquery-tooltip-responsive-mobile-friendly  The JS and CSS files
 */
class tccomment {
	const VERSION = '1.0';
	//private $_this_dir;
	//
	// INITIALIZATIONS
	//
	/**
	 * This bootstraps the plugin and should be called on plugins_loaded
	 * 
	 * @return void
	 */
	static public function bootstrap() {
		$tcc = new tccomment();
		// could save to property to make it an instance method
		// bury hooks into run() and run_admin(), we can trigger hooks in
		// those or not
		$tcc->run();
	}
	/**
	 * does initialization of any variables
	 */
	public function __construct() {
		//$this->_this_dir = dirname( plugins_url( __FILE__ ) );
	}
	/**
	 * Queue hooks.
	 *
	 * This is called right after initialziation, but is separate because it
	 * should not occur until plugins loaded.
	 * @return [type] [description]
	 */
	public function run() {
		add_action( 'init', array($this,'add_tooltip_shortcode') );
		add_shortcode( 'commentary', array('tccomment','shortcode') );
		add_action( 'wp_enqueue_scripts', array('tccomment','enqueue_scripts') );
	}
	//
	// SCRIPTS AND STYLES
	//
	public static function enqueue_scripts() {
		if ( apply_filters( 'tccomment_add_default_css', true) ) {
			wp_enqueue_style(
				'tccomment_style',
				plugins_url( apply_filters( 'tccomment_default_css', 'default.css' ), __FILE__ ),
				array(),
				self::VERSION,
				'all'
			);
		}
		wp_enqueue_script(
			'tooltip',
			plugins_url( 'tooltip.js', __FILE__ ),
			array( 'jquery' ),
			self::VERSION,
			true // in footer
		);
	}
	//
	// TOOLTIPS 
	//
	public function add_tooltip_shortcode() {
		if ( apply_filters( 'tccomment_add_tooltip_shortcode', false ) ) {
			add_shortcode( 'tooltip', array('tccomment','shortcode') );
		}
	}
	/**
	 * Injects commentary (tooltip) in a correct HTML5 format so it has title
	 * fallback.
	 *
	 * This shortcode code does not support html tooltips in the attribute.
	 * This is based on ace tooltip, but that theme generates non-semantic
	 * HTML (probably based on code that did?)
	 *
	 * Here is the code that ace generates:
	 * > <span class="tooltip">CONTENT<span class="tip">TIP</span></span>
	 *
	 * Here is the code I used to write in my blog
	 * > <span class="commentary" title="TIP">CONTENT</span>
	 *
	 * Here is the code used by elgant css/jquery tooltip (and the inteded output)
	 * > <span rel="tooltip" title="TIP">CONTENT</span>
	 * 
	 * @param  array  $atts    just have tip is text
	 * @param  string $content just have
	 * @return [type]          [description]
	 */
	static public function shortcode( $atts, $content = null, $tag='' ) {
		// extract() is very bad form for hack/hhvm
		$atts = shortcode_atts( array(
			"text" => null
		), $atts);
		$text = $atts['text'];
		return sprintf(
			'<span title="%s" rel="tooltip%s">%s</span>',
			esc_attr( $text ),
			( $tag == 'commentary' ) ? ' commentary' : '',
			do_shortcode( $content )
		);
	}
}

add_action('plugins_loaded', array( 'tccomment', 'bootstrap' ) );