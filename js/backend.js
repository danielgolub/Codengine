/*
 * Codengine
 * FilePath: js/backend.js
 * Author: Daniel Golub - www.DanielGolub.com
*/

$(document).ready(function(){
	var position = 0;
	window.setInterval(function(){
		position = position + 0.5;
		$("header").css("background-position",position+"px 100%");
		$("footer").css("background-position",position+"px 0%");
	}, 13);
	var intro_text = [
		"startups",
		"small business",
		"medium business",
		"developers",
	];
	var i = 1;
	window.setInterval(function(){
		$("#intro span").text(intro_text[i]);
		i++;
		if(i >= intro_text.length)
			i = 0;
	}, 3000);
	$(".profile-item:nth-child(2)").css("margin-left","0px");
});