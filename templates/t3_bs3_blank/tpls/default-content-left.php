<?php
/** 
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org 
 *------------------------------------------------------------------------------
 */


defined('_JEXEC') or die;
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"
	  class='<jdoc:include type="pageclass" />'>

<head>
	<jdoc:include type="head" />
	<?php $this->loadBlock('head') ?>
  
</head>

<body>
<div id="goTop"></div>
<div class="t3-wrapper"> <!-- Need this wrapper for off-canvas menu. Remove if you don't use of-canvas -->
  
  <?php $this->loadBlock('header') ?>

  <?php $this->loadBlock('mainnav') ?>

  <?php $this->loadBlock('spotlight-1b') ?>

  <?php $this->loadBlock('spotlight-1') ?> 

 <!--  <?php $this->loadBlock('Breadcrumbs') ?> -->

  <?php $this->loadBlock('mainbody-content-left') ?>


  <?php $this->loadBlock('spotlight-2') ?>


  <?php $this->loadBlock('navhelper') ?>
  
  <?php $this->loadBlock('spotlight-3') ?>

  <?php $this->loadBlock('footer') ?>

</div>

</body>
<script>
  jQuery(document).ready(function($) { 
    $(function() {

      $(window).scroll(function() {

      if ($(this).scrollTop() > 100)

      $('#goTop').fadeIn();

      else

      $('#goTop').fadeOut();

      });

      $('#goTop').click(function() {

      $('body,html').animate({scrollTop: 0}, 'slow');

      });

      });
  $('div.custom p img').addClass('img-responsive'); 
  //scroll div
  $('a[href^="#"]').on('click',function (e) {
        e.preventDefault();
        var target = this.hash;
        var $target = $(target);

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top
        }, 900, 'swing', function () {
            window.location.hash = target;
        });
    }); 
  $('.navbar-nav>li>a').click(function(event) {
        var c='<?php echo JUri::root();?>';
        var value=$(this).attr("href");
        var url = c+value; 
        // alert(url) ;
        $(location).attr('href',url);
        
  }); 
  //selector đến menu cần làm việc
  var TopFixMenu = $("#t3-mainnav");
  // dùng sự kiện cuộn chuột để bắt thông tin đã cuộn được chiều dài là bao nhiêu.
    $(window).scroll(function(){
    // Nếu cuộn được hơn 150px rồi
        if($(this).scrollTop()>150){
      // Tiến hành show menu ra    
        TopFixMenu.css("position","fixed");
        TopFixMenu.css("top","0");
        TopFixMenu.css("z-index","1111");
        TopFixMenu.css("width","100%");
        }
        else{
       TopFixMenu.css("position","inherit");
        }}
    )
})
</script>

</html>