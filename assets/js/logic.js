
jQuery(document).ready(function() {
	var loadCounter = 0;
	var nextPage = "";
  var videosIds   = new Array();
  var videosPic   = new Array();
  var videosTitle = new Array();
  var videosTime = new Array();
  var videosDesc = new Array();
  var videoIdsString = "";
  var i = 0;
	jQuery('.btn-load-more-videos').click(function(){
	jQuery(this).attr('load-id', loadCounter);
	var currentLoad = jQuery(this).attr('load-id');
	if (currentLoad <= 0) {
	nextPage = jQuery(this).attr('nex-page');
  jQuery.get(
    "https://www.googleapis.com/youtube/v3/search",{
      part : 'snippet', 
      channelId : channelURL,
      type : 'video',
      maxResults: maxResultsAPI,
      order: 'date',
      pageToken: nextPage,
      key: youTubeAPIKey},
      function(data) {
      	nextPage = data.nextPageToken;
        jQuery.each( data.items, function( i, item ) {
         videoIdsString = videoIdsString +""+item.id.videoId+",";
         videosIds[i] =item.id.videoId; 
         videosPic[i]    = item.snippet.thumbnails.high.url;
         videosTitle[i]  = item.snippet.title;
         videosTime[i]   = item.snippet.publishTime;
         videosDesc[i]   =  item.snippet.description;
         i++;
        })

  //Getting video details
  i = 0;
  jQuery.get(
    "https://www.googleapis.com/youtube/v3/videos",{
      part : 'statistics', 
      id : videoIdsString,
      key: youTubeAPIKey},
      function(data) {
       // console.log(data);
        jQuery.each( data.items, function( i, item ) {  
         var clockImg = jQuery('.clock-puslished-video').last().attr('src');
         var eyeImg =  jQuery('img.eye-puslished-video').last().attr('src'); 
         var likeImg = jQuery('.like-puslished-video').last().attr('src');
         var commentImg = jQuery('.comments-puslished-video').last().attr('src');
          jQuery('.videos-block-cont').append('<div class="vid_block vid_wrapper" video-poup-id="'+videosIds[i]+'"> <div class="yt-video-img"> <svg class="yottie-widget-video-preview-play" viewBox="0 0 68 48"><g fill-rule="evenodd"><path class="maincolor" d="M31.386 0h5.873c2.423.06 4.849.08 7.273.153 3.306.094 6.614.219 9.914.46 1.23.092 2.46.2 3.684.35.936.121 1.875.253 2.79.491a8.56 8.56 0 0 1 4.23 2.623 8.597 8.597 0 0 1 1.9 3.66c.52 2.09.755 4.24.95 6.382v19.415c-.193 2.209-.424 4.424-.932 6.586a8.575 8.575 0 0 1-6.352 6.415c-.918.211-1.854.334-2.788.445-2.585.29-5.185.436-7.782.56a367.25 367.25 0 0 1-11.351.307c-.449.014-.9-.017-1.345.036h-4.26c-5.366-.045-10.733-.139-16.094-.417-2.57-.145-5.145-.305-7.696-.666-.912-.138-1.83-.294-2.697-.616a8.596 8.596 0 0 1-4.698-4.222c-.388-.764-.628-1.592-.802-2.428-.423-2.006-.64-4.047-.813-6.087-.242-2.984-.348-5.978-.39-8.971v-1.06c.037-2.699.129-5.397.323-8.09.17-2.245.386-4.493.825-6.704.138-.67.289-1.342.54-1.98.92-2.382 2.935-4.322 5.365-5.117.517-.172 1.052-.275 1.588-.368C9.988.93 11.348.802 12.708.684 14.985.5 17.267.382 19.55.29c2.926-.116 5.854-.187 8.782-.233C29.349.03 30.369.042 31.386 0"></path><path class="subcolor" fill="#fff" d="M27.381 13.692c5.937 3.412 11.869 6.832 17.802 10.25-5.934 3.416-11.865 6.837-17.802 10.25-.002-6.834-.002-13.667 0-20.5z"></path></g></svg> <img src="'+videosPic[i]+'" alt="'+ videosTitle[i]+'" class="img-responsive" height="130px"> </div> <div class="video_details"> <div class="admin_avatar"> </div> <div class="vid_title"> <h3>'+videosTitle[i]+'</h3> <p class="published-date-video"><img src="'+clockImg+'" class="clock-puslished-video">'+timeSince(videosTime[i])+'</p> <p class="desc-video">'+videosDesc[i]+'</p> <div class="video-counts-list"> <img src="'+eyeImg+'" class="eye-puslished-video"> <span class="text-eye">'+item.statistics.viewCount+' Views</span> <img src="'+likeImg+'" class="like-puslished-video"> <span class="text-like">'+item.statistics.likeCount+' Likes</span> <img src="'+commentImg+'" class="comments-puslished-video"> <span class="text-comments">'+item.statistics.commentCount+' Comments</span> </div> </div> </div> </div>');
          i++;
        })

      }
  );
      }
  );




}
else{
  videoIdsString = "";
 jQuery.get(
    "https://www.googleapis.com/youtube/v3/search",{
      part : 'snippet', 
      channelId : channelURL,
      type : 'video',
      maxResults: maxResultsAPI,
      order: 'date',
      pageToken: nextPage,
      key: youTubeAPIKey},
      function(data) {
        nextPage = data.nextPageToken;
        jQuery.each( data.items, function( i, item ) {
         videoIdsString = videoIdsString +""+item.id.videoId+",";
         videosIds[i] =item.id.videoId; 
         videosPic[i]    = item.snippet.thumbnails.high.url;
         videosTitle[i]  = item.snippet.title;
         videosTime[i]   = item.snippet.publishTime;
         videosDesc[i]   =  item.snippet.description;
         i++;
        })
         //Getting video details
  i = 0;
  jQuery.get(
    "https://www.googleapis.com/youtube/v3/videos",{
      part : 'statistics', 
      id : videoIdsString,
      key: youTubeAPIKey},
      function(data) {
        
        jQuery.each( data.items, function( i, item ) {  
         var clockImg = jQuery('.clock-puslished-video').last().attr('src');
         var eyeImg =  jQuery('img.eye-puslished-video').last().attr('src'); 
         var likeImg = jQuery('.like-puslished-video').last().attr('src');
         var commentImg = jQuery('.comments-puslished-video').last().attr('src');

          jQuery('.videos-block-cont').append('<div class="vid_block vid_wrapper" video-poup-id="'+videosIds[i]+'"> <div class="yt-video-img"> <svg class="yottie-widget-video-preview-play" viewBox="0 0 68 48"><g fill-rule="evenodd"><path class="maincolor" d="M31.386 0h5.873c2.423.06 4.849.08 7.273.153 3.306.094 6.614.219 9.914.46 1.23.092 2.46.2 3.684.35.936.121 1.875.253 2.79.491a8.56 8.56 0 0 1 4.23 2.623 8.597 8.597 0 0 1 1.9 3.66c.52 2.09.755 4.24.95 6.382v19.415c-.193 2.209-.424 4.424-.932 6.586a8.575 8.575 0 0 1-6.352 6.415c-.918.211-1.854.334-2.788.445-2.585.29-5.185.436-7.782.56a367.25 367.25 0 0 1-11.351.307c-.449.014-.9-.017-1.345.036h-4.26c-5.366-.045-10.733-.139-16.094-.417-2.57-.145-5.145-.305-7.696-.666-.912-.138-1.83-.294-2.697-.616a8.596 8.596 0 0 1-4.698-4.222c-.388-.764-.628-1.592-.802-2.428-.423-2.006-.64-4.047-.813-6.087-.242-2.984-.348-5.978-.39-8.971v-1.06c.037-2.699.129-5.397.323-8.09.17-2.245.386-4.493.825-6.704.138-.67.289-1.342.54-1.98.92-2.382 2.935-4.322 5.365-5.117.517-.172 1.052-.275 1.588-.368C9.988.93 11.348.802 12.708.684 14.985.5 17.267.382 19.55.29c2.926-.116 5.854-.187 8.782-.233C29.349.03 30.369.042 31.386 0"></path><path class="subcolor" fill="#fff" d="M27.381 13.692c5.937 3.412 11.869 6.832 17.802 10.25-5.934 3.416-11.865 6.837-17.802 10.25-.002-6.834-.002-13.667 0-20.5z"></path></g></svg> <img src="'+videosPic[i]+'" alt="'+ videosTitle[i]+'" class="img-responsive" height="130px"> </div> <div class="video_details"> <div class="admin_avatar"> </div> <div class="vid_title"> <h3>'+videosTitle[i]+'</h3> <p class="published-date-video"><img src="'+clockImg+'" class="clock-puslished-video">'+timeSince(videosTime[i])+'</p> <p class="desc-video">'+videosDesc[i]+'</p> <div class="video-counts-list"> <img src="'+eyeImg+'" class="eye-puslished-video"> <span class="text-eye">'+item.statistics.viewCount+' Views</span> <img src="'+likeImg+'" class="like-puslished-video"> <span class="text-like">'+item.statistics.likeCount+' Likes</span> <img src="'+commentImg+'" class="comments-puslished-video"> <span class="text-comments">'+item.statistics.commentCount+' Comments</span> </div> </div> </div> </div>');
          i++;
        })
      videoIdsString = "";
      }
  );
      }
  );
	}

  loadCounter++;

});
});
jQuery(document).ready(function($){
  //open popup
  $('body').on('click', '.vid_block', function() {
    event.preventDefault();
    $('.popup').addClass('is-visible');
  var videoId = $(this).attr('video-poup-id');
  $('.popup-container iframe').remove();
   $('.popup-container .iframe').append('<iframe width="100%" height="450" src="https://www.youtube.com/embed/'+videoId+'?autoplay=1"></iframe>');
   getSingleVideoDetails(videoId);
   getCommentsDetails(videoId);
});
  
  //close popup
  $('body').on('click', '.popup', function() {
    if( $(event.target).is('.popup-close') || $(event.target).is('.popup') ) {
      event.preventDefault();
      $(this).removeClass('is-visible');
       $('.popup-container iframe').remove();
    }
  });
  //close popup when clicking the esc keyboard button
  $(document).keyup(function(event){
      if(event.which=='27'){
        $('.popup').removeClass('is-visible');
         $('.popup-container iframe').remove();
      }
    });

  //Getting single video details
  function getSingleVideoDetails(videoId){
	jQuery.get(
    "https://www.googleapis.com/youtube/v3/videos",{
      part : 'statistics, snippet', 
      id : videoId,
      type : 'video',
      key: youTubeAPIKey},
      function(data) {
        jQuery.each( data.items, function( i, item ) {
        //  console.log(item.snippet.thumbnails);
        console.log(data);

        //views
        jQuery('.yt2-views-count').html(item.statistics.viewCount + " Views");

        //like
        jQuery('.yt2-total-like-text').html(item.statistics.likeCount);

        //dislike
        jQuery('.yt2-total-dislike-text').html(item.statistics.dislikeCount);

        //title
        jQuery('.yt2-video-video-details h3').html(item.snippet.title);

        //channel title
        jQuery('.channel-name-yt2 a').html(item.snippet.channelTitle);

        //Channel Description
        jQuery('.des-video-yt2').html(item.snippet.description);

        //Channel image
        var channelImg = jQuery('.yt-img-channel').attr('src');
        jQuery('img.channel-img-yt2').attr('src', channelImg);

        
        })
      }
  );
  }

  // =============== Comments List =====================//
  function getCommentsDetails(videoId){
    jQuery('.comments-yt2-cont').html('');
    var likeImg = jQuery('.like-puslished-video').last().attr('src');
   jQuery.get(
    "https://www.googleapis.com/youtube/v3/commentThreads",{
      part : 'snippet', 
      videoId : videoId,
      maxResults: '100',
      key: 'AIzaSyCtkRccdQ042VBsPGYDfHQ7genDUerf8aw'},
      function(data) {

        jQuery.each( data.items, function( i, item ) {
          jQuery('.comments-yt2-cont').append('<div class="comments-yt2"> <img src="'+item.snippet.topLevelComment.snippet.authorProfileImageUrl+'" class="profile-img-yt2"> <div class="right-comments-yt2"> <b class="channel-name-yt2-comments"><a href="'+item.snippet.topLevelComment.snippet.authorChannelUrl+'">'+item.snippet.topLevelComment.snippet.authorDisplayName+'</a></b> <span>'+timeSince(item.snippet.topLevelComment.snippet.publishedAt)+'</span> <p class="comments-text-yt2">'+item.snippet.topLevelComment.snippet.textDisplay+'</p> <div class="comments-like"><img src="'+likeImg+'" class="yt2-like-btn"> <span class="comments-like-text">'+item.snippet.topLevelComment.snippet.likeCount+'</span></div> </div> </div>');
 
        })
      }
  );
}


});



