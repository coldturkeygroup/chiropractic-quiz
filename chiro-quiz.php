<?php
/*
 * Plugin Name: Chiropractic Quiz
 * Version: 1.0.13
 * Plugin URI: https://platform.marketing/
 * Description: Simple chiropractic lead generation through a quiz that helps qualify prospective patients.
 * Author: Platform Marketing
 * Author URI: https://platform.marketing/
 * Requires at least: 4.0
 * Tested up to: 4.7.4
 *
 * @package Chiropractic Quiz
 * @author Aaron Huisinga
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'CHIRO_QUIZ_PLUGIN_PATH' ) )
	define( 'CHIRO_QUIZ_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

if ( ! defined( 'CHIRO_QUIZ_PLUGIN_VERSION' ) )
	define( 'CHIRO_QUIZ_PLUGIN_VERSION', '1.0.13' );

require_once( 'classes/class-chiro-quiz.php' );

global $chiro_quiz;
$chiro_quiz = new ColdTurkey\ChiroQuiz\ChiroQuiz( __FILE__ );

if ( is_admin() ) {
	require_once( 'classes/class-chiro-quiz-admin.php' );
	$chiro_quiz_admin = new ColdTurkey\ChiroQuiz\ChiroQuiz_Admin( __FILE__ );
}
