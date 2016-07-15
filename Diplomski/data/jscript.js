var sheight = $(document).scrollTop();
function calculate(INF,IN,OUT){
	sheight = $(document).scrollTop();
	$.get("data/calculator.php",{xypos: INF, input: $(IN).val(), box: "dropbox", style: "inbox"},function(data){
		if(data != "NULL") 
			$(OUT).html(data);
		$("#xybox").hide();
		var info = $("#grafsxy").val().split(",");
		$(document).on('mousemove', function(e){ 
			var tempx = e.pageX-$("#grafimg").position().left+(Number(info[1]));
			var tempy = (Number(info[2]))-(e.pageY-$("#grafimg").position().top);
			tempx /= Number(info[0]);
			tempy /= Number(info[0]);
    		$('#xybox').css({
       		left:  e.pageX+5,
       		top:   e.pageY+10
    		});
    		$('#xybox').html("x:"+tempx.toFixed(2)+", y:"+tempy.toFixed(2));
		});
		$("#grafimg").mouseenter(function(){
			$("#xybox").show();
		});
		$("#grafimg").mouseleave(function(){
			$("#xybox").hide();
		});
		$("#grafimg").load(function () {
  			$(document).scrollTop(sheight);
		});
		});
	}
hide = 1;
$(document).ready(function(){
	$("#helpbox").hide(); 
	$("#helpbutton").mouseup(function(){
		if(hide) { hide = 0; $("#helpbox").show();}
		else { hide= 1; $("#helpbox").hide();}
		});
	});
   