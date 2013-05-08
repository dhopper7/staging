$(document).ready(function(){
	$('#reports_done').hide();
	$('#reports_cancel').hide();
	$('#reports_trash').hide();
	initialdisableflag = 0;
	remflag = 0;

	$('#reports_edit').click(function(){
		$('#reports_done').show();
		$('#reports_cancel').show();
		$('#reports_trash').show();
		$('#reports_edit').hide();
		$('#reports_add').hide();
		$('#reports_rem').hide();
		
		if(initialdisableflag == 1){
			$( "#sortable1" ).sortable("enable");
			$( "#sortable2" ).sortable("enable");
			$( "#sortableTrash" ).sortable("enable");
		}
		
		$( "#sortable1, #sortable2, #sortableTrash" ).sortable({
			connectWith: ".connectedSortable",
			stop: function(event, ui) {
				//alert("TEST!");
				$('.connectedSortable').each(function() {
					myarray = $(this).sortable("toArray");
					if(myarray.length>6){
						myulid = this.id;
						//alert(myulid + " has more than 3 items!");
						stringtemp = myulid.substring(8);
						inttemp = parseInt(stringtemp);
						inttemp++;
						if(inttemp == 3){
							inttemp = 1;
						}
						nextulid = "sortable" + inttemp;
						myli = $('#' + myarray[6]);
						//alert(myarray[5]);
						newli = $("<li style=\"display: list-item;\" id=\"" + myarray[6] + "\">").html(myli.html());
						//alert(newli.html());
						$("#" + nextulid).prepend(newli);
						myli.remove();
					}
				});
				// RUN TWICE 
				$('.connectedSortable').each(function() {
					myarray = $(this).sortable("toArray");
					if(myarray.length>6){
						myulid = this.id;
						//alert(myulid + " has more than 5 items!");
						stringtemp = myulid.substring(8);
						inttemp = parseInt(stringtemp);
						inttemp++;
						if(inttemp == 3){
							inttemp = 1;
						}
						nextulid = "sortable" + inttemp;
						myli = $('#' + myarray[6]);
						//alert(myarray[5]);
						newli = $("<li style=\"display: list-item;\" id=\"" + myarray[6] + "\">").html(myli.html());
						//alert(newli.html());
						$("#" + nextulid).prepend(newli);
						myli.remove();
					}
				});
				
				// COPIED TO MAINTAIN ICONS
				$(".connectedSortable").each(function(){
					var $myanchors = $(this);
					if(this.id != "sortableTrash") {
						$myanchors.children().each(function(){
							//alert("DEBUG");
							//alert(this.id);
							//alert(this.children().href);
							//for (var member in this){
							//	alert(member);
							 // 	alert(this[member]);
							//}
							//alert(((this).innerHTML.search(".docx")));
							if(((this).innerHTML.search(".pdf")) > 0){
								//alert("DEBUG2");
								$(this).addClass("pdf");
							}else if(((this).innerHTML.search(".docx")) > 0){
								//alert("DEBUG2");
								$(this).addClass("doc");
							} else if(((this).innerHTML.search(".xlsx")) > 0){
								//alert("DEBUG2");
								$(this).addClass("xls");
							} else if(((this).innerHTML.search(".fld")) > 0){
								$(this).addClass("fld");
							}
						});
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
	/*  $('#reports_done').click(function(){
		$('#reports_done').hide();
		$('#reports_edit').show();
		$('#reports_add').show();
		$('#reports_rem').show();
		$( "#sortable1" ).sortable("disable");
		$( "#sortable2" ).sortable("disable");
		$( "#sortable3" ).sortable("disable");
		$( "#sortable4" ).sortable("disable");
		initialdisableflag = 1;
		remflag = 0;
		}); */
	$('#reports_add').click(function(){
		$('#reports_done').show();
		$('#reports_add').hide();
		$('#reports_rem').hide();
		$('#reports_edit').hide();
	});
	$('#reports_rem').click(function(){
		remflag = 1;
		$('#reports_done').show();
		$('#reports_rem').hide();
		$('#reports_add').hide();
		$('#reports_edit').hide();
	});
	
	$("#reports_done").click(function(){
		//alert("CLICKED!");
		resultNames = "";
		//$('#sortable1').find("li").each(function(){
		//	resultNames += $(this).text() + ",";
		//});
		//$('#sortable2').find("li").each(function(){
		//	resultNames += $(this).text() + ",";
		//});
		//$('#sortable3').find("li").each(function(){
		//	resultNames += $(this).text() + ",";
		//});
		//$('#sortable4').find("li").each(function(){
		//	resultNames += $(this).text() + ",";
		//});
		//result_len = resultNames.length;
		//resultNames = jQuery.trim(resultNames).substring(0, result_len - 1);
		
		
		resultPaths = "";
		linkId = "";
		$('#sortable1').find("li").each(function(){
			equalpos = $(this).children('a').attr('href').indexOf('=');
			temp = $(this).children('a').attr('href').substring(equalpos + 1) + ",";
			linkText = $(this).children('a').text()  + ",";
			pathpos = temp.lastIndexOf("\\");
			temp1 = temp.substring(0, pathpos - 1);
			resultPaths += temp1 + ",";
			temp2 = temp.substring(pathpos + 1);
			//console.log($(this).children('a'));
			//alert("Link Name "+linkText);
			resultNames += linkText;
			//alert(resultNames);
			linkId += $(this).children('a').attr('id')  + ",";
		});
		$('#sortable2').find("li").each(function(){
			equalpos = $(this).children('a').attr('href').indexOf('=');
			temp = $(this).children('a').attr('href').substring(equalpos + 1) + ",";
			linkText = $(this).children('a').text()  + ",";
			pathpos = temp.lastIndexOf("\\");
			temp1 = temp.substring(0, pathpos - 1);
			resultPaths += temp1 + ",";
			temp2 = temp.substring(pathpos + 1);
			resultNames += linkText;
			linkId += $(this).children('a').attr('id')  + ",";
		});
		//alert("88");
		result_len = resultPaths.length;
		resultPaths = jQuery.trim(resultPaths).substring(0, result_len - 1);
		//alert(resultPaths);
		result_len = resultNames.length;
		resultNames = jQuery.trim(resultNames).substring(0, result_len - 1);
		//alert(resultNames);
		result_len = linkId.length;
		linkId = jQuery.trim(linkId).substring(0, result_len - 1);
		//alert(linkId);
			
		var JSONObject = {
			//"names":resultNames,
			//"paths":resultPaths
			"ids":linkId
		};
		//console.log(JSONObject);
		$.ajax({
			type: "POST",
			url: "rep_sort_update.php",
			data: JSONObject,
			cache: false,
			async: false,
			success: function(data){
				//alert("DEBUG JSON sent to php!");
				//console.log(data);
			}
		});
		
		$('#reports_done').hide();
		$('#reports_cancel').hide();
		$('#reports_trash').hide();
		$('#reports_edit').show();
		$('#reports_add').show();
		$('#reports_rem').show();
		if(remflag == 0){
			$( "#sortable1" ).sortable("disable");
			$( "#sortable2" ).sortable("disable");
			initialdisableflag = 1;
		}
		remflag = 0;
		
		});
	
	$(".connectedSortable").each(function(){
		//alert(this.id);
		var $myanchors = $(this);
		
		if(this.id != "sortableTrash") {
			$myanchors.children().each(function(){
				//alert("DEBUG");
				//alert(this.id);
				//alert(this.children().href);
				//for (var member in this){
				//	alert(member);
				 // 	alert(this[member]);
				//}
				//alert(((this).innerHTML.search(".docx")));
				if(((this).innerHTML.search(".pdf")) > 0){
					//alert("DEBUG2");
					$(this).addClass("pdf");
				}else if(((this).innerHTML.search(".doc")) > 0){
					//alert("DEBUG2");
					$(this).addClass("doc");
				} else if(((this).innerHTML.search(".xls")) > 0){
					//alert("DEBUG2");
					$(this).addClass("xls");
				} else if(((this).innerHTML.search(".fld")) > 0){
					//alert("DEBUG2");
					$(this).addClass("fld");
				}
			});
		}
		
	});
	
	$("li a").click(function(event){
		if(remflag == 1){
			event.preventDefault();
			event.stopPropagation();
			result = confirm("Are you sure?");
			//alert(result);
			if(result == true){
				$(this).closest('li').remove();
			}
			else {
				//DO NOTHING
			}
		}
	});
	
});