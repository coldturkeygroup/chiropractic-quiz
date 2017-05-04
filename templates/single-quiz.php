<?php
/**
 * Template file for displaying single Chiro Quiz
 *
 * @package    WordPress
 * @subpackage Chiro Quiz
 * @author     Platform Marketing
 * @since      1.0.0
 */

global $pf_chiro_quiz, $wp_query;

$id = get_the_ID();
$title = get_the_title();
$quiz_title = get_post_meta($id, 'quiz_title', true);
$frontdesk_campaign = get_post_meta($id, 'frontdesk_campaign', true);
$broker = get_post_meta($id, 'legal_broker', true);
$retargeting = get_post_meta($id, 'retargeting', true);
$conversion = get_post_meta($id, 'conversion', true);
$show_fields = get_post_meta($id, 'show_fields', true);
$token = 'pf_chiro_quiz';
$media = '<img src="' . get_post_meta($id, 'media_file', true) . '" class="img-responsive" style="margin-top:10px">';

if ($quiz_title == null || $quiz_title == '') {
    $quiz_title = 'Can chirotherapy treat your pain?';
}

// Get the page colors
$color_setting = get_post_meta($id, 'primary_color', true);
$hover_setting = get_post_meta($id, 'hover_color', true);
if (function_exists('of_get_option')) {
    $phone = of_get_option('phone_number');
    $color_theme = of_get_option('primary_color');
    $hover_theme = of_get_option('secondary_color');
}

if ($color_setting && strlen($color_setting) > 0 && $color_setting != '') {
    $primary_color = $color_setting;
} elseif (isset($color_theme) && strlen($color_theme) > 0 && $color_theme != '') {
    $primary_color = $color_theme;
}

if ($hover_setting && strlen($hover_setting) > 0 && $hover_setting != '') {
    $hover_color = $hover_setting;
} elseif (isset($hover_theme) && strlen($hover_theme) > 0 && $hover_theme != '') {
    $hover_color = $hover_theme;
}

