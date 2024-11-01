jQuery(document).ready(function(){
// PREPEND FONT AWESOME ICONS
jQuery('.vid_gallery_nav a:nth-child(1)').prepend('<i class="fa fa-cog"></i>')
jQuery('.vid_gallery_nav a:nth-child(2)').prepend('<i class="fa fa-play"></i>')
jQuery('.vid_gallery_nav a:nth-child(3)').prepend('<i class="fa fa-paint-brush" aria-hidden="true"></i>')
jQuery('.vid_gallery_nav a:nth-child(4)').prepend('<i class="fa fa-eye" aria-hidden="true"></i>')
jQuery('.vid_gallery_nav a:nth-child(5)').prepend('<i class="fa fa-key" aria-hidden="true"></i>')
jQuery('.vid_gallery_nav a:nth-child(6)').prepend('<i class="fa fa-user" aria-hidden="true"></i>')


// CHECK AND UNCHECK PLAYER AND GENERAL INPUT FIELDS
jQuery(document).on('click', '.select_pagination_field input[type="checkbox"]', function() {      
    jQuery('.select_pagination_field input[type="checkbox"]').not(this).prop('checked', false);      
});
jQuery(document).on('click', '.select_title_field input[type="checkbox"]', function() {      
    jQuery('.select_title_field input[type="checkbox"]').not(this).prop('checked', false);      
});
jQuery(document).on('click', '.select_desc_field input[type="checkbox"]', function() {      
    jQuery('.select_desc_field input[type="checkbox"]').not(this).prop('checked', false);      
});
jQuery(document).on('click', '.select_autoplay_field input[type="checkbox"]', function() {      
    jQuery('.select_autoplay_field input[type="checkbox"]').not(this).prop('checked', false);      
});
jQuery(document).on('click', '.select_autoplay_next_field input[type="checkbox"]', function() {      
    jQuery('.select_autoplay_next_field input[type="checkbox"]').not(this).prop('checked', false);      
});
jQuery(document).on('click', '.select_player_brand_field input[type="checkbox"]', function() {      
    jQuery('.select_player_brand_field input[type="checkbox"]').not(this).prop('checked', false);      
});
jQuery(document).on('click', '.select_show_info_field input[type="checkbox"]', function() {      
    jQuery('.select_show_info_field input[type="checkbox"]').not(this).prop('checked', false);      
});
// CHECK AND UNCHECK VIDEO EFFECTS
jQuery(document).on('click', '.main_video_effect_wrap input[type="checkbox"]', function() {      
    jQuery('.main_video_effect_wrap input[type="checkbox"]').not(this).prop('checked', false);      
});
// CHECK AND UNCHECK YOUTUBE API TRACKING
jQuery(document).on('click', '.select_tracking_field input[type="checkbox"]', function() {      
    jQuery('.select_tracking_field input[type="checkbox"]').not(this).prop('checked', false);      
});



// SELECT THEME STYLE
jQuery('.select_theme').on('click', 'label', function() {
      jQuery('label.default_theme_selected').removeClass('default_theme_selected');
      jQuery(this).addClass('default_theme_selected');
});
// SELECT PAGINATION STYLE
jQuery('.select_pagi').on('click', 'label', function() {
      jQuery('label.default_pagi_selected').removeClass('default_pagi_selected');
      jQuery(this).addClass('default_pagi_selected');
});
// SELECT VIDEO EFFECT
jQuery('.main_video_effect_wrap').on('click', 'label', function() {
      jQuery('label.selected_effect_wrap').removeClass('selected_effect_wrap');
      jQuery(this).addClass('selected_effect_wrap');
});

// COLOR PICKER
document.querySelectorAll('input[type=color]').forEach(function(picker) {

  var targetLabel = document.querySelector('label[for="' + picker.id + '"]'),
    codeArea = document.createElement('span');

  codeArea.innerHTML = picker.value;
  targetLabel.appendChild(codeArea);

  picker.addEventListener('change', function() {
    codeArea.innerHTML = picker.value;
    targetLabel.appendChild(codeArea);
  });
});


//ajax call for saving setting General setting
jQuery('#save_setting_1').click(function(){
  var settingOneSave = "1";
  var columns     = jQuery('#vid_colm_layouts_list').find(":selected").val();
  var perPage     = jQuery('#vid_per_page_sett').find(":selected").val();
  var videoTitle  = jQuery("input:radio[name=enable_title]:checked").val();
  var videoThumb  = jQuery("input:radio[name=enable_thumb]:checked").val();
  var videoDesc  = jQuery("input:radio[name=enable_desc]:checked").val();
  var videoTime  = jQuery("input:radio[name=enable_time]:checked").val();
  var videoViews  = jQuery("input:radio[name=enable_views]:checked").val();
  var videoLikes  = jQuery("input:radio[name=enable_likes]:checked").val();
  var videoComments  = jQuery("input:radio[name=enable_comments]:checked").val();
jQuery.ajax({
    type: "POST",
    url: ajaxurl,
    data: { action: 'wp_YT_video_gallery',settingOneSave: settingOneSave, columns: columns, perPage: perPage, videoTitle: videoTitle, videoThumb: videoThumb,videoDesc: videoDesc, videoTime: videoTime, videoViews: videoViews, videoLikes: videoLikes, videoComments: videoComments}
  }).done(function( msg ) {
   if(msg == "1"){
    alert("General setting saved successfully");
   }
}); 
});

//ajax call for saving setting Player
jQuery('#save_setting_2').click(function(){
  var settingTwoSave    = "1";
  var playerWidth       = jQuery('#vid_player_wid_sett').val();
  var playerHeight      = jQuery('#vid_ply_scrll_ofset_sett').val();
  var popupTitle        = jQuery("input:radio[name=enable_title_popup]:checked").val();
  var countOptions      = jQuery("input:radio[name=player_enable_option]:checked").val();
  var channelDetails    = jQuery("input:radio[name=enable_channel_details]:checked").val();
  var popupComments     = jQuery("input:radio[name=enable_comments]:checked").val();
  var autoPlay          = jQuery("input:radio[name=enable_autoplay]:checked").val();
jQuery.ajax({
    type: "POST",
    url: ajaxurl,
    data: { action: 'wp_YT_video_gallery',settingTwoSave: settingTwoSave, playerWidth: playerWidth, playerHeight: playerHeight,
     popupTitle: popupTitle, countOptions: countOptions,channelDetails: channelDetails, popupComments: popupComments,autoPlay: autoPlay }
  }).done(function( msg ) {
   if(msg == "1"){
    alert("Player setting saved successfully");
   }
}); 
});

//ajax call for saving API details
jQuery('#save_setting_3').click(function(){
  var settingThreeSave    = "1";
  var youtubeAPI          = jQuery('#youtube_api_key').val();
  var channelURL          = jQuery('#channel_api_key').val();
jQuery.ajax({
    type: "POST",
    url: ajaxurl,
    data: { action: 'wp_YT_video_gallery',settingThreeSave: settingThreeSave, youtubeAPI: youtubeAPI, channelURL: channelURL}
  }).done(function( msg ) {
   if(msg == "1"){
    alert("API details saved successfully");
   }
}); 
});
});