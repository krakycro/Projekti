

const MOD0_PAD_TOP = 40;

// INICIJALIZACIJA + DEFS --------------------------------------------------------------------------


var Menu = SVG.append("g")
	.attr("class", "menu")
	.attr("transform","translate(10,10)");
	
var Bground = Menu.append("image")
	.attr("x",0)
	.attr("y",MOD0_PAD_TOP)
	.attr("width",70)
	.attr("height",330)
	.attr("xlink:href", IMG_DATA_PATH+"menu.png");
		
var Menu_centar = Menu.append("image")
	.attr("x",10)
	.attr("y",MOD0_PAD_TOP+10)
	.attr("width",50)
	.attr("height",50)
	.attr("xlink:href", IMG_DATA_PATH+"sunce.png")
	.on("mouseenter",function(){
		Menu_info.style("visibility","visible")
			.attr("transform","translate("+70+","+(MOD0_PAD_TOP+26)+")");
		Menu_info_txt.html("Mapa sustava");
	})
	.on("mouseleave",function(){
		Menu_info.style("visibility","hidden");
	})
	.on("click",function(){
		HideDisplay()
		mod2_switch = -1;
		if(g_viewMod != 11) g_viewMod = 11;
		Root.x = g_project.width_h;
		Root.y = g_project.height_h;
		Root.children.transition()
					.ease("linear")
					.duration(ORBIT_ANIM_MOVE/2)
					.attr("transform"," translate("+(Root.width)+","+(Root.height)+"),"+"scale("+(Root.scale)+") ")
					.each("start", function(){ Root.moving = true;});
	});

var Menu_vel = Menu.append("image")
	.attr("x",7)
	.attr("y",MOD0_PAD_TOP+40+35*1)
	.attr("width",25)
	.attr("height",25)
	.attr("xlink:href", IMG_DATA_PATH+"velicina.png")
	.on("mouseenter",function(){
		Menu_info.style("visibility","visible")
			.attr("transform","translate("+40+","+(MOD0_PAD_TOP+40+35*1)+")");
		Menu_info_txt.html("Polumjer(m)");
	})
	.on("mouseleave",function(){
		Menu_info.style("visibility","hidden");
	})
	.on("click",function(){
		if(mod2_switch != 1) {g_viewMod = 22;mod2_switch = 1;}
	});
	
var Menu_rot = Menu.append("image")
	.attr("x",7)
	.attr("y",MOD0_PAD_TOP+40+35*2)
	.attr("width",25)
	.attr("height",25)
	.attr("xlink:href", IMG_DATA_PATH+"rotacija.png")
	.on("mouseenter",function(){
		Menu_info.style("visibility","visible")
			.attr("transform","translate("+40+","+(MOD0_PAD_TOP+40+35*2)+")");
		Menu_info_txt.html("Rotacija(dani)");
	})
	.on("mouseleave",function(){
		Menu_info.style("visibility","hidden");
	})
	.on("click",function(){
		if(mod2_switch != 2) {g_viewMod = 22;mod2_switch = 2;}
		
	});
	
var Menu_kut = Menu.append("image")
	.attr("x",7)
	.attr("y",MOD0_PAD_TOP+40+35*3)
	.attr("width",25)
	.attr("height",25)
	.attr("xlink:href", IMG_DATA_PATH+"kut.png")
	.on("mouseenter",function(){
		Menu_info.style("visibility","visible")
			.attr("transform","translate("+40+","+(MOD0_PAD_TOP+40+35*3)+")");
		Menu_info_txt.html("Nagib(°)");
	})
	.on("mouseleave",function(){
		Menu_info.style("visibility","hidden");
	})
	.on("click",function(){
		if(mod2_switch != 3) {g_viewMod = 22;mod2_switch = 3;}
		
	});
	
var Menu_brz = Menu.append("image")
	.attr("x",7)
	.attr("y",MOD0_PAD_TOP+40+35*4)
	.attr("width",25)
	.attr("height",25)
	.attr("xlink:href", IMG_DATA_PATH+"brzina.png")
	.on("mouseenter",function(){
		Menu_info.style("visibility","visible")
			.attr("transform","translate("+40+","+(MOD0_PAD_TOP+40+35*4)+")");
		Menu_info_txt.html("Orbitala(dani)");
	})
	.on("mouseleave",function(){
		Menu_info.style("visibility","hidden");
	})
	.on("click",function(){
		if(mod2_switch != 4) {g_viewMod = 22;mod2_switch = 4;}
		
	});
	
var Menu_dist = Menu.append("image")
	.attr("x",7)
	.attr("y",MOD0_PAD_TOP+40+35*5)
	.attr("width",25)
	.attr("height",25)
	.attr("xlink:href", IMG_DATA_PATH+"udaljenost.png")
	.on("mouseenter",function(){
		Menu_info.style("visibility","visible")
			.attr("transform","translate("+40+","+(MOD0_PAD_TOP+40+35*5)+")");
		Menu_info_txt.html("Udaljenost(m)");
	})
	.on("mouseleave",function(){
		Menu_info.style("visibility","hidden");
	})
	.on("click",function(){
		if(mod2_switch != 5) {g_viewMod = 22;mod2_switch = 5;}
		
	});
	
