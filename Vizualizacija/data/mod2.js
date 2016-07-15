// KONSTANTE --------------------------------------------------------------------------


// GLOB VARIJABLE --------------------------------------------------------------------------

const MOD2_PLANET_SIZE = 100;
const MOD2_PADDING_DOWN = g_project.height-MOD2_PLANET_SIZE*1.5;
const MOD2_PADDING_LEFT = MOD2_PLANET_SIZE*1.8;
const MOD2_PADDING_UP = 100;

const MOD2_SKALA = 10;

// DEFINICIJE --------------------------------------------------------------------------

var mod2_switch = -1;

var mod2_text = "";
var mod2_zoom = 1;
var mod2_zoom_old = 1;
var mod2_scale = 100;
var mod2_color = "250,0,0,1";
var mod2_neg = false;


// INICIJALIZACIJA + DEFS --------------------------------------------------------------------------

var Display = SVG.append("g")
	.attr("class", "display")
	.style("visibility","hidden")
	.call(globDrag)
	.call(globZoom);
Display.rect = Display.append("rect")
	.attr("x",0)
	.attr("y",0)
	.attr("width",g_project.width)
	.attr("height",g_project.height)
	.attr("fill", "rgba(40,40,40,0)")
	.attr("stroke","gray")
	.attr("stroke-width",2);
	
Display.root_x = MOD2_PADDING_LEFT;
Display.root_y = MOD2_PADDING_DOWN;
Display.root_grid = Display.append("g")
	.attr("class", "display_grid")
	.attr("transform","translate("+(MOD2_PADDING_LEFT)+","+(Display.root_y)+")");
Display.root_coord = Display.append("g")
	.attr("class", "display_coord")
	.attr("transform","translate("+(Display.root_x)+","+(Display.root_y)+")");
		
for(i = 1; i <= MOD2_SKALA; i++){
	Display.root_grid.append("rect")
		.attr("x",0)
		.attr("y",-(MOD2_PADDING_DOWN-MOD2_PADDING_UP)/(MOD2_SKALA)*i)
		.attr("width",g_project.width)
		.attr("height",1)
		.attr("fill", "none")
		.attr("stroke","gray")
		.attr("stroke-width",1);
}
for(i = 0; i < MOD2_SKALA; i++){
	var g = Display.root_grid.append("rect")
		.attr("x",0)
		.attr("y",(MOD2_PADDING_DOWN-MOD2_PADDING_UP)/(MOD2_SKALA)*i)
		.attr("width",g_project.width)
		.attr("height",1)
		.attr("fill", "none")
		.attr("stroke","gray")
		.attr("stroke-width",1);
	if(i == 0) g.attr("stroke","white");
}
Display.rect_side = Display.append("rect")
	.attr("x",0)
	.attr("y",MOD2_PADDING_UP-5)
	.attr("width",MOD2_PADDING_LEFT)
	.attr("height",MOD2_PADDING_DOWN-MOD2_PADDING_UP+5)
	.attr("fill", "rgba(40,40,40,0)");
Display.root_skale = Display.append("g")
	.attr("class", "display_scale")
	.attr("transform","translate("+(MOD2_PADDING_LEFT)+","+(Display.root_y)+")");
	
