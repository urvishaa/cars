<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package athlete
 */

global $smof_data, $athlete_cfg;
include(get_template_directory() . '/inc/initvars.php');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php esc_attr(bloginfo('charset')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>">
    <?php if(!function_exists('wp_site_icon') || ! has_site_icon()){ ?>
    <?php if ($smof_data['favicon']) { ?>
        <link rel="shortcut icon" href="<?php echo esc_url($smof_data['favicon']); ?>" type="image/x-icon"/>
    <?php } else { ?>
        <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon.ico"
              type="image/x-icon"/>
    <?php }
	}
	if($smof_data['gf_body'])
		$gfont[urlencode($smof_data['gf_body'])] = '' . urlencode($smof_data['gf_body']);
	if($smof_data['gf_nav'] && $smof_data['gf_nav'] != '' && $smof_data['gf_nav'] != $smof_data['gf_body'])
		$gfont[urlencode($smof_data['gf_nav'])] = '' . urlencode($smof_data['gf_nav']);
	if($smof_data['f_headings'] && $smof_data['f_headings'] != '' && $smof_data['f_headings'] != $smof_data['gf_body'] && $smof_data['f_headings'] != $smof_data['gf_nav'])
		$gfont[urlencode($smof_data['f_headings'])] = '' . urlencode($smof_data['f_headings']);
	if(isset( $gfont ) && $gfont){
		foreach( $gfont as $g_font ) {
			echo "<link href='http" . ((is_ssl()) ? 's' : '') . "://fonts.googleapis.com/css?family={$g_font}:" . $smof_data['gf_settings'] . "' rel='stylesheet' type='text/css' />";
		}
	}
	if($athlete_cfg['pageheading_bg']){
		echo '<style>.page .page-heading{background-image:url(\''.esc_url($athlete_cfg['pageheading_bg']).'\')!important;}</style>';
	}
	?>
    <?php wp_head(); ?>
</head>
<script type="text/javascript">

// jQuery( document ).ready(function() {
//     alert("gvdsgs");
//     // jQuery( ".our-team2" ).click(function() {
//     //   alert( "alled" ); return false;
//     // });
// });

jQuery(document).on('click', "span.our-team2", function() {
    jQuery('.our-team-panes div.active').removeClass('active');
    jQuery('span.our-team1').removeClass('our-team-current');
    jQuery('span.our-team3').removeClass('our-team-current');
     jQuery('.twom').addClass('active');
     jQuery('span.our-team2').addClass('our-team-current');      
});

jQuery(document).on('click', "span.our-team1", function() {
    jQuery('.our-team-panes div.active').removeClass('active');
    jQuery('span.our-team2').removeClass('our-team-current');
    jQuery('span.our-team3').removeClass('our-team-current');
     jQuery('.onem').addClass('active');
     jQuery('span.our-team1').addClass('our-team-current');      
});

jQuery(document).on('click', "span.our-team3", function() {
    jQuery('.our-team-panes div.active').removeClass('active');
    jQuery('span.our-team1').removeClass('our-team-current');
    jQuery('span.our-team2').removeClass('our-team-current');
     jQuery('.thereem').addClass('active');
     jQuery('span.our-team3').addClass('our-team-current');      
});



jQuery( window ).load(function() {
  
    jQuery( "div.our-team-nav span:eq(0)" ).addClass( "our-team-current" );
     jQuery( "div.our-team-nav span:eq(0)" ).addClass( "our-team1" );
     jQuery( "div.our-team-nav span:eq(3)" ).addClass( "our-team2" );
     jQuery( "div.our-team-nav span:eq(6)" ).addClass( "our-team3" );
  
    var pageId = <?php echo isset($posts[0]) ? $posts[0]->ID : 'null'; ?>;
    if(pageId==1533)
    {
         setTimeout(function(){ 
           
                var url = jQuery(location).attr('href'),
                parts = url.split("#"),
             
                        last_part = parts[parts.length-1];
                       
                         var offset = jQuery('#'+last_part+'').offset();
                       
                        jQuery('html, body').animate({
                    scrollTop: jQuery('#'+last_part+'').offset().top - 100 
                }, 'fast');
           
               
           }, 1000);
    }
});

</script>
<?php
get_template_part('headers/header-' . $athlete_cfg['header-option']);
?>