<?php

/*
  Plugin Name: WP Youtube Video Gallery
  Plugin URI: http://moondeveloper.com
  Description: YouTube video gallery plugin for showing YouTube channel videos on your website.
  Version: 1.0
  Author: Zeshan Abdullah
  Author URI: https://www.fiverr.com/aliali44
 */

// Exit if accessed directly 
  if (!defined('ABSPATH'))
    exit;

  include_once 'admin/admin.php';
//Creating a table for saving gallery setting
function YTVideoGalleryDetailTable()
{      
 
  global $wpdb; 
  $db_table_name = $wpdb->prefix . 'wp_youtube_gallery';  // table name
  $charset_collate = $wpdb->get_charset_collate();
  $sql = "CREATE TABLE $db_table_name (
    id int(11) NOT NULL auto_increment,
    columns varchar(1),
    per_page varchar(2),
    video_title varchar(1),
    play_icon varchar(1),
    short_desc varchar(1),
    posted_time varchar(1),
    views varchar(1),
    likes varchar(1),
    comments varchar(1),
    player_width varchar(4),
    player_height varchar(4),
    popup_video_title varchar(1),
    video_details varchar(1),
    channel_details varchar(1),
    popup_comments varchar(1),
    autoplay varchar(1),
    youtube_api varchar(90),
    channel_url varchar(80),
    UNIQUE KEY id (id)
    ) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
add_option( 'test_db_version', $test_db_version );
// Adding default values
$wpdb->insert( $db_table_name, array( 'columns' => '3', 'per_page' => '3', 'video_title' => '1', 'play_icon' =>'1', 'short_desc' =>'1', 'posted_time' =>'1',
'views' =>'1','likes' =>'1','comments' =>'1','player_width' =>'600','player_height' =>'400','popup_video_title' =>'1','video_details' =>'1','channel_details' =>'1','popup_comments' =>'1','autoplay' =>'1','channel_url' =>'' ) );

} 
register_activation_hook( __FILE__, 'YTVideoGalleryDetailTable' );

//enqueues css and js files
add_action('wp_enqueue_scripts', 'YTVideoGalleryEnqueueScripts');