?>
  <!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <title><?php wp_title('&middot;', true, 'right'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
      <?php wp_head(); ?>
    <style>
      <?php
      if( $primary_color != null ) {
          echo '
          .quiz-page .btn-primary {
              background-color: ' . $primary_color . ' !important;
              border-color: ' . $primary_color . ' !important; }
          .modal-body h2 {
              color: ' . $primary_color . ' !important; }
          .quiz-page .question-number {
              color: ' . $primary_color . ' !important; }
          .quiz-completed i {
              color: ' . $primary_color . ' !important; }
          .progress-bar {
            background-color: ' . $primary_color . ' !important; }
          ';
      }
      if( $hover_color != null ) {
          echo '
          .quiz-page .btn-primary:hover,
          .quiz-page .btn-primary:active {
              background-color: ' . $hover_color . ' !important;
              border-color: ' . $hover_color . ' !important; }
          ';
      }
      ?>
    </style>
    <link rel="alternate" type="application/rss+xml" title="<?= get_bloginfo('name'); ?> Feed" href="<?= esc_url(get_feed_link()); ?>">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

<body <?php body_class(); ?>>
<div class="quiz-page">
  <form id="chiro-quiz">
    <div class="container-fluid">
      <div class="row page animated fadeIn">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-1" data-model="questionOne">
          <p class="question-number">1.</p>
          <h4 class="question-title">What is your age?</h4>
          <input name="questions[1][question]" type="hidden" value="What is your age?">

          <div class="row">
            <div class="col-xs-12">
              <input name="questions[1][answer]" type="radio" value="I'm younger than 35" data-score="8">
              <label><i class="fa fa-fw"></i> I'm younger than 35</label>
            </div>
            <div class="col-xs-12">
              <input name="questions[1][answer]" type="radio" value="I'm 35 or older" data-score="8">
              <label><i class="fa fa-fw"></i> I'm 35 or older</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-2" data-model="questionTwo">
          <p class="question-number">2.</p>
          <h4 class="question-title">Do you work at a desk job that requires sitting for long periods of time?</h4>
          <input name="questions[2][question]" type="hidden" value="Do you work at a desk job that requires sitting for long periods of time?">

          <div class="row">
            <div class="col-xs-12">
              <input name="questions[2][answer]" type="radio" value="Yes, I am probably sitting for 6+ hours per day" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, I am probably sitting for 6+ hours per day</label>
            </div>
            <div class="col-xs-12">
              <input name="questions[2][answer]" type="radio" value="Yes, I sit for 2-6 hours per day" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, I sit for 2-6 hours per day</label>
            </div>
            <div class="col-xs-12">
              <input name="questions[2][answer]" type="radio" value="No, I sit for less than 2 hours per day" data-score="6">
              <label><i class="fa fa-fw"></i> No, I sit for less than 2 hours per day</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-3" data-model="questionThree">
          <p class="question-number">3.</p>
          <h4 class="question-title">Do you experience any of the following symptoms?</h4>
          <input name="questions[3][question]" type="hidden" value="Do you experience any of the following symptoms?">

          <div class="row">
            <div class="col-xs-12">
              <input name="questions[3][answer]" type="radio" value="Back pain" data-questions="back_pain" data-score="8">
              <label><i class="fa fa-fw"></i> Back pain</label>
            </div>
            <div class="col-xs-12">
              <input name="questions[3][answer]" type="radio" value="Neck pain" data-questions="neck_pain" data-score="8">
              <label><i class="fa fa-fw"></i> Neck pain</label>
            </div>
            <div class="col-xs-12">
              <input name="questions[3][answer]" type="radio" value="Migraine/headaches" data-questions="migraines" data-score="8">
              <label><i class="fa fa-fw"></i> Migraine/headaches</label>
            </div>
            <div class="col-xs-12">
              <input name="questions[3][answer]" type="radio" value="Knee/joint pain" data-questions="joint" data-score="8">
              <label><i class="fa fa-fw"></i> Knee/joint pain</label>
            </div>
            <div class="col-xs-12">
              <input name="questions[3][answer]" type="radio" value="Allergies/sinus/flu symptoms" data-questions="allergies" data-score="8">
              <label><i class="fa fa-fw"></i> Allergies/sinus/flu symptoms</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page back_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">4.</p>
          <h4 class="question-title">When does your back pain most commonly occur?</h4>
          <input class="back_pain-question" name="questions[back_pain][4][question]" type="hidden" value="Do you experience any of the following symptoms?">

          <div class="row">
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][4][answer]" type="radio" value="During the day" data-score="8">
              <label><i class="fa fa-fw"></i> During the day</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][4][answer]" type="radio" value="At night/in bed" data-score="8">
              <label><i class="fa fa-fw"></i> At night/in bed</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page back_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">5.</p>
          <h4 class="question-title">Is your back pain triggered by certain movement patterns like bending over, or does it occur spontaneously?</h4>
          <input class="back_pain-question" name="questions[back_pain][5][question]" type="hidden" value="Is your back pain triggered by certain movement patterns like bending over, or does it occur spontaneously?">

          <div class="row">
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][5][answer]" type="radio" value="There are certain movements that trigger it" data-score="8">
              <label><i class="fa fa-fw"></i> There are certain movements that trigger it</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][5][answer]" type="radio" value="My back pain seems to occur randomly" data-score="8">
              <label><i class="fa fa-fw"></i> My back pain seems to occur randomly</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page back_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">6.</p>
          <h4 class="question-title">Has your back pain ever spread to your legs/hips?</h4>
          <input class="back_pain-question" name="questions[back_pain][6][question]" type="hidden" value="Has your back pain ever spread to your legs/hips?">

          <div class="row">
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][6][answer]" type="radio" value="Yes, sometimes the pain shoots down to my legs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, sometimes the pain shoots down to my legs</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][6][answer]" type="radio" value="Yes, sometimes the pain spreads to my hips" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, sometimes the pain spreads to my hips</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][6][answer]" type="radio" value="Yes, the pain sometimes spreads to both my hips and legs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, the pain sometimes spreads to both my hips and legs</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][6][answer]" type="radio" value="No, I just experience back pain" data-score="4">
              <label><i class="fa fa-fw"></i> No, I just experience back pain</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page back_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">7.</p>
          <h4 class="question-title">Do you take acute medication (aspirin, ibuprofen, acetaminophen etc) to relieve your back pain?</h4>
          <input class="back_pain-question" name="questions[back_pain][7][question]" type="hidden" value="Do you take acute medication (aspirin, ibuprofen, acetaminophen etc) to relieve your back pain?">

          <div class="row">
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][7][answer]" type="radio" value="Yes, this seems to help" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, this seems to help</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][7][answer]" type="radio" value="Yes, but it doesn't always work" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, but it doesn't always work</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][7][answer]" type="radio" value="No, I've tried it and it didn't work" data-score="4">
              <label><i class="fa fa-fw"></i> No, I've tried it and it didn't work</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][7][answer]" type="radio" value="No, I have not tried it" data-score="4">
              <label><i class="fa fa-fw"></i> No, I have not tried it</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page back_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">8.</p>
          <h4 class="question-title">Have you ever undergone surgery to correct your back pain?</h4>
          <input class="back_pain-question" name="questions[back_pain][8][question]" type="hidden" value="Have you ever undergone surgery to correct your back pain?">

          <div class="row">
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][8][answer]" type="radio" value="Yes, and I'm now pain free." data-score="4">
              <label><i class="fa fa-fw"></i> Yes, and I'm now pain free.</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][8][answer]" type="radio" value="Yes, but I still experience some back pain." data-score="4">
              <label><i class="fa fa-fw"></i> Yes, but I still experience some back pain.</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][8][answer]" type="radio" value="No, but I plan to within the next 6 months." data-score="4">
              <label><i class="fa fa-fw"></i> No, but I plan to within the next 6 months.</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][8][answer]" type="radio" value="No, I have never had any corrective surgeries." data-score="4">
              <label><i class="fa fa-fw"></i> No, I have never had any corrective surgeries.</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page back_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">9.</p>
          <h4 class="question-title">Do you follow a vegan or vegetarian diet?</h4>
          <input class="back_pain-question" name="questions[back_pain][9][question]" type="hidden" value="Do you follow a vegan or vegetarian diet?">

          <div class="row">
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][9][answer]" type="radio" value="Yes" data-score="4">
              <label><i class="fa fa-fw"></i> Yes</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][9][answer]" type="radio" value="No" data-score="4">
              <label><i class="fa fa-fw"></i> No</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page back_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">10.</p>
          <h4 class="question-title">How long have you experienced back pain?</h4>
          <input class="back_pain-question" name="questions[back_pain][10][question]" type="hidden" value="How long have you experienced back pain?">

          <div class="row">
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][10][answer]" type="radio" value="Less than a month" data-score="4">
              <label><i class="fa fa-fw"></i> Less than a month</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][10][answer]" type="radio" value="Less than a year" data-score="4">
              <label><i class="fa fa-fw"></i> Less than a year</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][10][answer]" type="radio" value="1-5 years" data-score="4">
              <label><i class="fa fa-fw"></i> 1-5 years</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][10][answer]" type="radio" value="More than 5 years" data-score="4">
              <label><i class="fa fa-fw"></i> More than 5 years</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page back_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">11.</p>
          <h4 class="question-title">How frequently is your back pain severe enough to require acute medications like Advil, Aspirin, Ibuprofen, etc?</h4>
          <input class="back_pain-question" name="questions[back_pain][11][question]" type="hidden" value="How frequently is your back pain severe enough to require acute medications like Advil, Aspirin, Ibuprofen, etc?">

          <div class="row">
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][11][answer]" type="radio" value="1-2 times per month" data-score="4">
              <label><i class="fa fa-fw"></i> 1-2 times per month</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][11][answer]" type="radio" value="1-2 times per week" data-score="4">
              <label><i class="fa fa-fw"></i> 1-2 times per week</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][11][answer]" type="radio" value="Daily" data-score="4">
              <label><i class="fa fa-fw"></i> Daily</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][11][answer]" type="radio" value="Multiple times per day" data-score="4">
              <label><i class="fa fa-fw"></i> Multiple times per day</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page back_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">12.</p>
          <h4 class="question-title">Do you regularly consume carbohydrates?</h4>
          <input class="back_pain-question" name="questions[back_pain][12][question]" type="hidden" value="Do you regularly consume carbohydrates?">

          <div class="row">
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][12][answer]" type="radio" value="Yes, I eat a lot of carbs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I eat a lot of carbs</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][12][answer]" type="radio" value="Yes, I eat a moderate amount of carbs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I eat a moderate amount of carbs</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][12][answer]" type="radio" value="No, I try to limit my carbs as much as possible" data-score="4">
              <label><i class="fa fa-fw"></i> No, I try to limit my carbs as much as possible</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][12][answer]" type="radio" value="I'm not sure" data-score="4">
              <label><i class="fa fa-fw"></i> I'm not sure</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page back_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">13.</p>
          <h4 class="question-title">Has your back pain ever been so severe that it caused you to miss work or other events?</h4>
          <input class="back_pain-question" name="questions[back_pain][13][question]" type="hidden" value="Has your back pain ever been so severe that it caused you to miss work or other events?">

          <div class="row">
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][13][answer]" type="radio" value="Yes" data-score="4">
              <label><i class="fa fa-fw"></i> Yes</label>
            </div>
            <div class="col-xs-12">
              <input class="back_pain-question" name="questions[back_pain][13][answer]" type="radio" value="No" data-score="4">
              <label><i class="fa fa-fw"></i> No</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page neck_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">4.</p>
          <h4 class="question-title">When does your neck pain most commonly occur?</h4>
          <input class="neck_pain-question" name="questions[neck_pain][4][question]" type="hidden" value="When does your neck pain most commonly occur?">

          <div class="row">
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][4][answer]" type="radio" value="During the day" data-score="8">
              <label><i class="fa fa-fw"></i> During the day</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][4][answer]" type="radio" value="At night/in bed" data-score="8">
              <label><i class="fa fa-fw"></i> At night/in bed</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page neck_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">5.</p>
          <h4 class="question-title">Do you also experience headaches in addition to neck pain?</h4>
          <input class="neck_pain-question" name="questions[neck_pain][5][question]" type="hidden" value="Do you also experience headaches in addition to neck pain?">

          <div class="row">
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][5][answer]" type="radio" value="Yes, I experience headaches about once per month" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, I experience headaches about once per month</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][5][answer]" type="radio" value="Yes, I experience headaches every week" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, I experience headaches every week</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][5][answer]" type="radio" value="Yes, I experience headaches daily" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, I experience headaches daily</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][5][answer]" type="radio" value="No, I do not experience headaches (just neck pain)" data-score="8">
              <label><i class="fa fa-fw"></i> No, I do not experience headaches (just neck pain)</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page neck_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">6.</p>
          <h4 class="question-title">Was your neck pain caused by an auto accident?</h4>
          <input class="neck_pain-question" name="questions[neck_pain][6][question]" type="hidden" value="Was your neck pain caused by an auto accident?">

          <div class="row">
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][6][answer]" type="radio" value="Yes" data-score="4">
              <label><i class="fa fa-fw"></i> Yes</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][6][answer]" type="radio" value="No" data-score="4">
              <label><i class="fa fa-fw"></i> No</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page neck_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">7.</p>
          <h4 class="question-title">Do you take acute medication (aspirin, ibuprofen, acetaminophen etc) to relieve your neck pain?</h4>
          <input class="neck_pain-question" name="questions[neck_pain][7][question]" type="hidden" value="Do you take acute medication (aspirin, ibuprofen, acetaminophen etc) to relieve your neck pain?">

          <div class="row">
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][7][answer]" type="radio" value="Yes, this seems to help" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, this seems to help</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][7][answer]" type="radio" value="Yes, but it doesn't always work" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, but it doesn't always work</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][7][answer]" type="radio" value="No, I've tried it and it didn't work" data-score="4">
              <label><i class="fa fa-fw"></i> No, I've tried it and it didn't work</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][7][answer]" type="radio" value="No, I have not tried it" data-score="4">
              <label><i class="fa fa-fw"></i> No, I have not tried it</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page neck_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">8.</p>
          <h4 class="question-title">Have you ever undergone surgery to correct your neck pain?</h4>
          <input class="neck_pain-question" name="questions[neck_pain][8][question]" type="hidden" value="Have you ever undergone surgery to correct your neck pain?">

          <div class="row">
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][8][answer]" type="radio" value="Yes, and I'm now pain free." data-score="4">
              <label><i class="fa fa-fw"></i> Yes, and I'm now pain free.</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][8][answer]" type="radio" value="Yes, but I still experience some neck pain." data-score="4">
              <label><i class="fa fa-fw"></i> Yes, but I still experience some neck pain.</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][8][answer]" type="radio" value="No, but I plan to within the next 6 months." data-score="4">
              <label><i class="fa fa-fw"></i> No, but I plan to within the next 6 months.</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][8][answer]" type="radio" value="No, I have never had any corrective surgeries." data-score="4">
              <label><i class="fa fa-fw"></i> No, I have never had any corrective surgeries.</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page neck_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">9.</p>
          <h4 class="question-title">Do you follow a vegan or vegetarian diet?</h4>
          <input class="neck_pain-question" name="questions[neck_pain][9][question]" type="hidden" value="Do you follow a vegan or vegetarian diet?">

          <div class="row">
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][9][answer]" type="radio" value="Yes" data-score="4">
              <label><i class="fa fa-fw"></i> Yes</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][9][answer]" type="radio" value="No" data-score="4">
              <label><i class="fa fa-fw"></i> No</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page neck_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">10.</p>
          <h4 class="question-title">How long have you experienced neck pain?</h4>
          <input class="neck_pain-question" name="questions[neck_pain][10][question]" type="hidden" value="How long have you experienced neck pain?">

          <div class="row">
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][10][answer]" type="radio" value="Less than a month" data-score="4">
              <label><i class="fa fa-fw"></i> Less than a month</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][10][answer]" type="radio" value="Less than a year" data-score="4">
              <label><i class="fa fa-fw"></i> Less than a year</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][10][answer]" type="radio" value="1-5 years" data-score="4">
              <label><i class="fa fa-fw"></i> 1-5 years</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][10][answer]" type="radio" value="More than 5 years" data-score="4">
              <label><i class="fa fa-fw"></i> More than 5 years</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page neck_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">11.</p>
          <h4 class="question-title">How frequently is your neck pain severe enough to require acute medications like Advil, Aspirin, Ibuprofen, etc?</h4>
          <input class="neck_pain-question" name="questions[neck_pain][11][question]" type="hidden" value="How frequently is your neck pain severe enough to require acute medications like Advil, Aspirin, Ibuprofen, etc?">

          <div class="row">
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][11][answer]" type="radio" value="1-2 times per month" data-score="4">
              <label><i class="fa fa-fw"></i> 1-2 times per month</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][11][answer]" type="radio" value="1-2 times per week" data-score="4">
              <label><i class="fa fa-fw"></i> 1-2 times per week</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][11][answer]" type="radio" value="Daily" data-score="4">
              <label><i class="fa fa-fw"></i> Daily</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][11][answer]" type="radio" value="Multiple times per day" data-score="4">
              <label><i class="fa fa-fw"></i> Multiple times per day</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page neck_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">12.</p>
          <h4 class="question-title">Do you regularly consume carbohydrates?</h4>
          <input class="neck_pain-question" name="questions[neck_pain][12][question]" type="hidden" value="Do you regularly consume carbohydrates?">

          <div class="row">
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][12][answer]" type="radio" value="Yes, I eat a lot of carbs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I eat a lot of carbs</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][12][answer]" type="radio" value="Yes, I eat a moderate amount of carbs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I eat a moderate amount of carbs</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][12][answer]" type="radio" value="No, I try to limit my carbs as much as possible" data-score="4">
              <label><i class="fa fa-fw"></i> No, I try to limit my carbs as much as possible</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][12][answer]" type="radio" value="I'm not sure" data-score="4">
              <label><i class="fa fa-fw"></i> I'm not sure</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page neck_pain-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">13.</p>
          <h4 class="question-title">Has your neck pain ever been so severe that it caused you to miss work or other events?</h4>
          <input class="neck_pain-question" name="questions[neck_pain][13][question]" type="hidden" value="Has your neck pain ever been so severe that it caused you to miss work or other events?">

          <div class="row">
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][13][answer]" type="radio" value="Yes" data-score="4">
              <label><i class="fa fa-fw"></i> Yes</label>
            </div>
            <div class="col-xs-12">
              <input class="neck_pain-question" name="questions[neck_pain][13][answer]" type="radio" value="No" data-score="4">
              <label><i class="fa fa-fw"></i> No</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">4.</p>
          <h4 class="question-title">Do you consume alcohol?</h4>
          <input class="migraines-question" name="questions[migraines][4][question]" type="hidden" value="Do you consume alcohol?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][4][answer]" type="radio" value="Yes, probably once per week" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, probably once per week</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][4][answer]" type="radio" value="Yes, more than once per week" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, more than once per week</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][4][answer]" type="radio" value="Yes, I very rarely consume alcohol (less than 10 times per year)" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, I very rarely consume alcohol (less than 10 times per year)</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][4][answer]" type="radio" value="No, I never consume alcohol" data-score="8">
              <label><i class="fa fa-fw"></i> No, I never consume alcohol</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">5.</p>
          <h4 class="question-title">Does sleep deprivation seem to be a trigger?</h4>
          <input class="migraines-question" name="questions[migraines][5][question]" type="hidden" value="Does sleep deprivation seem to be a trigger?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][5][answer]" type="radio" value="Yes, I am much more likely to experience migraine headaches if I have less than 7 hours of sleep" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, I am much more likely to experience migraine headaches if I have less than 7 hours of sleep</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][5][answer]" type="radio" value="No, my migraine headaches are not triggered by lack of sleep" data-score="8">
              <label><i class="fa fa-fw"></i> No, my migraine headaches are not triggered by lack of sleep</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">6.</p>
          <h4 class="question-title">How long does your typical migraine headache last?</h4>
          <input class="migraines-question" name="questions[migraines][6][question]" type="hidden" value="How long does your typical migraine headache last?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][6][answer]" type="radio" value="5 minutes or less" data-score="4">
              <label><i class="fa fa-fw"></i> 5 minutes or less</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][6][answer]" type="radio" value="30 minutes or less" data-score="4">
              <label><i class="fa fa-fw"></i> 30 minutes or less</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][6][answer]" type="radio" value="90 minutes or less" data-score="4">
              <label><i class="fa fa-fw"></i> 90 minutes or less</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][6][answer]" type="radio" value="My migraines can be 90 minutes or longer" data-score="4">
              <label><i class="fa fa-fw"></i> My migraines can be 90 minutes or longer</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">7.</p>
          <h4 class="question-title">When do your migraine headaches most commonly occur?</h4>
          <input class="migraines-question" name="questions[migraines][7][question]" type="hidden" value="When do your migraine headaches most commonly occur?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][7][answer]" type="radio" value="During the day" data-score="4">
              <label><i class="fa fa-fw"></i> During the day</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][7][answer]" type="radio" value="At night/in bed" data-score="4">
              <label><i class="fa fa-fw"></i> At night/in bed</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">8.</p>
          <h4 class="question-title">How long have you experienced migraine headaches?</h4>
          <input class="migraines-question" name="questions[migraines][8][question]" type="hidden" value="How long have you experienced migraine headaches?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][8][answer]" type="radio" value="I've had migraines for 5+ years" data-score="4">
              <label><i class="fa fa-fw"></i> I've had migraines for 5+ years</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][8][answer]" type="radio" value="I've had migraines for 1-5 years" data-score="4">
              <label><i class="fa fa-fw"></i> I've had migraines for 1-5 years</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][8][answer]" type="radio" value="I've had migraines for less than a year" data-score="4">
              <label><i class="fa fa-fw"></i> I've had migraines for less than a year</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][8][answer]" type="radio" value="I've had migraines for less than a month" data-score="4">
              <label><i class="fa fa-fw"></i> I've had migraines for less than a month</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">9.</p>
          <h4 class="question-title">Do you take acute medication (aspirin, ibuprofen, acetaminophen etc) to relieve your migraines?</h4>
          <input class="migraines-question" name="questions[migraines][9][question]" type="hidden" value="Do you take acute medication (aspirin, ibuprofen, acetaminophen etc) to relieve your migraines?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][9][answer]" type="radio" value="Yes, this seems to help" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, this seems to help</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][9][answer]" type="radio" value="Yes, but it doesn't always work" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, but it doesn't always work</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][9][answer]" type="radio" value="No, I've tried it and it didn't work" data-score="4">
              <label><i class="fa fa-fw"></i> No, I've tried it and it didn't work</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][9][answer]" type="radio" value="No, I have not tried it" data-score="4">
              <label><i class="fa fa-fw"></i> No, I have not tried it</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">10.</p>
          <h4 class="question-title">Do you drink coffee?</h4>
          <input class="migraines-question" name="questions[migraines][10][question]" type="hidden" value="Do you drink coffee?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][10][answer]" type="radio" value="Yes, more than 4 cups a day" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, more than 4 cups a day</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][10][answer]" type="radio" value="Yes, 2-4 cups a day" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, 2-4 cups a day</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][10][answer]" type="radio" value="Yes, usually 1 cup a day" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, usually 1 cup a day</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][10][answer]" type="radio" value="No, I do not drink coffee" data-score="4">
              <label><i class="fa fa-fw"></i> No, I do not drink coffee</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">11.</p>
          <h4 class="question-title">How frequently do you experience migraine headaches?</h4>
          <input class="migraines-question" name="questions[migraines][11][question]" type="hidden" value="How frequently do you experience migraine headaches?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][11][answer]" type="radio" value="1-2 times per month" data-score="4">
              <label><i class="fa fa-fw"></i> 1-2 times per month</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][11][answer]" type="radio" value="1-2 times per week" data-score="4">
              <label><i class="fa fa-fw"></i> 1-2 times per week</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][11][answer]" type="radio" value="Daily" data-score="4">
              <label><i class="fa fa-fw"></i> Daily</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][11][answer]" type="radio" value="More than one per day" data-score="4">
              <label><i class="fa fa-fw"></i> More than one per day</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">12.</p>
          <h4 class="question-title">Do you experience back or neck pain in addition to migraine headaches?</h4>
          <input class="migraines-question" name="questions[migraines][12][question]" type="hidden" value="Do you experience back or neck pain in addition to migraine headaches?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][12][answer]" type="radio" value="Yes, I also have back pain" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I also have back pain</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][12][answer]" type="radio" value="Yes, I also have neck pain" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I also have neck pain</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][12][answer]" type="radio" value="Yes, I have both back and neck pain" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I have both back and neck pain</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][12][answer]" type="radio" value="No, I just experience headaches" data-score="4">
              <label><i class="fa fa-fw"></i> No, I just experience headaches</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">13.</p>
          <h4 class="question-title">Have your migraine headaches ever been so severe that it caused you to miss work or other events?</h4>
          <input class="migraines-question" name="questions[migraines][13][question]" type="hidden" value="Have your migraine headaches ever been so severe that it caused you to miss work or other events?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][13][answer]" type="radio" value="Yes" data-score="4">
              <label><i class="fa fa-fw"></i> Yes</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][13][answer]" type="radio" value="No" data-score="4">
              <label><i class="fa fa-fw"></i> No</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">14.</p>
          <h4 class="question-title">Do you regularly consume carbohydrates?</h4>
          <input class="migraines-question" name="questions[migraines][14][question]" type="hidden" value="Do you regularly consume carbohydrates?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][14][answer]" type="radio" value="Yes, I eat a lot of carbs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I eat a lot of carbs</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][14][answer]" type="radio" value="Yes, I eat a moderate amount of carbs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I eat a moderate amount of carbs</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][14][answer]" type="radio" value="No, I try to limit my carbs as much as possible" data-score="4">
              <label><i class="fa fa-fw"></i> No, I try to limit my carbs as much as possible</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][14][answer]" type="radio" value="I'm not sure" data-score="4">
              <label><i class="fa fa-fw"></i> I'm not sure</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">15.</p>
          <h4 class="question-title">During a migraine headache, do you prefer to relax in a dark, quiet room?</h4>
          <input class="migraines-question" name="questions[migraines][15][question]" type="hidden" value="During a migraine headache, do you prefer to relax in a dark, quiet room?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][15][answer]" type="radio" value="Yes, sensitivity to light and sound makes it worse" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, sensitivity to light and sound makes it worse</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][15][answer]" type="radio" value="No, light/sound doesn't seem to affect my headaches" data-score="4">
              <label><i class="fa fa-fw"></i> No, light/sound doesn't seem to affect my headaches</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">16.</p>
          <h4 class="question-title">Did your migraine headaches begin in adolescence?</h4>
          <input class="migraines-question" name="questions[migraines][16][question]" type="hidden" value="Did your migraine headaches begin in adolescence?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][16][answer]" type="radio" value="Yes, I began experiencing headaches as a teenager/early 20's" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I began experiencing headaches as a teenager/early 20's</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][16][answer]" type="radio" value="No, I began experiencing headaches at a later age" data-score="4">
              <label><i class="fa fa-fw"></i> No, I began experiencing headaches at a later age</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page migraines-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">17.</p>
          <h4 class="question-title">Do you regularly engage in intense physical activity like CrossFit, sports, or manual labor?</h4>
          <input class="migraines-question" name="questions[migraines][17][question]" type="hidden" value="Do you regularly engage in intense physical activity like CrossFit, sports, or manual labor?">

          <div class="row">
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][17][answer]" type="radio" value="Yes, every day" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, every day</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][17][answer]" type="radio" value="Yes, I exercise 3-5 times per week" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I exercise 3-5 times per week</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][17][answer]" type="radio" value="Yes, I exercise 1-2 times per week" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I exercise 1-2 times per week</label>
            </div>
            <div class="col-xs-12">
              <input class="migraines-question" name="questions[migraines][17][answer]" type="radio" value="No, I rarely exercise" data-score="4">
              <label><i class="fa fa-fw"></i> No, I rarely exercise</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page joint-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">4.</p>
          <h4 class="question-title">When does your joint pain most commonly occur?</h4>
          <input class="joint-question" name="questions[joint][4][question]" type="hidden" value="When does your joint pain most commonly occur?">

          <div class="row">
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][4][answer]" type="radio" value="During the day" data-score="8">
              <label><i class="fa fa-fw"></i> During the day</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][4][answer]" type="radio" value="At night/in bed" data-score="8">
              <label><i class="fa fa-fw"></i> At night/in bed</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page joint-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">5.</p>
          <h4 class="question-title">Did you play football in high school or college?</h4>
          <input class="joint-question" name="questions[joint][5][question]" type="hidden" value="Did you play football in high school or college?">

          <div class="row">
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][5][answer]" type="radio" value="Yes" data-score="8">
              <label><i class="fa fa-fw"></i> Yes</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][5][answer]" type="radio" value="No" data-score="8">
              <label><i class="fa fa-fw"></i> No</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page joint-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">6.</p>
          <h4 class="question-title">Was your knee/joint pain caused by a specific injury, or has it slowly developed over time?</h4>
          <input class="joint-question" name="questions[joint][6][question]" type="hidden" value="Was your knee/joint pain caused by a specific injury, or has it slowly developed over time?">

          <div class="row">
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][6][answer]" type="radio" value="Yes, it was caused by a specific injury" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, it was caused by a specific injury</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][6][answer]" type="radio" value="No, the pain has slowly gotten worse over time" data-score="4">
              <label><i class="fa fa-fw"></i> No, the pain has slowly gotten worse over time</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page joint-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">7.</p>
          <h4 class="question-title">Is your joint pain sharp and intense, or is it dull and ongoing?</h4>
          <input class="joint-question" name="questions[joint][7][question]" type="hidden" value="Is your joint pain sharp and intense, or is it dull and ongoing?">

          <div class="row">
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][7][answer]" type="radio" value="The pain is usually sharp and intense" data-score="4">
              <label><i class="fa fa-fw"></i> The pain is usually sharp and intense</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][7][answer]" type="radio" value="The pain is more of a dull, ongoing ache" data-score="4">
              <label><i class="fa fa-fw"></i> The pain is more of a dull, ongoing ache</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page joint-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">8.</p>
          <h4 class="question-title">Do you take acute medication (aspirin, ibuprofen, acetaminophen etc) to relieve your knee/joint pain?</h4>
          <input class="joint-question" name="questions[joint][8][question]" type="hidden" value="Do you take acute medication (aspirin, ibuprofen, acetaminophen etc) to relieve your knee/joint pain?">

          <div class="row">
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][8][answer]" type="radio" value="Yes, this seems to help" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, this seems to help</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][8][answer]" type="radio" value="Yes, but it doesn't always work" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, but it doesn't always work</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][8][answer]" type="radio" value="No, I've tried it and it didn't work" data-score="4">
              <label><i class="fa fa-fw"></i> No, I've tried it and it didn't work</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][8][answer]" type="radio" value="No, I have not tried it" data-score="4">
              <label><i class="fa fa-fw"></i> No, I have not tried it</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page joint-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">9.</p>
          <h4 class="question-title">Have you ever undergone surgery to correct your joint pain?</h4>
          <input class="joint-question" name="questions[joint][9][question]" type="hidden" value="Have you ever undergone surgery to correct your joint pain?">

          <div class="row">
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][9][answer]" type="radio" value="Yes, and I'm now pain free." data-score="4">
              <label><i class="fa fa-fw"></i> Yes, and I'm now pain free.</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][9][answer]" type="radio" value="Yes, but I still experience some joint pain." data-score="4">
              <label><i class="fa fa-fw"></i> Yes, but I still experience some joint pain.</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][9][answer]" type="radio" value="No, but I plan to within the next 6 months." data-score="4">
              <label><i class="fa fa-fw"></i> No, but I plan to within the next 6 months.</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][9][answer]" type="radio" value="No, I have never had any corrective surgeries." data-score="4">
              <label><i class="fa fa-fw"></i> No, I have never had any corrective surgeries.</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page joint-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">10.</p>
          <h4 class="question-title">Do you follow a vegan or vegetarian diet?</h4>
          <input class="joint-question" name="questions[joint][10][question]" type="hidden" value="Do you follow a vegan or vegetarian diet?">

          <div class="row">
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][10][answer]" type="radio" value="Yes" data-score="4">
              <label><i class="fa fa-fw"></i> Yes</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][10][answer]" type="radio" value="No" data-score="4">
              <label><i class="fa fa-fw"></i> No</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page joint-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">11.</p>
          <h4 class="question-title">How long have you experienced joint pain?</h4>
          <input class="joint-question" name="questions[joint][11][question]" type="hidden" value="How long have you experienced joint pain?">

          <div class="row">
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][11][answer]" type="radio" value="Less than a month" data-score="4">
              <label><i class="fa fa-fw"></i> Less than a month</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][11][answer]" type="radio" value="Less than a year" data-score="4">
              <label><i class="fa fa-fw"></i> Less than a year</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][11][answer]" type="radio" value="1-5 years" data-score="4">
              <label><i class="fa fa-fw"></i> 1-5 years</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][11][answer]" type="radio" value="More than 5 years" data-score="4">
              <label><i class="fa fa-fw"></i> More than 5 years</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page joint-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">12.</p>
          <h4 class="question-title">How frequently is your joint pain severe enough to require acute medications like Advil, Aspirin, Ibuprofen, etc?</h4>
          <input class="joint-question" name="questions[joint][12][question]" type="hidden" value="How frequently is your joint pain severe enough to require acute medications like Advil, Aspirin, Ibuprofen, etc?">

          <div class="row">
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][12][answer]" type="radio" value="1-2 times per month" data-score="4">
              <label><i class="fa fa-fw"></i> 1-2 times per month</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][12][answer]" type="radio" value="1-2 times per week" data-score="4">
              <label><i class="fa fa-fw"></i> 1-2 times per week</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][12][answer]" type="radio" value="Daily" data-score="4">
              <label><i class="fa fa-fw"></i> Daily</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][12][answer]" type="radio" value="Multiple times per day" data-score="4">
              <label><i class="fa fa-fw"></i> Multiple times per day</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page joint-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">13.</p>
          <h4 class="question-title">Do you regularly consume carbohydrates?</h4>
          <input class="joint-question" name="questions[joint][13][question]" type="hidden" value="Do you regularly consume carbohydrates?">

          <div class="row">
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][13][answer]" type="radio" value="Yes, I eat a lot of carbs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I eat a lot of carbs</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][13][answer]" type="radio" value="Yes, I eat a moderate amount of carbs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I eat a moderate amount of carbs</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][13][answer]" type="radio" value="No, I try to limit my carbs as much as possible" data-score="4">
              <label><i class="fa fa-fw"></i> No, I try to limit my carbs as much as possible</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][13][answer]" type="radio" value="I'm not sure" data-score="4">
              <label><i class="fa fa-fw"></i> I'm not sure</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page joint-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">14.</p>
          <h4 class="question-title">Has your knee/joint pain ever been so severe that it caused you to miss work or other events?</h4>
          <input class="joint-question" name="questions[joint][14][question]" type="hidden" value="Has your knee/joint pain ever been so severe that it caused you to miss work or other events?">

          <div class="row">
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][14][answer]" type="radio" value="Yes" data-score="4">
              <label><i class="fa fa-fw"></i> Yes</label>
            </div>
            <div class="col-xs-12">
              <input class="joint-question" name="questions[joint][14][answer]" type="radio" value="No" data-score="4">
              <label><i class="fa fa-fw"></i> No</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">4.</p>
          <h4 class="question-title">Do you consume alcohol?</h4>
          <input class="allergies-question" name="questions[allergies][4][question]" type="hidden" value="Do you consume alcohol?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][4][answer]" type="radio" value="Yes, probably once per week" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, probably once per week</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][4][answer]" type="radio" value="Yes, more than once per week" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, more than once per week</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][4][answer]" type="radio" value="Yes, I very rarely consume alcohol (less than 10 times per year)" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, I very rarely consume alcohol (less than 10 times per year)</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][4][answer]" type="radio" value="No, I never consume alcohol" data-score="8">
              <label><i class="fa fa-fw"></i> No, I never consume alcohol</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">5.</p>
          <h4 class="question-title">Does sleep deprivation seem to be a trigger for your allergies/flu symptoms?</h4>
          <input class="allergies-question" name="questions[allergies][5][question]" type="hidden" value="Does sleep deprivation seem to be a trigger for your allergies/flu symptoms?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][5][answer]" type="radio" value="Yes, I am much more likely to experience symptoms if I have less than 7 hours of sleep" data-score="8">
              <label><i class="fa fa-fw"></i> Yes, I am much more likely to experience symptoms if I have less than 7 hours of sleep</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][5][answer]" type="radio" value="No, it's not triggered by lack of sleep" data-score="8">
              <label><i class="fa fa-fw"></i> No, it's not triggered by lack of sleep</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">6.</p>
          <h4 class="question-title">Do you find it difficult to breathe while falling asleep?</h4>
          <input class="allergies-question" name="questions[allergies][6][question]" type="hidden" value="Do you find it difficult to breathe while falling asleep?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][6][answer]" type="radio" value="Yes" data-score="4">
              <label><i class="fa fa-fw"></i> Yes</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][6][answer]" type="radio" value="No" data-score="4">
              <label><i class="fa fa-fw"></i> No</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">7.</p>
          <h4 class="question-title">Do you experience back or neck pain in addition to allergies/sinus/flu symptoms?</h4>
          <input class="allergies-question" name="questions[allergies][7][question]" type="hidden" value="Do you experience back or neck pain in addition to allergies/sinus/flu symptoms?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][7][answer]" type="radio" value="Yes, I also have back pain" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I also have back pain</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][7][answer]" type="radio" value="Yes, I also have neck pain" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I also have neck pain</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][7][answer]" type="radio" value="Yes, I have both back and neck pain" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I have both back and neck pain</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][7][answer]" type="radio" value="No, I just experience allergies/sinus/flu symptoms" data-score="4">
              <label><i class="fa fa-fw"></i> No, I just experience allergies/sinus/flu symptoms</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">8.</p>
          <h4 class="question-title">How long do your typical allergy/flu/sinus symptoms last?</h4>
          <input class="allergies-question" name="questions[allergies][8][question]" type="hidden" value="How long do your typical allergy/flu/sinus symptoms last?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][8][answer]" type="radio" value="30 minutes or less" data-score="4">
              <label><i class="fa fa-fw"></i> 30 minutes or less</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][8][answer]" type="radio" value="90 minutes or less" data-score="4">
              <label><i class="fa fa-fw"></i> 90 minutes or less</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][8][answer]" type="radio" value="Less than a week" data-score="4">
              <label><i class="fa fa-fw"></i> Less than a week</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][8][answer]" type="radio" value="Symptoms can last more than a week" data-score="4">
              <label><i class="fa fa-fw"></i> Symptoms can last more than a week</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">9.</p>
          <h4 class="question-title">How long have you experienced symptoms?</h4>
          <input class="allergies-question" name="questions[allergies][9][question]" type="hidden" value="How long have you experienced symptoms?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][9][answer]" type="radio" value="5+ years" data-score="4">
              <label><i class="fa fa-fw"></i> 5+ years</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][9][answer]" type="radio" value="1-5 years" data-score="4">
              <label><i class="fa fa-fw"></i> 1-5 years</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][9][answer]" type="radio" value="Less than a year" data-score="4">
              <label><i class="fa fa-fw"></i> Less than a year</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][9][answer]" type="radio" value="Less than a month" data-score="4">
              <label><i class="fa fa-fw"></i> Less than a month</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">10.</p>
          <h4 class="question-title">Do you take acute medication (aspirin, ibuprofen, acetaminophen etc) to relieve your symptoms?</h4>
          <input class="allergies-question" name="questions[allergies][10][question]" type="hidden" value="Do you take acute medication (aspirin, ibuprofen, acetaminophen etc) to relieve your symptoms?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][10][answer]" type="radio" value="Yes, this seems to help" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, this seems to help</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][10][answer]" type="radio" value="Yes, but it doesn't always work" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, but it doesn't always work</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][10][answer]" type="radio" value="No, I've tried it and it didn't work" data-score="4">
              <label><i class="fa fa-fw"></i> No, I've tried it and it didn't work</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][10][answer]" type="radio" value="No, I have not tried it" data-score="4">
              <label><i class="fa fa-fw"></i> No, I have not tried it</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">11.</p>
          <h4 class="question-title">Do you drink coffee?</h4>
          <input class="allergies-question" name="questions[allergies][11][question]" type="hidden" value="Do you drink coffee?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][11][answer]" type="radio" value="Yes, more than 4 cups a day" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, more than 4 cups a day</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][11][answer]" type="radio" value="Yes, 2-4 cups a day" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, 2-4 cups a day</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][11][answer]" type="radio" value="Yes, usually 1 cup a day" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, usually 1 cup a day</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][11][answer]" type="radio" value="No, I do not drink coffee" data-score="4">
              <label><i class="fa fa-fw"></i> No, I do not drink coffee</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">12.</p>
          <h4 class="question-title">Have your allergies/sinus/flu symptoms ever been so severe that it caused you to miss work or other events?</h4>
          <input class="allergies-question" name="questions[allergies][12][question]" type="hidden" value="Have your allergies/sinus/flu symptoms ever been so severe that it caused you to miss work or other events?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][12][answer]" type="radio" value="Yes" data-score="4">
              <label><i class="fa fa-fw"></i> Yes</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][12][answer]" type="radio" value="No" data-score="4">
              <label><i class="fa fa-fw"></i> No</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">13.</p>
          <h4 class="question-title">Do you regularly consume carbohydrates?</h4>
          <input class="allergies-question" name="questions[allergies][13][question]" type="hidden" value="Do you regularly consume carbohydrates?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][13][answer]" type="radio" value="Yes, I eat a lot of carbs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I eat a lot of carbs</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][13][answer]" type="radio" value="Yes, I eat a moderate amount of carbs" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I eat a moderate amount of carbs</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][13][answer]" type="radio" value="No, I try to limit my carbs as much as possible" data-score="4">
              <label><i class="fa fa-fw"></i> No, I try to limit my carbs as much as possible</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][13][answer]" type="radio" value="I'm not sure" data-score="4">
              <label><i class="fa fa-fw"></i> I'm not sure</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">14.</p>
          <h4 class="question-title">Did your symptoms begin in adolescence?</h4>
          <input class="allergies-question" name="questions[allergies][14][question]" type="hidden" value="Did your symptoms begin in adolescence?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][14][answer]" type="radio" value="Yes, I began regularly experiencing allergies/sinus/flu symptoms as a teenager" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I began regularly experiencing allergies/sinus/flu symptoms as a teenager</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][14][answer]" type="radio" value="No, my symptoms began at a later age" data-score="4">
              <label><i class="fa fa-fw"></i> No, my symptoms began at a later age</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page allergies-page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
          <p class="question-number">15.</p>
          <h4 class="question-title">Do you regularly engage in intense physical activity like CrossFit, sports, or manual labor?</h4>
          <input class="allergies-question" name="questions[allergies][15][question]" type="hidden" value="Do you regularly engage in intense physical activity like CrossFit, sports, or manual labor?">

          <div class="row">
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][15][answer]" type="radio" value="Yes, every day" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, every day</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][15][answer]" type="radio" value="Yes, I exercise 3-5 times per week" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I exercise 3-5 times per week</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][15][answer]" type="radio" value="Yes, I exercise 1-2 times per week" data-score="4">
              <label><i class="fa fa-fw"></i> Yes, I exercise 1-2 times per week</label>
            </div>
            <div class="col-xs-12">
              <input class="allergies-question" name="questions[allergies][15][answer]" type="radio" value="No, I rarely exercise" data-score="4">
              <label><i class="fa fa-fw"></i> No, I rarely exercise</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row page" style="display:none;">
        <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="offer" data-model="offer">
          <h4 style="text-align: center;" class="landing-title">Awesome. Click below to see your quiz results!</h4>

          <button class="btn btn-primary btn-lg" id="get-results">Get My Results!</button>
        </div>
      </div>

      <input type="hidden" id="broker" value="<?= $broker ?>">
      <div class="footer"><?php echo $broker;
          if (isset($phone) && $phone != null) {
              echo ' &middot; ' . $phone;
          } ?></div>
      <div class="footer-quiz" style="display:none;">
        <div class="broker"><?php echo $broker;
            if (isset($phone) && $phone != null) {
                echo ' &middot; ' . $phone;
            } ?>
        </div>

        <div class="quiz-progress">
          <span class="progress-percent">8</span>% complete
          <div class="progress">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100" style="width: 8%;">
              <span class="sr-only"><span class="progress-percent">8</span>% Complete</span>
            </div>
          </div>
        </div>

        <div class="quiz-back btn btn-primary" id="quiz-back" style="display:none;"><i class="fa fa-chevron-up"></i>
        </div>
      </div>

      <div class="modal fade" id="quiz-results" tabindex="-1" role="dialog" aria-labelledby="quiz-results-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <?php if (isset($show_fields) && $show_fields == 'no') { ?>
                <h3 style="font-size:20px;line-height:24px">You are eligible for free chirotherapy at <?= $broker ?>.</h3>
              <?php } else { ?>
                <h3 style="font-size:20px;line-height:24px">Awesome! Your quiz results have been calculated. <br> Where should we email your results?</h3>
              <?php } ?>

              <div class="form-group">
                <label for="first_name" class="control-label sr-only">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" required="required" placeholder="First Name">
              </div>
              <div class="form-group">
                <label for="email" class="control-label sr-only">Email Address</label>
                <input type="text" name="email" id="email" class="form-control" required="required" placeholder="Email Address">
              </div>

              <input name="frontdesk_campaign" type="hidden" value="<?= $frontdesk_campaign ?>">
              <input name="action" type="hidden" id="<?= $token ?>_submit_quiz" value="<?= $token ?>_submit_quiz">
                <?php wp_nonce_field($token . '_submit_quiz', $token . '_nonce'); ?>
              <input name="quiz_id" type="hidden" value="<?= $id ?>">

                <?php if (isset($show_fields) && $show_fields == 'no') { ?>
                  <input type="submit" class="btn btn-primary btn-lg" id="submit-results" value="Send Me The Details!">
                <?php } else { ?>
                  <input type="submit" class="btn btn-primary btn-lg" id="submit-results" value="Get My Results!">
                <?php } ?>
            </div>
          </div>
        </div>
      </div>
  </form>

    <?php
    if ($retargeting != '') {
        ?>
      <!-- Facebook Pixel Code -->
      <script>
          !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
          n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
          document,'script','//connect.facebook.net/en_US/fbevents.js');

          fbq('init', '<?= $retargeting ?>');
          fbq('track', 'PageView');
      </script>
      <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?= $retargeting ?>&ev=PageView&noscript=1"/></noscript>
      <?php
    }

    if ($conversion != '') {
        echo '<input type="hidden" id="conversion" value="' . $conversion . '">';
    }

    if (isset($show_fields) && $show_fields == 'no') {
        echo '<input type="hidden" id="showFields" value="no">';
    }
    ?>
</div>

<?php wp_footer(); ?>