$(document).ready(function(){
	$('#reports_done').hide();
	initialdisableflag = 0;

	$('#reports_edit').click(function(){
		$('#reports_done').show();
		$('#reports_edit').hide();
		$('#reports_add').hide();
		$('#reports_rem').hide();
		
		if(initialdisableflag == 1){
			$( "#sortable1" ).sortable("enable");
			$( "#sortable2" ).sortable("enable");
			$( "#sortable3" ).sortable("enable");
			$( "#sortable4" ).sortable("enable");
		}
		
		$( "#sortable1, #sortable2, #sortable3, #sortable4" ).sortable({
			connectWith: ".connectedSortable",
			stop: function(event, ui) {
				$('.connectedSortable').each(function() {
					myarray = $(this).sortable("toArray");
					if(myarray.length>3){
						myulid = this.id;
						alert(myulid + " has more than 3 items!");
						stringtemp = myulid.substring(8);
						inttemp = parseInt(stringtemp);
						inttemp++;
						if(inttemp == 5){
							inttemp = 1;
						}
						nextulid = "sortable" + inttemp;
						myli = $('#' + myarray[3]);
						//alert(myarray[5]);
						newli = $("<li style=\"display: list-item;\" id=\"" + myarray[3] + "\">").html(myli.html());
						//alert(newli.html());
						$("#" + nextulid).prepend(newli);
						myli.remove();
					}
				});
				// RUN TWICE 
				$('.connectedSortable').each(function() {
					myarray = $(this).sortable("toArray");
					if(myarray.length>3){
						myulid = this.id;
						//alert(myulid + " has more than 5 items!");
						stringtemp = myulid.substring(8);
						inttemp = parseInt(stringtemp);
						inttemp++;
						if(inttemp == 5){
							inttemp = 1;
						}
						nextulid = "sortable" + inttemp;
						myli = $('#' + myarray[3]);
						//alert(myarray[5]);
						newli = $("<li style=\"display: list-item;\" id=\"" + myarray[3] + "\">").html(myli.html());
						//alert(newli.html());
						$("#" + nextulid).prepend(newli);
						myli.remove();
					}
				});
			}
		});
		
		$( "#sortable1" ).disableSelection();
		$( "#sortable2" ).disableSelection();
		$( "#sortable3" ).disableSelection();
		$( "#sortable4" ).disableSelection();
		$( "#sortable1" ).sortable({helper: 'clone'});
		$( "#sortable2" ).sortable({helper: 'clone'});
		$( "#sortable3" ).sortable({helper: 'clone'});
		$( "#sortable4" ).sortable({helper: 'clone'});
	});
	$('#reports_done').click(function(){
		$('#reports_done').hide();
		$('#reports_edit').show();
		$('#reports_add').show();
		$('#reports_rem').show();
		$( "#sortable1" ).sortable("disable");
		$( "#sortable2" ).sortable("disable");
		$( "#sortable3" ).sortable("disable");
		$( "#sortable4" ).sortable("disable");
		initialdisableflag = 1;
		
		});
	$('#reports_add').click(function(){
		$('#reports_done').show();
		$('#reports_add').hide();
		$('#reports_rem').hide();
		$('#reports_edit').hide();
	});
	$('#reports_rem').click(function(){
		$('#reports_done').show();
		$('#reports_rem').hide();
		$('#reports_add').hide();
		$('#reports_edit').hide();
	});
	
	$("#reports_done").click(function(){
		//alert("CLICKED!");
		resultNames = "";
		$('#sortable1').find("li").each(function(){
			resultNames += $(this).text() + ",";
		});
		$('#sortable2').find("li").each(function(){
			resultNames += $(this).text() + ",";
		});
		$('#sortable3').find("li").each(function(){
			resultNames += $(this).text() + ",";
		});
		$('#sortable4').find("li").each(function(){
			resultNames += $(this).text() + ",";
		});
		result_len = resultNames.length;
		resultNames = jQuery.trim(resultNames).substring(0, result_len - 1);
		//alert(resultNames);
		
		resultPaths = "";
		$('#sortable1').find("li").each(function(){
			resultPaths += $(this).path() + ",";
		});
		result_len = resultPaths.length;
		resultPaths = jQuery.trim(resultPaths).substring(0, result_len - 1);
		//alert(resultPaths);
			
		//var JSONObject = {
		//	"order":result
		//};
		//$.ajax({
		//	type: "POST",
		//	url: "jq_receive.php",
		//	data: JSONObject,
		//	cache: false,
		//	async: false,
			//success: function(){
			//	alert("DEBUG JSON sent to php!");
			//}
		//});
		
		});
	
	$(".connectedSortable").each(function(){
		//alert(this.id);
		var $myanchors = $(this);
		$myanchors.children().each(function(){
			//alert(this.href);
			if((this.href.search(".pdf")) > 0){
				//alert(this.href);
				$(this).children().addClass("pdf");
			}else if((this.href.search(".doc*")) > 0){
				//alert(this.href);
				$(this).children().addClass("doc");
			} else if((this.href.search(".xls")) > 0){
				//alert(this.href);
				$(this).children().addClass("xls");
			}
		});
		
	});
	

	
});