//business logic

function get_suggestions( ) {
	$.ajax({
		url: "suggestuser.php",
		method: "POST",
		success: function(data){
			$('#suggestions-container').html(data);
		}
	});
}

$(document).ready(function(){
	get_suggestions();

	$(document).on('click', '#btn-load-more',function(){
		get_suggestions();
	});
	$(document).on('click', '#skip',function(e){
		var element = $(e.target);
		var username = element.data('username');
		window.location.href = "profile.php?user="+username;
	});

	$(document).on('click', '.action-button', function(e){
		var self = $(e.target);
		var action = self.data('action');
		var userid = self.data('userid');
		var name = self.data('name');
		
		if( action == 'follow'){
			$.ajax({
				url: 'action.php',
				method: 'POST',
				data: {action: 'follow', follower: name},
				success: function(){
					self.data('action','following');
					self.removeClass('button-outlined');
					self.addClass('button-filled--primary');
					self.text('Following');
				}
			});
		}else{
			$.ajax({
				url: 'action.php',
				method: 'POST',
				data: {action: 'unfollow', follower: name},
				success: function(){
					self.data('action','follow');
					self.removeClass('button-filled--primary');
					self.addClass('button-outlined');
					self.text('Follow');
				}
			});
		}
	});
});