Display.text_numbers = [];	
for(i = 1; i <= MOD2_SKALA; i++){
	Display.root_skale.append("rect")
		.attr("x",-8)
		.attr("y",-(MOD2_PADDING_DOWN-MOD2_PADDING_UP)/(MOD2_SKALA)*i)
		.attr("width",8)
		.attr("height",1)
		.attr("fill", "none")
		.attr("stroke","white")
		.attr("stroke-width",1);
	var tmp = Display.root_skale.append("text")
		.attr("x",-15)
		.attr("y", 10  - (MOD2_PADDING_DOWN-MOD2_PADDING_UP)/(MOD2_SKALA)*i)
		.attr("fill","rgba(255,255,255,1)")
		.attr("font-size", "16px")
		.attr("text-anchor","end")
		.html(Math.pow(10,i));
	Display.text_numbers.push(tmp);
}
for(i = 0; i < MOD2_SKALA; i++){
	Display.root_skale.append("rect")
		.attr("x",-8)
		.attr("y",(MOD2_PADDING_DOWN-MOD2_PADDING_UP)/(MOD2_SKALA)*i)
		.attr("width",8)
		.attr("height",1)
		.attr("fill", "none")
		.attr("stroke","white")
		.attr("stroke-width",1);
	var tmp = Display.root_skale.append("text")
		.attr("x",-15)
		.attr("y",10+(MOD2_PADDING_DOWN-MOD2_PADDING_UP)/(MOD2_SKALA)*i)
		.attr("fill","rgba(255,255,255,1)")
		.attr("font-size", "16px")
		.attr("text-anchor","end")
		.html(Math.pow(10,i));
		
	Display.text_numbers.push(tmp);
}
	
Display.rect_down = Display.append("rect")
	.attr("x",0)
	.attr("y",MOD2_PADDING_DOWN)
	.attr("width",g_project.width)
	.attr("height",MOD2_PLANET_SIZE*1.5)
	.attr("fill", "rgba(40,40,40,0)");
Display.root = Display.append("g")
	.attr("class", "display_root")
	.attr("transform","translate("+(Display.root_x)+","+(MOD2_PADDING_DOWN)+")");
Display.down_line = Display.append("rect")
	.attr("x",0)
	.attr("y",MOD2_PADDING_DOWN)
	.attr("width",g_project.width)
	.attr("height",1)
	.attr("fill", "none")
	.attr("stroke","white")
	.attr("stroke-width",1);

Display.text = Display.append("text")
		.attr("x",0)
		.attr("y",0)
		.attr("fill","rgba(255,255,255,1)")
		.attr("font-size", "18px")
		.attr("text-anchor","middle")
		.attr("transform","translate("+(MOD2_PADDING_LEFT/2-10)+","+MOD2_PADDING_DOWN/2+") rotate(-90)")
		.html("");
		
Display.rect_top = Display.append("rect")
	.attr("x",0)
	.attr("y",0)
	.attr("width",g_project.width)
	.attr("height",MOD2_PADDING_UP-5)
	.attr("fill", "rgba(40,40,40,0)");
		

Display.up_line = Display.append("rect")
	.attr("x", MOD2_PADDING_LEFT)
	.attr("y", MOD2_PADDING_UP)
	.attr("width",1)
	.attr("height",MOD2_PADDING_DOWN-MOD2_PADDING_UP)
	.attr("fill", "none")
	.attr("stroke","white")
	.attr("stroke-width",1);

	
// KOD --------------------------------------------------------------------------


	
// FUNKCIJE --------------------------------------------------------------------------

function ShowDisplay(){
	Display.root.attr("transform","translate("+(MOD2_PADDING_LEFT)+","+(MOD2_PADDING_DOWN)+")");
	Display.style("visibility","visible");
	Display.rect.transition()
		.duration(MENU_ANIM_MOVE/2)
		.attr("fill","rgba(40,40,40,1)");
	Display.rect_side.transition()
		.duration(MENU_ANIM_MOVE/2)
		.attr("fill","rgba(40,40,40,1)");
	Display.rect_top.transition()
		.duration(MENU_ANIM_MOVE/2)
		.attr("fill","rgba(40,40,40,1)");
	Display.rect_down.transition()
		.duration(MENU_ANIM_MOVE/2)
		.attr("fill","rgba(40,40,40,1)");
}

