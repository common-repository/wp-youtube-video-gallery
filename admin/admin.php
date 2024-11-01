<?php
/*
** adding necessarey files
*/

function wpYouTubeGalleryAdminFiles() {

    wp_enqueue_style('wpYouTubeGalleryAdminFilesMainStyle', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_style('wpYouTubeGalleryAdminFilesFontAwesome', plugins_url('/font-awesome/css/font-awesome.min.css', __FILE__));
    wp_enqueue_script('wpYouTubeGalleryAdminFilesCutomLogic', plugins_url('/js/logic.js',__FILE__ ));
}
add_action('admin_enqueue_scripts', 'wpYouTubeGalleryAdminFiles');

//color picker
add_action( 'admin_enqueue_scripts', 'wpYouTubeGalleryAdminColorPicker' );
function wpYouTubeGalleryAdminColorPicker( $hook ) {

    if( is_admin() ) { 

        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 

        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'wooLiveSalecustom-script-handle', plugins_url( 'js/custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}

//Theme customize
add_action( 'admin_menu', 'wpYouTubeGalleryAdminPage' );

//Adds a new settings page under Setting menu
function wpYouTubeGalleryAdminPage() {
    add_options_page( __( 'YT Video Gallery' ), __( 'YT Video Gallery' ), 'manage_options', 'wpYouTubeGalleryMainPage', 'wpYouTubeGalleryPageDisplay' );
}

//Showing setting tabs on the admin setting page 
function wpYouTubeGalleryAdminTabs( $current = 'first' ) {
    $tabs = array(
        'first'   => __( 'General', 'plugin-textdomain' ), 
        'second'  => __( 'Player', 'plugin-textdomain' ),
        'fifth'  => __( 'Api', 'plugin-textdomain' ),
       
    );
    $html = '<h2 class="wooLiveSalenav-tabnav-tab-wrapper vid_gallery_nav">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? 'nav-tab-active' : '';
        $html .= '<a class="nav-tab ' . esc_html($class) . '" href="?page=wpYouTubeGalleryMainPage&tab=' . esc_html($tab) . '">' . esc_html($name) . '</a>';
    }
    $html .= '</h2>';
    echo $html ;
}

function wpYouTubeGalleryPageDisplay(){
    ?>
    <div class="cont-p-dashboard">
     <!-- ================= PLUGIN LOGO ====================== -->
     <header class="dashboard_header">
         <div class="dash_logo">
          <h3 class="plugin_logo">YouTube Video Gallery</h3>
      </div>
      <div class="dash_nav">
        <label>After setting, paste your channel URL and API in the API tab then copy and paste the short code on page or post where you want to show videos</label><br>
         <input type="text" name="" readonly="" value="[wp_youtube_gallery]" class="top-margin">
     </div>
 </header>
</div>
<?php

    // ================== Tabs ========================//
$tab = ( ! empty( $_GET['tab'] ) ) ? esc_attr( $_GET['tab'] ) : 'first';
wpYouTubeGalleryAdminTabs( $tab );
   // =========================== Tab 1 ========================//
if ( $tab == 'first' ) {
  //getting setting of general tab
  global $wpdb;
  $table_name = $wpdb->prefix . 'wp_youtube_gallery';
  $setting_style = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '1' ");  
  
  $columns = esc_html( $setting_style->columns );
  $columns3 = $columns4 = "";
  if($columns == "3"){
    $columns3 = "selected";
  }
  elseif ($columns == "4") {
     $columns4 = "selected";
  }

  $perPage = esc_html( $setting_style->per_page );

  if(esc_html( $setting_style->video_title ) == "1"){
    $videoTitleYes = "checked";
  }
  else{
    $videoTitleNo = "checked";
  }
  if(esc_html( $setting_style->play_icon ) == "1"){
    $playIconYes = "checked";
  }
  else{
    $playIconNo = "checked";
  }
  if(esc_html( $setting_style->short_desc ) == "1"){
    $shortDescYes = "checked";
  }
  else{
    $shortDescNo = "checked";
  }
  if(esc_html( $setting_style->posted_time ) == "1"){
    $postedTimeYes = "checked";
  }
  else{
    $postedTimeNo = "checked";
  }
  if(esc_html( $setting_style->views ) == "1"){
    $viewsYes = "checked";
  }
  else{
    $viewsNo = "checked";
  }
  if(esc_html( $setting_style->likes ) == "1"){
    $likesYes = "checked";
  }
  else{
    $likesNo = "checked";
  }
  if(esc_html( $setting_style->comments ) == "1"){
    $commentsYes = "checked";
  }
  else{
    $commentsNo = "checked";
  }

        
    ?>
    <form method="post" action="#">
        <div class="woo-live-saleTabs woo-live-sale-firstTab gen_sett tab_1">      
         <div class="general_set">    
        
         <!-- ============== COLUMNS LAYOUT ================== -->
        <div class="colms_layout pdg">
             <label class="title colm_layout_title" for="vid_colm_layouts">Columns Layout </label>
                 <select name="vid_colm_layouts" id="vid_colm_layouts_list" class="select_colm_layout select_layout">
                     <option value="3" name="3_colm" <?php echo esc_html( $columns3 ); ?>>3 columns</option>
                      <option value="4" name="4_colm"<?php echo esc_html( $columns4 ) ; ?>>4 columns</option>                 
                </select>
                <p class="alert">Note:The number of columns of the videos on Grid</p>
        </div>
      <!-- ============== VIDEO PER PAGE ================== -->
       <div class="vid_per_page pdg">
             <label class="title per_page_layout_title" for="vid_per_page_sett">Videos per page </label>
                 <select name="vid_num_page" id="vid_per_page_sett" class="vid_on_page">
                     <option value="3" name="3_colm" selected="selected">3 per page</option>
                    <option value="4" name="4_colm" disabled="">4 per page(Pro only)</option>
                    <option value="5" name="4_colm" disabled="">5 per page(Pro only)</option>
                    <option value="6" name="4_colm" disabled="">6 per page(Pro only)</option>
                    <option value="7" name="4_colm" disabled="">7 per page(Pro only)</option>
                    <option value="8" name="4_colm" disabled="">8 per page(Pro only)</option>    
                    <option value="9" name="4_colm" disabled="">9 per page(Pro only)</option> 
                    <option value="10" name="4_colm" disabled="">10 per page(Pro only)</option>
                    <option value="11" name="4_colm" disabled="">11 per page(Pro only)</option>
                    <option value="12" name="4_colm" disabled="">12 per page(Pro only)</option>              
                </select>
                <p class="alert">Note:The number of columns in the video Grid <a href="http://moondeveloper.com/product/wp-youtube-video-gallery/" class="buy-pro">Buy Pro version</a></p> 
        </div>

          
         <!-- ============== VIDEO TITLE ================== -->
       <div class="vid_title_cont pdg">
             <label class="title vid_layout_title">Videos Title? </label>
             <div class="title_wrap select_title_field" id="vid_title">
             <div class="ena_title check_btn_layout">
                 <label for="title_yes"><input type="radio" name="enable_title" id="title_yes" class="title_check" value="1" <?php echo esc_html( $videoTitleYes ); ?>>
             YES</label>
               </div>
               <div class="dis_title check_btn_layout">
                <label for="title_no"><input type="radio" name="enable_title" id="title_no" class="title_check" value="0"<?php echo esc_html( $videoTitleNo ); ?>>
               NO</label></div></div>
                <p class="alert">Note:Display video title on listing.</p>
        </div>
          <!-- ============== VIDEO TITLE ================== -->
       <div class="vid_title_cont pdg">
             <label class="title vid_layout_title">Icon on the thumbnail? </label>
             <div class="title_wrap select_title_field" id="icon_title">
             <div class="ena_title check_btn_layout">
                 <label for="icon_yes"><input type="radio" name="enable_thumb" id="icon_yes" class="icon_check" checked value="1" <?php echo esc_html( $playIconYes ); ?>>
             YES</label>
               </div>
               <div class="dis_title check_btn_layout">
                <label for="icon_no"><input type="radio" name="enable_thumb" id="icon_no" class="icon_check" value="0" <?php echo esc_html( $playIconNo ); ?>>
               NO</label></div></div>
                <p class="alert">Note:Display icond on the video thumbnail.</p>
        </div>
          <!-- ============== VIDEO DESCRIPTION ================== -->
       <div class="vid_desc_cont pdg">
             <label class="title vid_layout_desc">Videos short description? </label>
             <div class="desc_wrap select_desc_field" id="vid_desc">
             <div class="ena_desc check_btn_layout">
                 <label for="desc_yes"><input type="radio" name="enable_desc" id="desc_yes" class="desc_check" checked value="1" <?php echo esc_html( $shortDescYes ); ?>>
             YES</label>
               </div>
               <div class="dis_desc check_btn_layout">
                <label for="desc_no"><input type="radio" name="enable_desc" id="desc_no" class="desc_check" value="0" <?php echo esc_html( $shortDescNo ); ?>>
               NO</label></div></div>
                <p class="alert">Note:Display video description on listing.</p>
        </div>
           <!-- ============== VIDEO POSTED TIME ================== -->
       <div class="vid_desc_cont pdg">
             <label class="title vid_layout_desc">Videos posted time? </label>
             <div class="desc_wrap select_desc_field" id="time_desc">
             <div class="ena_desc check_btn_layout">
                 <label for="time_yes"><input type="radio" name="enable_time" id="time_yes" class="desc_check" checked value="1" <?php echo esc_html( $postedTimeYes ); ?>>
             YES</label>
               </div>
               <div class="dis_desc check_btn_layout">
                <label for="time_no"><input type="radio" name="enable_time" id="time_no" class="desc_check" value="0" <?php echo esc_html( $postedTimeNo ); ?>>
               NO</label></div></div>
                <p class="alert">Note:Display video posted time</p>
        </div>
        <!-- ============== NUMBER OF VIEWS ================== -->
       <div class="vid_desc_cont pdg">
             <label class="title vid_layout_desc">Show number of views? </label>
             <div class="desc_wrap select_desc_field" id="views_desc">
             <div class="ena_desc check_btn_layout">
                 <label for="views_yes"><input type="radio" name="enable_views" id="views_yes" class="desc_check" checked value="1" <?php echo esc_html( $viewsYes ); ?>>
             YES</label>
               </div>
               <div class="dis_desc check_btn_layout">
                <label for="views_no"><input type="radio" name="enable_views" id="views_no" class="desc_check" value="0" <?php echo esc_html( $viewsNo ); ?>>
               NO</label></div></div>
                <p class="alert">Note:Display number of views of the video</p>
        </div>
        <!-- ============== NUMBER OF VIEWS ================== -->
       <div class="vid_desc_cont pdg">
             <label class="title vid_layout_desc">Show number of Likes? </label>
             <div class="desc_wrap select_desc_field" id="views_desc">
             <div class="ena_desc check_btn_layout">
                 <label for="likes_yes"><input type="radio" name="enable_likes" id="likes_yes" class="desc_check" checked value="1" <?php echo esc_html( $likesYes ); ?>>
             YES</label>
               </div>
               <div class="dis_desc check_btn_layout">
                <label for="likes_no"><input type="radio" name="enable_likes" id="likes_no" class="desc_check" value="0" <?php echo esc_html( $likesNo ); ?>> 
               NO</label></div></div>
                <p class="alert">Note:Display number of likes of the video</p>
        </div>
        <!-- ============== NUMBER OF VIEWS ================== -->
       <div class="vid_desc_cont pdg">
             <label class="title vid_layout_desc">Show number of Comments? </label>
             <div class="desc_wrap select_desc_field" id="video_comments">
             <div class="ena_desc check_btn_layout">
                 <label for="comments_yes"><input type="radio" name="enable_comments" id="comments_yes" class="desc_check" checked value="1" <?php echo esc_html( $commentsYes ); ?>>
             YES</label>
               </div>
               <div class="dis_desc check_btn_layout">
                <label for="comments_no"><input type="radio" name="enable_comments" id="comments_no" class="desc_check" value="0" <?php echo esc_html( $commentsNo ); ?>>
               NO</label></div></div>
                <p class="alert">Note:Display number of comments of the video</p>
        </div>

<!-- ================= SAVE SETTING ========================= -->
<div class="save_sett_wrap">
     <button type="button" id="save_setting_1" class="footer_save_btn">SAVE</button>

</div>
        </div>
    </div>
        <?php
    }
    // =========================== Tab 2 ========================//
    elseif($tab == 'second' ){
  global $wpdb;
  $table_name = $wpdb->prefix . 'wp_youtube_gallery';
  $setting_style = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '1' ");  
  
  $playerWidth = esc_html( $setting_style->player_width );
  $playerHeight= esc_html( $setting_style->player_height );

  if(esc_html( $setting_style->popup_video_title ) == "1"){
    $popupVideoTitleYes = "checked";
  }
  else{
    $popupVideoTitleNo = "checked";
  }
  if(esc_html( $setting_style->video_details ) == "1"){
    $videoCountDetailsYes = "checked";
  }
  else{
    $videoCountDetailsNo = "checked";
  }
  if(esc_html( $setting_style->channel_details ) == "1"){
    $channelDetailsYes = "checked";
  }
  else{
    $channelDetailsNo = "checked";
  }
  if(esc_html( $setting_style->popup_comments ) == "1"){
    $popupCommentsYes = "checked";
  }
  else{
    $popupCommentsNo = "checked";
  }
  if(esc_html( $setting_style->autoplay ) == "1"){
    $autoplayYes = "checked";
  }
  else{
    $autoplayNo = "checked";
  }
        ?>
        <div class="woo-live-saleTabs woo-live-sale-secondTab player_sett tab_2"> 
                <!-- ============== VIDEO PLAYER WIDTH LAYOUT ================== -->
                       <div class="vid_player_wid pdg">
             <label class="title vid_player_wid_layout_title" for="vid_player_wid_sett">Player width </label>
                 <input type="text" name="vid_play_wid" id="vid_player_wid_sett" class="ply_wid mrg bdr_clr" value="<?php echo esc_html( $playerWidth ); ?>">
                <p class="alert">Note:The default width of player. Set 0 to use full container width player. Default : 600(px)</p>
        </div>
          <!-- ============== VIDEO PLAYER SCROOL OOFSET LAYOUT ================== -->
                       <div class="player_scrll_offset pdg">
             <label class="title vid_player_scrll_layout_title" for="vid_ply_scrll_ofset_sett">Player Height </label>
                 <input type="text" name="vid_play_scr_offset" id="vid_ply_scrll_ofset_sett" class="scr0ll_offset mrg bdr_clr" value="<?php echo esc_html( $playerHeight ); ?>">
                <p class="alert">Note:The distance betwen top browser with player when play a video. Set 0 for auto center player in screen. Default : 400(px)</p>
                </div>
                 <!-- ============== VIDEO TITLE ================== -->
       <div class="vid_title_cont pdg">
             <label class="title vid_layout_title">Videos Title on popup? </label>
             <div class="title_wrap select_title_field" id="player_vid_title">
             <div class="ena_title check_btn_layout">
                 <label for="p_title_yes"><input type="radio" name="enable_title_popup" id="p_title_yes" class="title_check"  value="1" <?php echo esc_html( $popupVideoTitleYes ); ?>>
             YES</label>
               </div>
               <div class="dis_title check_btn_layout">
                <label for="p_title_no"><input type="radio" name="enable_title_popup" id="p_title_no" class="title_check" value="0" <?php echo esc_html( $popupVideoTitleNo ); ?>>
               NO</label></div></div>
                <p class="alert">Note:Display video title on the video popup.</p>
        </div>
        <!-- ============== VIDEO TITLE ================== -->
       <div class="vid_title_cont pdg">
             <label class="title vid_layout_title">Video Views, number of likes, dislikes and share? </label>
             <div class="title_wrap select_title_field" id="player_vid_icon">
             <div class="ena_title check_btn_layout">
                 <label for="title_yes"><input type="radio" name="player_enable_option" id="icon_yes" class="icon_check" value="1" <?php echo esc_html( $videoCountDetailsYes ); ?>>
             YES</label>
               </div>
               <div class="dis_title check_btn_layout">
                <label for="title_no"><input type="radio" name="player_enable_option" id="icon_no" class="icon_check" value="0" <?php echo esc_html( $videoCountDetailsNo ); ?>>
               NO</label></div></div>
                <p class="alert">Note:Display Views, number of likes, dislikes and share on the video popup</p>
        </div>
          <!-- ============== VIDEO DESCRIPTION ================== -->
       <div class="vid_desc_cont pdg">
             <label class="title vid_layout_desc">Videos Channel details? </label>
             <div class="desc_wrap select_desc_field"  id="vid_desc">
             <div class="ena_desc check_btn_layout">
                 <label for="desc_yes"><input type="radio" name="enable_channel_details" id="desc_yes" class="desc_check" value="1" <?php echo esc_html( $channelDetailsYes ); ?>>
             YES</label>
               </div>
               <div class="dis_desc check_btn_layout">
                <label for="desc_no"><input type="radio" name="enable_channel_details" id="desc_no" class="desc_check"  value="0" <?php echo esc_html( $channelDetailsNo ); ?>>
               NO</label></div></div>
                <p class="alert">Note:Display channel logo, name and description on the video popup</p>
        </div>
         <!-- ============== VIDEO CONTROLS ================== -->
       <div class="vid_plyr_contrl pdg">
             <label class="title vid_player_contrl_layout">Show comments?</label>
             <div class="plyr_control_wrap select_field" id="video_player_control">
             <div class="ena_control check_btn_layout">
                 <label for="control_yes"><input type="radio" name="enable_comments" id="control_yes" class="control_check" value="1" <?php echo esc_html( $popupCommentsYes ); ?>>
             YES</label>
               </div>
               <div class="dis_control check_btn_layout">
                <label for="control_no"><input type="radio" name="enable_comments" id="control_no" class="control_check" value="0" <?php echo esc_html( $popupCommentsNo ); ?>>
               NO</label></div></div>
        </div>
         <!-- ============== VIDEO AUTOPLAY ================== -->
       <div class="vid_plyr_autoplay pdg">
             <label class="title vid_player_autoplay_layout">Auto play </label>
             <div class="plyr_autoplay_wrap select_autoplay_field" id="video_player_autoplay">
             <div class="ena_autoplay check_btn_layout">
                 <label for="autoplay_yes"><input type="radio" name="enable_autoplay" id="autoplay_yes" class="autoplay_check" value="1" <?php echo esc_html( $autoplayYes ); ?>>
             YES</label>
               </div>
               <div class="dis_autoplay check_btn_layout">
                <label for="autoplay_no"><input type="radio" name="enable_autoplay" id="autoplay_no" class="autoplay_check" value="0" <?php echo esc_html( $autoplayNo ); ?>>
               NO</label></div></div>
                <p class="alert">Note:This parameter specifies whether the initial video will automatically start to play when the player loads.</p>
        </div>
         
        <!-- ================= SAVE SETTING ========================= -->
<div class="save_sett_wrap">
     <button type="button" id="save_setting_2" class="footer_save_btn">SAVE</button>
</div>
       </div>
        <?php
    }
// =========================== Tab 2 ========================//
    elseif($tab == 'fifth' ){
  global $wpdb;
  $table_name = $wpdb->prefix . 'wp_youtube_gallery';
  $setting_style = $wpdb->get_row("SELECT youtube_api, channel_url FROM $table_name WHERE id = '1' "); 
        ?>
        <div class="woo-live-saleTabs woo-live-sale-fifthTab api_sett tab_5">
          <!-- ================ YOUTUBE API ================= -->
          <div class="pdg youtube_api_wrap">
            <label class="title youtube_api_layout">Enter Youtube API Key</label> 
            <div class="yt_field_wrap">
              <input type="text" name="api_key" id="youtube_api_key" class="yt_api_key" value="<?php echo esc_html( $setting_style->youtube_api ); ?>">
               <p class="alert">Note: Follow this guide to get your own YouTube API key <a href="https://www.youtube.com/watch?v=SzlG5Qnjd4Y" target="_blank">Follow This Tutorial</a></p>
            </div>
          </div>
           <!-- ================ CHANNEL URL ================= -->
          <div class="pdg youtube_api_wrap">
            <label class="title youtube_api_layout">Enter your Channel URL</label> 
            <div class="yt_field_wrap">
              <input type="text" name="api_key" id="channel_api_key" class="yt_api_key" value="<?php echo esc_html( $setting_style->channel_url ); ?>">
               <p class="alert">Note: Channel URL will be something like this: <b>https://www.youtube.com/channel/UCRpNVpZoW56rOsV-6wFK3lg</b><br>
                <b class="red-color">The free version only support channe URL not the user name. <a href="http://moondeveloper.com/product/wp-youtube-video-gallery/">Buy Pro Version Here</a></b></p>
            </div>
          </div>
         
          <!-- ================= SAVE SETTING ========================= -->
<div class="save_sett_wrap">
     <button type="button" id="save_setting_3" class="footer_save_btn">SAVE</button>

</div>


        </div>
        <?php

    }
        
     // =========================== Tab 6 ========================//
    else{
        ?>
        <div class="woo-live-saleTabs woo-live-sale-seventhTab intro_sett tab_6">

        </div>
    </form>
    <?php

}
}


//===================== SAVE SETTING =================//
add_action('wp_ajax_wp_YT_video_gallery', 'wpYTVideoGallerySettingSave');
function wpYTVideoGallerySettingSave(){
global $wpdb;
$table = $wpdb->prefix . 'wp_youtube_gallery';
if (isset($_POST['settingOneSave'])) {
  $columns    = trim(sanitize_text_field($_POST['columns']));
  $perPage    = trim(sanitize_text_field($_POST['perPage']));
  $videoTitle = trim(sanitize_text_field($_POST['videoTitle']));
  $videoThumb = trim(sanitize_text_field($_POST['videoThumb']));
  $videoDesc  = trim(sanitize_text_field($_POST['videoDesc']));
  $videoTime  = trim(sanitize_text_field($_POST['videoTime']));
  $videoViews = trim(sanitize_text_field($_POST['videoViews']));
  $videoLikes = trim(sanitize_text_field($_POST['videoLikes']));
  $videoComments = trim(sanitize_text_field($_POST['videoComments']));

//update record
$wpdb->query("UPDATE $table SET 
    columns = '$columns', per_page = '$perPage', video_title = '$videoTitle', play_icon = '$videoThumb', short_desc = '$videoDesc', posted_time = '$videoTime', views = '$videoViews', likes = '$videoLikes', comments = '$videoComments' WHERE id = '1'");
echo esc_html( '1' );
}

if (isset($_POST['settingTwoSave'])) {
  $playerWidth    = trim(sanitize_text_field($_POST['playerWidth']));
  $playerHeight   = trim(sanitize_text_field($_POST['playerHeight']));
  $popupTitle     = trim(sanitize_text_field($_POST['popupTitle']));
  $countOptions   = trim(sanitize_text_field($_POST['countOptions']));
  $channelDetails = trim(sanitize_text_field($_POST['channelDetails']));
  $popupComments  = trim(sanitize_text_field($_POST['popupComments']));
  $autoPlay       = trim(sanitize_text_field($_POST['autoPlay']));
//update record
$wpdb->query("UPDATE $table SET 
    player_width = '$playerWidth', player_height = '$playerHeight', popup_video_title = '$popupTitle', video_details = '$countOptions', channel_details = '$channelDetails', popup_comments = '$popupComments', autoplay = '$autoPlay' WHERE id = '1'");
echo esc_html( '1' );
}

if (isset($_POST['settingThreeSave'])) {
  $youtubeAPI   = trim(sanitize_text_field($_POST['youtubeAPI']));
  $channelURL   = trim(sanitize_text_field($_POST['channelURL']));
//update record
$wpdb->query("UPDATE $table SET 
    youtube_api = '$youtubeAPI', channel_url = '$channelURL' WHERE id = '1'");
echo esc_html( '1' );
}
exit();
}