function timeSince(time) {

  switch (typeof time) {
    case 'number':
      break;
    case 'string':
      time = +new Date(time);
      break;
    case 'object':
      if (time.constructor === Date) time = time.getTime();
      break;
    default:
      time = +new Date();
  }
  var time_formats = [
    [60, 'seconds', 1], // 60
    [120, '1 minute ago', '1 minute from now'], // 60*2
    [3600, 'minutes', 60], // 60*60, 60
    [7200, '1 hour ago', '1 hour from now'], // 60*60*2
    [86400, 'hours', 3600], // 60*60*24, 60*60
    [172800, 'Yesterday', 'Tomorrow'], // 60*60*24*2
    [604800, 'days', 86400], // 60*60*24*7, 60*60*24
    [1209600, 'Last week', 'Next week'], // 60*60*24*7*4*2
    [2419200, 'weeks', 604800], // 60*60*24*7*4, 60*60*24*7
    [4838400, 'Last month', 'Next month'], // 60*60*24*7*4*2
    [29030400, 'months', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
    [58060800, 'Last year', 'Next year'], // 60*60*24*7*4*12*2
    [2903040000, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
    [5806080000, 'Last century', 'Next century'], // 60*60*24*7*4*12*100*2
    [58060800000, 'centuries', 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
  ];
  var seconds = (+new Date() - time) / 1000,
    token = 'ago',
    list_choice = 1;

  if (seconds == 0) {
    return 'Just now'
  }
  if (seconds < 0) {
    seconds = Math.abs(seconds);
    token = 'from now';
    list_choice = 2;
  }
  var i = 0,
    format;
  while (format = time_formats[i++])
    if (seconds < format[0]) {
      if (typeof format[2] == 'string')
        return format[list_choice];
      else
        return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
    }
  return time;
}