function HideDisplay(){
	Display.rect_down.transition()
		.duration(MENU_ANIM_MOVE/2)
		.attr("fill","rgba(40,40,40,0)");
	Display.rect_top.transition()
		.duration(MENU_ANIM_MOVE/2)
		.attr("fill","rgba(40,40,40,0)");
	Display.rect_side.transition()
		.duration(MENU_ANIM_MOVE/2)
		.attr("fill","rgba(40,40,40,0)");
	Display.rect.transition()
		.duration(MENU_ANIM_MOVE/2)
		.attr("fill","rgba(40,40,40,0)")
		.each("end", function(){ 
			Display.style("visibility","hidden");
		});
}


function TimerMod2(elapsed){
	
	for(dd in Display.data){
		
		if(Display.data[dd].values.rotacija !=0) Display.data[dd].box.rotate.y += ORBIT_ROT_SCALE/Display.data[dd].values.rotacija*5;
		if(Display.data[dd].box.rotate.y > 0) Display.data[dd].box.rotate.y = -ORBIT_ROT_CICLE;
		if(Display.data[dd].const.slika && Display.data[dd].const.slika.length > 1) Display.data[dd].values.picture.attr("x",Display.data[dd].box.rotate.y);
	
	}
}

function TimerMod22(elapsed){
	
	globZoom.scale(1);
	mod2_zoom = 1;
	mod2_zoom_old = 1;
	Display.root.selectAll(".removable").remove();
	Display.root_grid.selectAll(".removable").remove();
	Display.root_skale.selectAll(".removable").remove();
	Display.root_coord.selectAll(".removable").remove();
	Display.data = [];
	Root.children.selectAll("g").each(AddChildrenMod2);
	InitMod2(Display.data[0]);
	
	for(dd in Display.data){
		
		Display.root.append("rect")
			.attr("class","removable")
			.attr("x",MOD2_PLANET_SIZE/2+(MOD2_PLANET_SIZE*dd*1.1))
			.attr("y",0)
			.attr("width",1)
			.attr("height",10)
			.attr("fill", "none")
			.attr("stroke","white")
			.attr("stroke-width",1);
		
		Display.root.append("text")
			.attr("class","removable")
			.attr("x",MOD2_PLANET_SIZE/2+(MOD2_PLANET_SIZE*dd*1.1))
			.attr("y",30)
			.attr("fill","rgba(255,255,255,1)")
			.attr("font-size", "18px")
			.attr("text-anchor","middle")
			.html(Display.data[dd].name);
		
		Display.data[dd].oHeight = SelectorMod2(Display.data[dd]) / mod2_scale;
		
		console.log("o-"+dd);
		var oNnumber = SelectorMod2(Display.data[dd]).toFixed(2);
		if(Math.abs(Number(oNnumber)) > 100000) oNnumber = Number(oNnumber).toExponential(4);
		
		Display.data[dd].oInfo = Display.root_coord.append("text")
			.attr("class","removable")
			.attr("x",MOD2_PLANET_SIZE/2+(MOD2_PLANET_SIZE*dd*1.1))
			.attr("fill","rgba(255,255,255,0)")
			.attr("font-size", "18px")
			.attr("text-anchor","middle")
			.html(oNnumber);
		
		Display.data[dd].oScale = Display.root_coord.append("rect")
			.attr("class","removable")
			.attr("x",MOD2_PLANET_SIZE/4+(MOD2_PLANET_SIZE*dd*1.1))
			.attr("width",MOD2_PLANET_SIZE/2)
			.style("filter", "url(#shadow)")
			.attr("fill","rgba("+mod2_color+")")
			.attr("onmouseenter", "PokaziMod1("+dd+")")
			.attr("onmouseleave", "SakriMod1("+dd+")");
		
		ScalePosition(dd);
				
		var sphere = Display.root.append("circle")
			.attr("id","dis-"+Display.data[dd].name)
			.attr("class","removable")
			.attr("cx",MOD2_PLANET_SIZE/2+(MOD2_PLANET_SIZE*dd*1.1))
			.attr("cy",MOD2_PLANET_SIZE*0.9)
			.attr("fill","rgba("+Display.data[dd].box.bgcolor.r+","+Display.data[dd].box.bgcolor.g+","+Display.data[dd].box.bgcolor.b+","+Display.data[dd].box.bgcolor.a+")")
			.attr("stroke","rgba(0,0,0,1)")
			.attr("stroke-width",2);
			
		if(Display.data[dd].const.slika && Display.data[dd].const.slika.length > 1)
			sphere.attr("fill","url(#"+Display.data[dd].name+"-slika)");
			
		var shader = Display.root.append("circle")
			.attr("class","removable")
			.attr("cx",MOD2_PLANET_SIZE/2+(MOD2_PLANET_SIZE*dd*1.1))
			.attr("cy",MOD2_PLANET_SIZE*0.9)
			.style("stroke","none");
		
		if(!Display.data[dd].class.localeCompare("zvijezda")){
			sphere.attr("r", MOD2_PLANET_SIZE/2);
			shader.attr("r",MOD2_PLANET_SIZE)
				.style("fill","url(#starGlow)");
		}
			
		if(!Display.data[dd].class.localeCompare("planet")){
			sphere.attr("r", MOD2_PLANET_SIZE/2*0.6);
			shader.attr("r",MOD2_PLANET_SIZE/2*0.6)
				.style("fill","url(#planetShadow)");
		}
			
		if(!Display.data[dd].class.localeCompare("satelit")){
			sphere.attr("r", MOD2_PLANET_SIZE/2*0.4);
			shader.attr("r",MOD2_PLANET_SIZE/2*0.41)
				.style("fill","url(#planetShadow)");
		}
		
		
	}
	
	ShowDisplay();
	console.log("change");
	g_viewMod = 2;
	
}

