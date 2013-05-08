$("#sortable").sortable({
	start: function(event, ui) {
			alert("Test!!!");
			result = "";
			alert($(this).sortable("toArray"));
			//$(this).find("li").each(function(){
			//    result += $(this).text() + ",";
			//});
			//$("."+$(this).attr("id")+".list").html(result);
	}
});
​
$("#sortable").on("sortstart", function(event, ui) {});