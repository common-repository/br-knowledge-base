<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link              blueroosterthemes.com
 * @since             1.0.0
 *
 * @package           BR_KNOWLEDGE_BASE
 * @subpackage 		  BR_KNOWLEDGE_BASE/includes
 * @author     		  zulmkodr
 */
?>

<style>
/*_________________  Accordion
________________________________________*/
.accordion {
  position: relative;
  margin: 60px auto;
  width: 100%;
}

[id*="open-accordion"], [id*="close-accordion"] {
  background: #efefef;
  border-bottom: 1px solid #fff;
  line-height: 40px;
  height: 40px;
  display: block;
  margin: 0 auto;
  position: relative;
  width: 99%;
}

[id*="close-accordion"] {
  display: none;
}

.accordion a {
  color: #000 !important;
  font-size: 1.25em;
  font-weight: normal;
  padding-left: 2%;
  text-decoration: none;
  text-shadow: none;
}

[id*="open-accordion"]:after, [id*="close-accordion"]:after {
  content: "";
  border-left: 10px solid transparent;
  border-right: 10px solid transparent;
  border-top: 10px solid rgba(255, 255, 255, 0.6);
  position: absolute;
  right: 15px;
  top: 20px;
  z-index: 999;
  transform: rotate(-90deg);
  -webkit-transform: rotate(-90deg);
}

.target-fix {
  display: block;
  top: 0;
  left: 0;
  position: fixed;
}

.accordion-content {
  background: #fff;
  height: 0;
  margin: -1px auto 0;
  padding: 0 2.5%;
  position: relative;
  overflow: hidden;
  width: 100%;
  transition: all 0.1s ease;
  -webkit-transition: all 0.1s ease;
  -moz-transition: all 0.1s ease;
}

.accordion span:target ~ .accordion-content {
  display: block;
  height: auto;
  padding-bottom: 25px;
  padding-top: 10px;
  color:#000;
}

.accordion span:target ~ [id*="close-accordion"] {
  display: block;
}

.accordion span:target ~ [id*="open-accordion"] {
  display: none;
}

.accordion span:target ~ [id*="close-accordion"]:after {
  border-top: 10px solid #fff;
  transform: rotate(0deg);
  -webkit-transform: rotate(0deg);
}
</style>

<div class="accordion">
    <!-- span to target fix closing accordion -->
    <span class="target-fix" id="accordion"></span>
    <?php foreach($query as $key=>$faq) {  ?>
    <!-- First Accoridon Option -->
		<div style="margin-bottom:10px">
			<!-- span to target fix accordion -->
			<span class="target-fix" id="accordion<?php echo $key; ?>"></span>   
			<!-- Link to open accordion, hidden when open --> 
			<a href="#accordion<?php echo $key; ?>" id="open-accordion<?php echo $key; ?>" title="open" style="font-size: 18px; height: 50px; border-radius: 6px; padding-top: 5px;"><?php echo $faq->post_title ?></a>
			<!-- Link to close accordion, hidden when closed -->
			<a href="#accordion" id="close-accordion<?php echo $key; ?>" title="close" style="font-size: 18px; height: 50px; border-radius: 6px; padding-top: 5px;"><?php echo $faq->post_title; ?></a> 
					
			<!-- Accorion content goes in this div -->
			<div class="accordion-content">  	
				<p><?php echo $faq->post_content; ?></p>
			</div>
		</div>
	<?php } ?>
</div>