var Menu_dist = Menu.append("image")
	.attr("x",7)
	.attr("y",MOD0_PAD_TOP+40+35*6)
	.attr("width",25)
	.attr("height",25)
	.attr("xlink:href", IMG_DATA_PATH+"temperatura.png")
	.on("mouseenter",function(){
		Menu_info.style("visibility","visible")
			.attr("transform","translate("+40+","+(MOD0_PAD_TOP+40+35*6)+")");
		Menu_info_txt.html("Temperatura(°C)");
	})
	.on("mouseleave",function(){
		Menu_info.style("visibility","hidden");
	})
	.on("click",function(){
		if(mod2_switch != 6) {g_viewMod = 22;mod2_switch = 6;}
		
	});
	
var Menu_dist = Menu.append("image")
	.attr("x",7)
	.attr("y",MOD0_PAD_TOP+40+35*7)
	.attr("width",25)
	.attr("height",25)
	.attr("xlink:href", IMG_DATA_PATH+"gravitacija.png")
	.on("mouseenter",function(){
		Menu_info.style("visibility","visible")
			.attr("transform","translate("+40+","+(MOD0_PAD_TOP+40+35*7)+")");
		Menu_info_txt.html("Gravitacija(m/s)");
	})
	.on("mouseleave",function(){
		Menu_info.style("visibility","hidden");
	})
	.on("click",function(){
		if(mod2_switch != 7) {g_viewMod = 22;mod2_switch = 7;}
		
	});
	

var Menu_info = Menu.append("g")
	.style("visibility","hidden")
	.attr("transform","translate("+70+","+36+")");
var Menu_info_box = Menu_info.append("rect")
	.attr("x",0)
	.attr("y",0)
	.attr("width",120)
	.attr("height",25)
	.attr("fill","rgb(86,115,136)")
	.attr("stroke", "black")
	.attr("stroke-width", 1);
var Menu_info_txt = Menu_info.append("text")
	.attr("x",10)
	.attr("y",18)
	.attr("fill","rgb(250,250,250)")
	.attr("font-size", "16px")
	.html("ovo je blank");
	
var Header = {};
Header.g = SVG.append("g")
	.attr("id", "header")
	.attr("transform","translate("+g_project.width_h+","+0+")");

Header.bg = Header.g.append("rect")
	.attr("x",-g_project.width_h)
	.attr("y",0)
	.attr("width",g_project.width)
	.attr("height",g_project.height)
	.attr("fill","rgba(0,0,0,1)");
Header.head_s = Header.g.append("text")
	.attr("x",0)
	.attr("y",g_project.height/3)
	.attr("fill","rgb(0,0,0)")
	.attr("font-size", "28px")
	.style("filter", "url(#shadow)")
	.attr("text-anchor","middle")
	.html("VIZUALIZACIJA SUNČEVOG SUSTAVA");
Header.head = Header.g.append("text")
	.attr("x",0)
	.attr("y",g_project.height/3)
	.attr("fill","rgba(250,250,250,0)")
	.attr("font-size", "28px")
	.attr("text-anchor","middle")
	.html("VIZUALIZACIJA SUNČEVOG SUSTAVA");
Header.by = Header.g.append("text")
	.attr("x",0)
	.attr("y",g_project.height/3+32)
	.attr("fill","rgba(250,250,250,0)")
	.attr("font-size", "20px")
	.attr("text-anchor","middle")
	.html("Izradio: Filip Kraus");	
Header.click = Header.g.append("text")
	.attr("x",0)
	.attr("y",g_project.height/3+32+44)
	.attr("fill","rgba(250,250,250,0)")
	.attr("font-size", "20px")
	.attr("text-anchor","middle")
	.html("UČITAVANJE");	
Header.clck = Header.g.append("rect")
	.attr("x",-g_project.width_h)
	.attr("y",0)
	.attr("width",g_project.width)
	.attr("height",g_project.height)
	.attr("fill","rgba(0,0,0,0)")
	.on("click",function(){
		if(g_allLoaded){
			g_viewMod = 11;
			Header.clck.remove();
			Header.bg.transition()
				.duration(MENU_ANIM_MOVE)
				.attr("fill","rgba(0,0,0,0)")
				.each("end", function(){ 
					Header.head.transition()
						.duration(MENU_ANIM_MOVE).attr("y", 32);
					Header.head_s.transition()
						.duration(MENU_ANIM_MOVE).attr("y", 32);
					Header.by.transition()
						.duration(MENU_ANIM_MOVE)
						.attr("fill","rgba(250,250,250,0)")
						.transition()
						.remove();
					Header.click.transition()
						.duration(MENU_ANIM_MOVE)
						.attr("fill","rgba(250,250,250,0)")
						.transition()
						.remove();
					Header.bg.remove();
			});
		}
		
	});
	
Header.head.transition()
	.duration(MENU_ANIM_MOVE).attr("fill","rgba(250,250,250,1)");
Header.by.transition()
	.duration(MENU_ANIM_MOVE).attr("fill","rgba(250,250,250,1)");
Header.click.transition()
	.duration(MENU_ANIM_MOVE).attr("fill","rgba(250,250,250,1)");
LoadIng();
	
	
// KOD ----------------------------------------------------------------------------------------

// FUNKCIJE -----------------------------------------------------------------------------------


function LoadIng(){
	if(!g_allLoaded)
		Header.click.transition()
		.duration(MENU_ANIM_MOVE/2)
		.attr("fill", "rgba(250,250,250,0)")
		.transition()
		.duration(MENU_ANIM_MOVE/2)
		.attr("fill", "rgba(250,250,250,1)")
		.each("end",LoadIng);
}

