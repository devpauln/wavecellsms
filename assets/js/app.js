$(document).ready(function(){

	$("#source").keypress(function(e){
		var unit = this.value;
		var isValid = /^[a-zA-Z0-9]{0,20}$/i.test(unit);

		if(!isValid){
			e.preventDefault();
			$("#er-src").html("Only a maximum of 20 and no special characters.");
		}
		else{
			$("#er-src").html("");
		}
	});

	$("#destination").keypress(function(e){
		var unit = this.value;
		var isValid = /^[0-9]*$/i.test(unit);

		if(!isValid){
			e.preventDefault();
			$("#er-dst").html("Only integers allowed");
		}
		else{
			$("#er-dst").html("");
		}
	});

	$("#message").keypress(function(e){
		var unit = this.value;
		if(unit.length >= 500){
			e.preventDefault();
			$("#er-msg").html("Maximum of 500 characters only");
		}
		else{
			$("#er-msg").html("");
		}
	});

	$('#datetime').datetimepicker({
		locale: 'en',
		format: 'YYYY-MM-DD-HH:MM'
	});

	$("#sendsms").submit(function(){
		var src = $("#source").val();
		var dst = $("#destination").val();
		var msg_body = $("#message").val();
		var dt = $("#dt").val();

		$.ajax({
			url: '../api/sendsms',
			type: 'POST',
			data:{
				source: src,
				destination: dst,
				body: msg_body,
				date_time:dt
			},
			success: function(xml){
				var result = $(xml).find('string').text();
				var isReceived = /RECEIVED/g.test(result);
				if(isReceived){
					alert("Message has been sent");
					$("#source").val("");
					$("#destination").val("");
					$("#message").val("");
					$("#dt").val("");
				}
			},
			error: function(xhr, errmsg, err){
				console.log(xhr);
			}
		});
		return false;
	});
});