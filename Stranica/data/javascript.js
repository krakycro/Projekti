$(document).ready(function(){
	$("#gback").hide(0);
	$(":text,:password").css("background-color","#FFFAAA");
	$("#logz").animate({left: $("#top").position().left+750},0);
	$("#hover").animate({left: $("#side").position().left+2},0);
	$("ul > li").mouseenter(function(){
		$("ul > li:hover > ul").slideDown(100);
		$(".row").mouseleave(	function(){
			$("ul ul").slideUp(100);
			});
		$(".row1").mouseleave(	function(){
			$("ul ul ul").hide(100);
			});
		});
	$(":text,:password").focus(function(){
		$(this).css("background-color","#CCCCFF");
		});
	$(":text,:password").blur(function(){
		$(this).css("background-color","#FFFAAA");
		});
	});
$(window).resize(function(){
	//alert($("#top").position().left);
	$("#hover").animate({left: $("#side").position().left+2},0);
	$("#logz").animate({left: $("#top").position().left+750},0);
	});
$(document).scroll(function(){
	if($(this).scrollTop() > $("#hover").position().top){
		$("#hover").animate({top: $(this).scrollTop()},10);
		}
	if($(this).scrollTop() < $("#hover").position().top){
		$("#hover").animate({top: $(this).scrollTop()},10);
		}
	});
$(document).scroll(function(){
	if($(this).scrollTop() > 200 ) {$("#gback").slideDown(100);}
	else {$("#gback").slideUp(100);}
	});
	
function LogIn(forma){
	var string = document.forms[forma];
	var t = true;
	if(string["nick"].value.length > 30 || string["nick"].value.length < 4 || RegExp("[^a-z^A-Z^0-9/g]").test(string["nick"].value)) {
		$(":text[name^='nick']").css("background-color","#FF5555");
		$("#err").html("<b>User: 4-30 znakova: a-z, A-Z, 0-9</b>");
		t = false;
		}
	if(string["passwrd"].value.length > 16 || string["passwrd"].value.length < 4 || RegExp("[^a-z^A-Z^0-9/g]").test(string["passwrd"].value)) {
		$(":password[name^='passwrd']").css("background-color","#FF5555");
		if(!t) $("#err").html("<b>User i Password: 4-16 znakova: a-z, A-Z, 0-9</b>");
		else $("#err").html("<b>Password: 4-16 znakova: a-z, A-Z, 0-9</b>");
		t = false;
		}	
	return t;
	}

		
function isTaken(form,object){
	var string = document.forms[form];
	for(var i=0;i<string.length;i++){
		if(string[i].name == $(object).val()){
			return 1;
			break;
			}}
	return 0;
	}		
	
function readURL(input,string,src) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(string).attr('src', e.target.result);
                    slikaSize = e.target.result.length;
                }

                reader.readAsDataURL(input.files[0]);
            }
            else if(string.length > 0 && src.lenght > 0 )$(string).attr('src', src);

        }