function PokaziMod1(dd){
				console.log("i1-"+dd);
				Display.data[dd].oInfo.transition()
					.duration(MENU_ANIM_MOVE/3)
					.attr("fill","rgba(255,255,255,1)");
}

function SakriMod1(dd){
				console.log("i2-"+dd);
				Display.data[dd].oInfo.transition()
					.duration(MENU_ANIM_MOVE/3)
					.attr("fill","rgba(255,255,255,0)");
}

function InitMod2(dd){
	
	switch(mod2_switch){
		case 1: 
			Display.text.html("Polumjer(m)");
			mod2_text = "";
			mod2_scale = dd.values.velicina;
			mod2_color = "100,100,250,0.7";
		break;
		case 2: 
			Display.text.html("Rotacija(dani)");
			mod2_text = "";
			mod2_scale = dd.values.rotacija;
			mod2_color = "120,250,120,0.7";
		break;
		case 3: 
			Display.text.html("Nagib(°)");
			mod2_text = "°";
			mod2_scale = dd.values.kut;
			mod2_color = "80,200,140,0.7";
		break;
		case 4:
			Display.text.html("Orbitala(dani)");
			mod2_text = "";
			mod2_scale = Math.abs(dd.values.brzina);
			mod2_color = "50,150,150,0.7";
		break;
		case 5: 
			Display.text.html("Udaljenost(m)");
			mod2_text = "";
			mod2_scale = dd.values.tRad;
			mod2_color = "120,150,160,0.7";
		break;
		case 6: 
			Display.text.html("Temperatura(°C)");
			mod2_text = "°";
			mod2_scale = dd.values.temperatura;
			mod2_color = "250,120,100,0.7";
		break;
		case 7: 
			Display.text.html("Gravitacija(m/s)");
			mod2_text = "";
			mod2_scale = dd.values.gravitacija;
			mod2_color = "250,100,50,0.7";
		break;
	}
	
	SkalaMake();
	
}

function SelectorMod2(dd){
	
	
	switch(mod2_switch){
		case 1: return dd.values.velicina;
		case 2: return dd.values.rotacija;
		case 3: return dd.values.kut;
		case 4: return -dd.values.brzina;
		case 5: return dd.values.tRad;
		case 6: return dd.values.temperatura;
		case 7: return dd.values.gravitacija;
	}
	
}