function YTVideoGalleryEnqueueScripts() {
    wp_enqueue_style('like', plugins_url('/assets/css/style.css', __FILE__));
    wp_enqueue_script('like', plugins_url('/assets/js/logic.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('subscribeJS', 'https://apis.google.com/js/platform.js', array(), null, true);
}

/* =========================== DEFAULT LAYOUT =============================== */
function wp_youtube_gallery() { 
  ?>
<!-- ================= DEAULT LAYOUT STYLE ============================= -->
<div id="vid_gallery_layout" class="default_vid_layout_wrap layout_1 ">    
<!-- GET API -->
<?php 
  global $wpdb;
  $table_name = $wpdb->prefix . 'wp_youtube_gallery';
  $setting_style = $wpdb->get_row("SELECT per_page, youtube_api, channel_url FROM $table_name WHERE id = '1' "); 
//Get videos from channel by YouTube Data API
$API_key    = esc_html( $setting_style->youtube_api );
$channelID  = YTGalleryGetChannelID( esc_html( $setting_style->channel_url ) );
$maxResults = esc_html( $setting_style->per_page );

//Channel art details
$channelArt = wp_remote_retrieve_body( wp_remote_get( 'https://www.googleapis.com/youtube/v3/channels?part=brandingSettings,snippet,statistics&id='.$channelID.'&key='.$API_key.''));
$queryResult = json_decode( $channelArt );

?>
<div class="yt-main-container">
<!-- Banner -->
<div class="yt-full-banner">
	<img src="<?php echo $queryResult->items[0]->brandingSettings->image->bannerImageUrl; ?>" class="yt-banner-img">
</div>
<!--Channel details -->
<div class="yt-channel-details">
	<div class="yt-left-channel-details">

		<img src="<?php echo $queryResult->items[0]->snippet->thumbnails->default->url; ?>" class="yt-img-channel">
		<div class="yt-title-channel">
			<h2 class="yt-channel-title"><?php echo $queryResult->items[0]->brandingSettings->channel->title; ?></h2>
			<p class="yt-channel-bottom-detaisl">
				<span class="yt-subs-count"><?php echo YTGallerythousandsCurrencyFormat($queryResult->items[0]->statistics->subscriberCount); ?> Subscribers</span>
				<span class="yt-total-videos"><?php echo YTGallerythousandsCurrencyFormat($queryResult->items[0]->statistics->videoCount); ?> Videos</span>
				<span class="yt-total-view-count"><?php echo YTGallerythousandsCurrencyFormat($queryResult->items[0]->statistics->viewCount); ?> Views</span>
			</p>
		</div>
	</div>
	<div class="yt-right-channel-details">
		<div class="g-ytsubscribe" data-channelid="<?php echo esc_html( $channelID ); ?>" data-layout="default" data-count="default"></div>
	</div>
</div>
<div class="clear"></div>
<div class="videos-block-cont">

<?php
//Fetching videos list
$video_list = wp_remote_retrieve_body( wp_remote_get( 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channelID.'&maxResults='.$maxResults.'&key='.$API_key.''));
$video_list = json_decode( $video_list );
//showing videos
$videos = array();
$i = 0;
foreach ($video_list->items as $item) {
    if (isset($item->id->videoId)) {
    	$videos[$i][0] = $item->id->videoId;
    	$videos[$i][1] = $item->snippet->thumbnails->medium->url;
    	$videos[$i][2] = $item->snippet->title;
    	$videos[$i][3] = $item->snippet->description;
    	$videos[$i][4] = $item->snippet->publishedAt;
    	$i++;
    	$videoIds = $videoIds.''.$item->id->videoId.',';
    	
    }
}
$video_details = wp_remote_retrieve_body( wp_remote_get('https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoIds.'&key='.$API_key.''));
$video_details = json_decode( $video_details );
$i = 0;
foreach ($video_details->items as $item) {
	?>
        <div class="vid_block vid_wrapper" video-poup-id="<?php echo $videos[$i][0]; ?>">
        	<div class="yt-video-img">
        	<svg class="yottie-widget-video-preview-play" viewBox="0 0 68 48"><g fill-rule="evenodd"><path class="maincolor" d="M31.386 0h5.873c2.423.06 4.849.08 7.273.153 3.306.094 6.614.219 9.914.46 1.23.092 2.46.2 3.684.35.936.121 1.875.253 2.79.491a8.56 8.56 0 0 1 4.23 2.623 8.597 8.597 0 0 1 1.9 3.66c.52 2.09.755 4.24.95 6.382v19.415c-.193 2.209-.424 4.424-.932 6.586a8.575 8.575 0 0 1-6.352 6.415c-.918.211-1.854.334-2.788.445-2.585.29-5.185.436-7.782.56a367.25 367.25 0 0 1-11.351.307c-.449.014-.9-.017-1.345.036h-4.26c-5.366-.045-10.733-.139-16.094-.417-2.57-.145-5.145-.305-7.696-.666-.912-.138-1.83-.294-2.697-.616a8.596 8.596 0 0 1-4.698-4.222c-.388-.764-.628-1.592-.802-2.428-.423-2.006-.64-4.047-.813-6.087-.242-2.984-.348-5.978-.39-8.971v-1.06c.037-2.699.129-5.397.323-8.09.17-2.245.386-4.493.825-6.704.138-.67.289-1.342.54-1.98.92-2.382 2.935-4.322 5.365-5.117.517-.172 1.052-.275 1.588-.368C9.988.93 11.348.802 12.708.684 14.985.5 17.267.382 19.55.29c2.926-.116 5.854-.187 8.782-.233C29.349.03 30.369.042 31.386 0"></path><path class="subcolor" fill="#fff" d="M27.381 13.692c5.937 3.412 11.869 6.832 17.802 10.25-5.934 3.416-11.865 6.837-17.802 10.25-.002-6.834-.002-13.667 0-20.5z"></path></g></svg>
                <img src="<?php echo $videos[$i][1] ?>" alt="<?php echo $videos[$i][2]; ?>" class="img-responsive" height="130px" />
                </div>
                <div class="video_details">
                <div class="admin_avatar">
                </div>
                <div class="vid_title">
                <h3><?php echo $videos[$i][2] ?></h3>
                <p class="published-date-video"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/images/clock.svg'; ?>" class="clock-puslished-video"><?php echo YTGalleryTimeAgoChange( $videos[$i][4] ); ?></p>
                <p class="desc-video"><?php echo $videos[$i][3]; ?></p>
                <div class="video-counts-list">
                	<img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/images/eye.svg'; ?>" class="eye-puslished-video"> 
                	<span class="text-eye"><?php echo YTGallerythousandsCurrencyFormat($item->statistics->viewCount); ?> Views</span>
                	<img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/images/like.svg'; ?>" class="like-puslished-video">
                	<span class="text-like"><?php echo YTGallerythousandsCurrencyFormat($item->statistics->likeCount); ?> Likes</span>
                	<img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/images/comment.svg'; ?>" class="comments-puslished-video">
                	<span class="text-comments"><?php echo YTGallerythousandsCurrencyFormat($item->statistics->commentCount); ?> Comments</span>
                </div>
               </div>      
            </div>
        </div>
        <?php
        $i++;
   }

?>
<div class="clear"></div>
</div>

<!-- ====================== Load More Button =================== -->
<div id="gallery_pagination">
<button class="btn-load-more-videos" load-id="1" nex-page="<?php echo $video_list->nextPageToken; ?>">Load More</button>
</div>
</div>
</div><!--end of main container -->
<!-- Video Popup -->
<?php 
include_once 'popup/videoPopup.php';

}
// register shortcode
  add_shortcode('wp_youtube_gallery', 'wp_youtube_gallery'); 

//style and script details
add_action('wp_footer', 'YTVideoGalleryFooterScriptStyle');
function YTVideoGalleryFooterScriptStyle()
{
  global $wpdb;
  $table_name       = $wpdb->prefix . 'wp_youtube_gallery';
  $setting_style    = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '1' ");
  $videoTitle       = esc_html( $setting_style->video_title );
  $playIcon         = esc_html( $setting_style->play_icon );
  $shortDesc        = esc_html( $setting_style->short_desc );
  $postedTime       = esc_html( $setting_style->posted_time );
  $views            = esc_html( $setting_style->views );
  $likes            = esc_html( $setting_style->likes );
  $comments         = esc_html( $setting_style->comments );
  $playerWidth      = esc_html( $setting_style->player_width );
  $playerHeight     = esc_html( $setting_style->player_height );
  $popup_video_title= esc_html( $setting_style->popup_video_title );
  $videoDetails     = esc_html( $setting_style->video_details );
  $channelDetails   = esc_html( $setting_style->channel_details );
  $popupComments    = esc_html( $setting_style->popup_comments );
  $autoplay         = esc_html( $setting_style->autoplay );

  //checking conditions
  if($videoTitle == "0"){
    $videoTitle ="none";
  }
  else{
   $videoTitle ="block"; 
  }
  if($playIcon == "0"){
    $playIcon ="none";
  }
  else{
   $playIcon ="block"; 
  }
  if($shortDesc == "0"){
    $shortDesc ="none";
  }
  else{
   $shortDesc ="block"; 
  }
  if($postedTime == "0"){
    $postedTime ="none";
  }
  else{
   $postedTime ="block"; 
  }
  if($views == "0"){
    $views ="none";
  }
  else{
   $views ="block"; 
  }
  if($likes == "0"){
    $likes ="none";
  }
  else{
   $likes ="block"; 
  }
  if($comments == "0"){
    $comments ="none";
  }
  else{
   $comments ="block"; 
  }
   if($popup_video_title == "0"){
    $popup_video_title ="none";
  }
  else{
   $popup_video_title ="inline-block"; 
  }
  if($videoDetails == "0"){
    $videoDetails ="none";
  }
  else{
   $videoDetails ="block"; 
  }
   if($channelDetails == "0"){
    $channelDetails ="none";
  }
  else{
   $channelDetails ="block"; 
  }
  if($popupComments == "0"){
    $popupComments ="none";
  }
  else{
   $popupComments ="block"; 
  }


  ?>
  <script type="text/javascript">
    var youTubeAPIKey    = "<?php echo esc_html( $setting_style->youtube_api ); ?>"; 
    var channelURL       = "<?php echo YTGalleryGetChannelID( esc_html( $setting_style->channel_url ) ); ?>";
    var maxResultsAPI    = "<?php echo esc_html( $setting_style->per_page ); ?>";
  </script>
  <style type="text/css">
    #vid_gallery_layout .vid_title h3{
      display: <?php echo esc_html( $videoTitle ) ; ?>;
    }
    .yottie-widget-video-preview-play{
      display: <?php echo esc_html( $playIcon ) ; ?>;
    }
    p.desc-video{
      display: <?php echo esc_html( $shortDesc ) ; ?>;
    }
    p.published-date-video{
      display: <?php echo esc_html( $postedTime ) ; ?>;
    }
    img.eye-puslished-video, .video-counts-list span.text-eye{
      display: <?php echo esc_html( $views ) ; ?>;
    }
    .video-counts-list img.like-puslished-video, .video-counts-list span.text-like{
      display: <?php echo esc_html( $likes ) ; ?>;
    }
    .video-counts-list img.comments-puslished-video, span.text-comments{
      display: <?php echo esc_html( $comments ) ; ?>;
    }
    .yt2-video-video-details h3{
      display: <?php echo esc_html( $videoTitle ) ; ?>;
    }
    .yt2-like-dislike{
      display: <?php echo esc_html( $videoDetails ) ; ?>;
    }
   .channel-left-yt2{
      display: <?php echo esc_html( $channelDetails ) ; ?>;
    }
    .comments-yt2-cont{
      display: <?php echo esc_html( $popupComments ) ; ?>;
    }
    
  </style>
  <?php
}

// count converted
function YTGallerythousandsCurrencyFormat($num) {

  if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

  }

  return $num;
}

function YTGalleryGetChannelID($url){
  if (strpos($url, 'youtube') !== false) {
  $channelURL = substr($url, strrpos($url, '/') + 1);
}
elseif (strlen($url) == 24) {
  return $channelURL; 
} 
  return $channelURL;  
}

//Time to days ago
function YTGalleryTimeAgoChange($time_ago)
{

    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "a week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "a month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year ago";
        }else{
            return "$years years ago";
        }
    }
}