<!--The data will be populated using Ajax -->
<div class="popup" role="alert">
  <div class="popup-container">
    <a href="#0" class="popup-close img-replace">Close</a>
   <div class="iframe">
   </div>
     <div class="yt2-video-details">
  	<div class="yt2-video-video-details">
  		<h3></h3>
  		<div class="yt2-views-count">
  			
  		</div>
  		<div class="yt2-like-dislike">
  			<img src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/images/like.svg'; ?>" class="yt2-like-btn"> 
  			<span class="yt2-total-likes yt2-total-like-text">520</span>
  			<img src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/images/dislike.svg'; ?>" class="yt2-dislike-btn"> 
  			<span class="yt2-total-likes yt2-total-dislike-text">520</span>
  			<a href="#" class="yt2-share-youtube-video">
  			<img src="<?php echo plugin_dir_url( __FILE__ ) . '../assets/images/share.svg'; ?>" class="yt2-share-icon"> 
  			<span class="yt2-share-text">SHARE</span>
  			</a>
  		</div>
  		<div class="clear"></div>
  		<div class="underline-yt"></div>
  		<div class="channe-details-yt2">
  			<div class="channel-left-yt2">
  				<img src="" class="channel-img-yt2">
  				<div class="left-channel-details-yt2">
  					<h3 class="channel-name-yt2"><a href="#"></a></h3>
  					<p class="publish-at-yt2"></p>
  					<p class="des-video-yt2">
  						
  					</p>
  				</div>
  			</div>
  			<div class="channel-right-yt2">
  				<div class="g-ytsubscribe" data-channelid="<?php echo esc_html( $channelID ); ?>" data-layout="default" data-count="default"></div>
  			</div>
  		</div>
  		<div class="comments-yt2-cont">

  		</div>
  	</div>
  </div>
  </div> 

</div> 