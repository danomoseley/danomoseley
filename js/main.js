$.fn.spin = function(opts) {
  this.each(function() {
	var $this = $(this),
		data = $this.data();

	if (data.spinner) {
	  data.spinner.stop();
	  delete data.spinner;
	}
	if (opts !== false) {
	  data.spinner = new Spinner($.extend({color: $this.css('color')}, opts)).spin(this);
	}
  });
  return this;
};
		$(document).ready(function(){
			$(".about .pull-tab").on("click", function() {
				$('.about .content').slideToggle();
				$(this).toggleClass('on off');
			});
			$(".print").click(function(e){
				var opts = {
				  lines: 12, // The number of lines to draw
				  length: 7, // The length of each line
				  width: 4, // The line thickness
				  radius: 10, // The radius of the inner circle
				  shadow: true, // Whether to render a shadow
				  hwaccel: false, // Whether to use hardware acceleration
				  className: 'spinner', // The CSS class to assign to the spinner
				  zIndex: 2e9, // The z-index (defaults to 2000000000)
				  top: '50%', // Top position relative to parent in px
				  left: '50%' // Left position relative to parent in px
				};
				e.preventDefault();
				var spinner = new Spinner(opts).spin()
				$("#sign_up").append(spinner.el);
				$("#sign_up").lightbox_me({centered: true, closeClick: false});
				var token = new Date().getTime();

				window.location = "http://ec2.danomoseley.com/pdf.php?downloadToken="+token;
				
				var messages = ["Rendering Page", "Creating PDF"];
				$("#sign_up .first").html(messages[0])
				var i=1;
				var slideMessages = window.setInterval(function () {
					if (i<messages.length) {
						$("#sign_up .first").html(messages[i]);
					}
					i++;
				}, 2000);
				
				var time = 0;
				
				var timer = window.setInterval(function() {
					time += 100;
				}, 100);
				
				var fileDownloadCheckTimer = window.setInterval(function () {
					var cookieValue = $.cookie('downloadToken');
					if (cookieValue == token) {
						$.cookie('downloadToken', null);
						$("#sign_up").trigger('close');
						window.clearInterval(fileDownloadCheckTimer);
						window.clearInterval(slideMessages);
						window.clearInterval(timer);
						
						_gaq.push(['_trackEvent', 'PDF', 'Download', '', time/1000]);
					}
				}, 100);
				
				return false;
			});
		});