function SkalaMake(){
	
	var tt = mod2_scale/MOD2_SKALA;
	
	for(dd in Display.text_numbers){
		if(dd < MOD2_SKALA )
			number = (tt*(Number(dd)+1) / mod2_zoom).toFixed(2);
		if(dd == MOD2_SKALA )
			number = 0;
		if(dd > MOD2_SKALA )
			number = (tt*(MOD2_SKALA-Number(dd)) / mod2_zoom).toFixed(2);
		if(Math.abs(Number(number)) > 100000) number = Number(number).toExponential(4);
		
		Display.text_numbers[Number(dd)].html(number+mod2_text);
	}
}

function ScalePosition(dd){
	if(Display.data[dd].oHeight > 0){
		Display.data[dd].oScale
			.attr("y",-(MOD2_PADDING_DOWN-MOD2_PADDING_UP)*Display.data[dd].oHeight * mod2_zoom)
			.attr("height",(MOD2_PADDING_DOWN-MOD2_PADDING_UP)*Display.data[dd].oHeight * mod2_zoom);
		Display.data[dd].oInfo
			.attr("y",- 2 -(MOD2_PADDING_DOWN-MOD2_PADDING_UP)*Display.data[dd].oHeight * mod2_zoom);
		}
	else {
		Display.data[dd].oScale
			.attr("y",0)
			.attr("height",Math.abs((MOD2_PADDING_DOWN-MOD2_PADDING_UP)*Display.data[dd].oHeight * mod2_zoom));
		Display.data[dd].oInfo.attr("y",Math.abs((MOD2_PADDING_DOWN-MOD2_PADDING_UP)*Display.data[dd].oHeight * mod2_zoom)+20);
	}
}


function AddChildrenMod2(dd){
	var i = 0;
	
	for(; i < Display.data.length; i++){
		if(Math.abs(SelectorMod2(Display.data[i])) < Math.abs(SelectorMod2(dd))){
			Display.data.splice(i, 0, dd);
			break;
		}
	}
	if(i == Display.data.length) Display.data.push(dd);
	

	//dd.values.this.selectAll("g").each(AddChildrenMod2);
}

function MicanjeMod2(){
	
	Display.root_x += d3.event.dx;
	if(Display.root_x < -MOD2_PLANET_SIZE*(Display.data.length+1)+g_project.width-MOD2_PADDING_LEFT)
		Display.root_x = -MOD2_PLANET_SIZE*(Display.data.length+1)+g_project.width-MOD2_PADDING_LEFT;
	if(Display.root_x > MOD2_PADDING_LEFT)
		Display.root_x = MOD2_PADDING_LEFT;
	Display.root_y += d3.event.dy;
	if(Display.root_y < MOD2_PADDING_UP)
		Display.root_y = MOD2_PADDING_UP;
	if(Display.root_y > MOD2_PADDING_DOWN)
		Display.root_y = MOD2_PADDING_DOWN;
	
	
	Display.root_coord.attr("transform","translate("+(Display.root_x)+","+(Display.root_y)+")");
	Display.root_grid.attr("transform","translate("+(MOD2_PADDING_LEFT)+","+(Display.root_y)+")");
	Display.root_skale.attr("transform","translate("+(MOD2_PADDING_LEFT)+","+(Display.root_y)+")");
	Display.root.attr("transform","translate("+(Display.root_x)+","+(MOD2_PADDING_DOWN)+")");
	
}

function ZoomMod2(){
	
	if(mod2_zoom_old > d3.event.scale+0.1)
		mod2_zoom-=1;
	if(mod2_zoom_old < d3.event.scale-0.1)
		mod2_zoom+=1;
	mod2_zoom_old = d3.event.scale;
	
	for(dd in Display.data){
		ScalePosition(dd);
	}
	SkalaMake();
	
}