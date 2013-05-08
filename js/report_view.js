$(function() {
	$("li").click(function(){
		//alert("DEBUG CLICKED A LINE ITEM URL");
		$.ajax({
			type: "POST",
			url: "file://///enas11/ClientSites/Eastern Shawnee Tribe of OK/Casino/Bordertown Casino and Bingo/Bingo/013111 Bingo NW Analysis.pdf",
			data: JSONObject,
			cache: false,
			async: false,
			//success: function(){
			//	alert("DEBUG JSON sent to php!");
			//}
		});
	});
});