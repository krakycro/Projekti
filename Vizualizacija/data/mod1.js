// KONSTANTE --------------------------------------------------------------------------


const INFO_H = 10+18*11;
const INFO_W = 200;

const INFO_X = g_project.width-INFO_W-50;
const INFO_Y = 100;

const MOD1_PADDING_DOWN = 20;

// GLOB VARIJABLE --------------------------------------------------------------------------

var sliderVel = {id:"s-0", progress:0.9, text:"Veličina (cm)", inv : true, extra: 1.3, min: 0, max: ORBIT_SIZE_SCALE*26.4583, val: "cm", zoom: true};	
var sliderDist = {id:"s-1", progress:0.9, text:"Udaljenost (cm)", inv : false, extra: 0.07, min: ORBIT_DIST_SCALE*26.4583, max: ORBIT_DIST_SCALE*264.583, val: "cm", zoom: true};	
var sliderTime = {id:"s-2", progress:0, text:"Vrijeme (sec)", inv : false, extra: 0, min: 0, max: ORBIT_ZOOM_SCALE*432000, val: "s", zoom: false};	

var Info = {};

// DEFINICIJE --------------------------------------------------------------------------

var starsData = d3.range(BR_ZVIJEZDA)
	.map(function() { return {x: Math.random()*g_project.width, y: Math.random()*g_project.height}; });

	
// KOD --------------------------------------------------------------------------

	
var Stars = SVG.append("g")
	.attr("class","Stars")
	.attr("transform","translate("+g_project.width_h+","+g_project.height_h+")")
	.selectAll("rect")
	.data(starsData)
	.enter()
	.append("rect")
	.attr("x",function(d){return d.x-g_project.width_h;})
	.attr("y",function(d){return d.y-g_project.height_h;})
	.attr("width",1)
	.attr("height",1)
	.attr("fill", function(d){ var r= Math.floor(Math.random()*96)+160; return "rgba("+r+","+r+",255,"+(Math.random()*0.8+0.2)+")";});

Root.children = SVG.append("g")
	.attr("id","Root")
	.attr("transform","translate("+(Root.x)+","+(Root.y)+"), scale("+(Root.scale)+")")
	.call(globDrag)
	.call(globZoom);
Root.children.selectAll("g")
	.data(g_data)
	.enter()
	.append("g")
	.each(function(d){AddChildrenMod1(d3.select(this),d,null);});
	
Slider(MOD1_PADDING_DOWN,g_project.height-MOD1_PADDING_DOWN,g_project.width/3.5, sliderTime);
Slider(g_project.width/3+MOD1_PADDING_DOWN,g_project.height-MOD1_PADDING_DOWN,g_project.width/3.5, sliderVel);
Slider(g_project.width/3*2+MOD1_PADDING_DOWN,g_project.height-MOD1_PADDING_DOWN,g_project.width/3.5, sliderDist);

Infer(Info);	


	
// FUNKCIJE --------------------------------------------------------------------------

function Infer(info){
	
var dragg = d3.behavior.drag();
info.x = INFO_X;
info.y = INFO_Y;
info.dragging = false;
info.dy = 0;
info.dy = 0;
info.g = SVG.append("g")
	.attr("id","info")
	.attr("transform","translate(10,20)")
	.style("visibility", "hidden")
	//.attr("transform","translate("+(g_project.width_h-INFO_W/2+20)+","+(g_project.height_h-INFO_H/2)+")")
	;
info.move_rect = info.g.append("rect")
	.attr("class", "info_move_rect")
	.attr("x",0)
	.attr("y",-20)
	.attr("width",INFO_W)
	.attr("height",20)
	.attr("fill", "rgba(40,40,40,1)")
	.attr("stroke", "black")
	.attr("stroke-width", 2)
	.on("mouseenter", function(){
		info.move_rect.attr("fill", "rgba(60,60,60,1)");
		info.move_rect.attr("stroke-width", 3)
	})
	.on("mouseleave", function(){
		info.move_rect.attr("fill", "rgba(40,40,40,1)");
		info.move_rect.attr("stroke-width", 2)
	})
	.call(dragg);
info.rect = info.g.append("rect")
	.attr("x",0)
	.attr("y",0)
	.attr("width",INFO_W)
	.attr("height",INFO_H)
	.attr("fill", "rgba(60,60,60,0.8)")
	.attr("stroke", "black")
	.attr("stroke-width", 1);
info.tName = info.g.append("text")
		.attr("x",INFO_W/4)
		.attr("y",17)
		.attr("fill","white")
		.attr("font-size", "16px")
		.attr("text-anchor","left");
info.tTip = info.g.append("text")
		.attr("x",10)
		.attr("y",17+15*1)
		.attr("fill","rgb(230,230,10)")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
info.tInfo = info.g.append("text")
		.attr("x",10)
		.attr("y",17+15*2)
		.attr("fill","yellow")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
info.tVel = info.g.append("text")
		.attr("x",15)
		.attr("y",17+15*3)
		.attr("fill","lightblue")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
info.tPel = info.g.append("text")
		.attr("x",15)
		.attr("y",17+15*4)
		.attr("fill","lightgray")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
info.tApel = info.g.append("text")
		.attr("x",15)
		.attr("y",17+15*5)
		.attr("fill","lightgray")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
info.tKut = info.g.append("text")
		.attr("x",15)
		.attr("y",17+15*6)
		.attr("fill","rgb(100,200,100)")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
info.tRot = info.g.append("text")
		.attr("x",15)
		.attr("y",17+15*7)
		.attr("fill","rgb(120,250,120)")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
info.tSat = info.g.append("text")
		.attr("x",15)
		.attr("y",17+15*8)
		.attr("fill","rgb(200,200,100)")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
info.tPov = info.g.append("text")
		.attr("x",15)
		.attr("y",17+15*9)
		.attr("fill","rgb(200,200,100)")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
info.tTemp = info.g.append("text")
		.attr("x",15)
		.attr("y",17+15*10)
		.attr("fill","rgb(250,120,100)")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
info.tGrav = info.g.append("text")
		.attr("x",15)
		.attr("y",17+15*11)
		.attr("fill","orange")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
dragg.on("dragstart",function(d){
				info.dragging = true;
		})
		.on("drag",function(d){
				if(info.dragging){
					info.dx =  - d3.event.x;
					info.dy =  - d3.event.y;
					info.dragging = false;
					}
				info.x += d3.event.x + info.dx;
				info.y += d3.event.y + info.dy;
				info.g.attr("transform","translate("+(info.x)+","+(info.y)+")");
		});
}

function Slider(x,y,w,out){
	var stroke_out = 3;
	var stroke_in = 5;
	var ww = w-72;
	
	//out.progress = 0;
	var line = d3.svg.line()
		.x(function(d){ return d.x;})
		.y(function(d){ return d.y;})
		.interpolate("linear");;
	var dragging = d3.behavior.drag();
	var sl = SVG.append("g")
		.attr("class","slider")
		.attr("id",out.id)
		.attr("transform","translate("+x+","+y+")");
	sl.append("rect")
		.attr("x",0)
		.attr("y",0)
		.attr("width",ww)
		.attr("height",stroke_in*4)
		.attr("fill","rgba(0,0,0,0)")
		.on("click", function(d){
			out.progress = (d3.event.x-x)/(ww);
			if(out.progress < 0.01) out.progress = 0;
			if(out.progress > 1) out.progress = 1;
			crcl.attr("cx",d3.event.x-x);
			ScaleUpdate(out);
		})
		.on("mouseenter", function(d){
			path.attr("stroke-width", stroke_in);
		})
		.on("mouseleave", function(d){
			path.attr("stroke-width", stroke_out);
		});
	sl.append("text")
		.attr("x",0)
		.attr("y",0)
		.attr("fill","white")
		.attr("font-size", "12px")
		.attr("text-anchor","left")
		.html(out.text+":");
	sl.append("image")
		.attr("x", ww+5)
		.attr("y", -5)
		.attr("width",72)
		.attr("height", 24)
		.attr("xlink:href",IMG_DATA_PATH+"metric.png");
	out.scale = sl.append("text")
		.attr("x", ww+10)
		.attr("y",2)
		.attr("fill","white")
		.attr("font-size", "12px")
		.attr("text-anchor","left");
	ScaleUpdate(out);
	var path = sl.append("path")
		.attr("stroke", "darkgray")
		.attr("stroke-width", stroke_out)
		.attr("fill", "none")
		.attr("d",line([ { "x": 0,   "y": 10}, { "x": ww,  "y": 10}]))
		.on("click", function(d){
			out.progress = (d3.event.x-x)/(ww);
			if(out.progress < 0.01) out.progress = 0;
			if(out.progress > 1) out.progress = 1;
			crcl.attr("cx",d3.event.x-x);
			ScaleUpdate(out);
		})
		.on("mouseenter", function(d){
			path.attr("stroke-width", stroke_in);
		})
		.on("mouseleave", function(d){
			path.attr("stroke-width", stroke_out);
		});
	var crcl = sl.append("circle")
		.attr("r", stroke_out*2)
		.attr("cx", out.progress*ww)
		.attr("cy",10)
		.attr("fill","rgb(50,50,50)")
		.attr("stroke", "rgba(50,50,50,0.5)")
		.attr("stroke-width", stroke_out)
		.on("mouseenter", function(d){
			crcl.attr("stroke-width", stroke_in);
			crcl.attr("fill","rgb(200,80,80)")
		})
		.on("mouseleave", function(d){
			crcl.attr("stroke-width", stroke_out);
			crcl.attr("fill","rgb(50,50,50)")
		})
		.call(dragging);
	dragging.on("drag",function(d){
			if(d3.event.x> 0 && d3.event.x < ww){
				out.progress = (d3.event.x)/(ww);
				if(out.progress < 0.01) out.progress = 0;
				if(out.progress > 1) out.progress = 1;
				crcl.attr("cx",d3.event.x);
				ScaleUpdate(out);
			}
		});
}

function ScaleUpdate(out){
	if(out.inv)
		if(out.zoom)
			out.scale.html("1:"+ ((out.min + out.max * (out.extra-out.progress))/Root.scale).toExponential(2)+ " "+out.val);
		else out.scale.html("1:"+ ((out.min + out.max * (out.extra-out.progress))).toExponential(2)+ " "+out.val);
	else 
		if(out.zoom)
			out.scale.html("1:"+ ((out.min + out.max * (out.extra+out.progress))/Root.scale).toExponential(2)+ " "+out.val);
		else out.scale.html("1:"+ ((out.min + out.max * (out.extra+out.progress))).toExponential(2)+ " "+out.val);
}


function AddChildrenMod1(t, dd, parent){

	dd.values.this = t;//d3.select(this);
	dd.values.parent = d3.select("#obj-"+dd.parent);
	dd.values.back = parent;
	//if(!dd.name && !dd.name.length > 1) dd.name = "UKNOWN";
	//if(!dd.class && !dd.class.length > 1) dd.class = "satelite";
	if(parent == null) dd.values.back = {"values": {"tCent": 0}, "box": {"translate": {"x": 0}, "rotate": {"x": 0}}};
	dd.values.aphelion = parseFloat(dd.const.aphelion);
	//if(!dd.values.aphelion && !dd.aphelion.length > 1) return;
	dd.values.perihelion = parseFloat(dd.const.perihelion);
	//if(!dd.values.perihelion && !dd.perihelion.length > 1) return;
	dd.values.velicina = parseFloat(dd.const.velicina);
	//if(!dd.values.velicina && !dd.velicina.length > 1) return;
	dd.values.brzina = parseFloat(dd.const.brzina);
	if(!dd.const.brzina_inv)
		dd.values.brzina *= -1;
	//if(!dd.values.brzina && !dd.brzina.length > 1) return;
	dd.values.rotacija = parseFloat(dd.const.rotacija);
	//if(!dd.values.rotacija && !dd.rotacija.length > 1) dd.values.rotacija = 0;
	dd.values.kut = parseFloat(dd.const.kut);
	//if(!dd.values.kut && !dd.kut.length > 1) dd.values.kut = 0;
	dd.values.povrsina = parseFloat(dd.const.povrsina);
	dd.values.temperatura = parseFloat(dd.const.temperatura)- 273.15;
	dd.values.gravitacija = parseFloat(dd.const.gravitacija);
	dd.values.tRad = (dd.values.aphelion+dd.values.perihelion)/2;
	dd.values.tDist = dd.values.tRad/g_project.dist_scale;
	dd.values.tCent = (dd.values.tDist-(dd.values.aphelion/g_project.dist_scale));
	dd.values.tVel = (dd.values.velicina)/g_project.size_scale;
	//console.log(dd.values.velicina+" "+g_project.size_scale+" "+ dd.values.tVel);
	
	dd.box.translate.x = dd.values.perihelion/g_project.dist_scale;	
			
	dd.values.group = dd.values.this.attr("class", dd.class)
		.attr("id", "obj-"+dd.id)
		.attr("name", dd.name)
		.attr("transform","rotate("+(dd.box.rotate.x)+"), translate("+(dd.box.translate.x)+",0)")
		;
	dd.box.rotate.y = -ORBIT_ROT_CICLE;
	if(dd.const.slika && dd.const.slika.length > 1)
		dd.values.picture = svgDefs.append("pattern")
		//.attr("patternUnits","userSpaceOnUse")
		.attr("id", dd.name+"-slika")
		.attr("x", "0%")
		.attr("y", "-150%")
		.attr("width", "300%")
		.attr("height", "400%")
		.attr("viewBox","0 0 1 1")
		.append("image")
		.attr("x", dd.box.rotate.y)
		.attr("y", "0")
		.attr("width", "1")
		.attr("height", "1")
		.attr("xlink:href", IMG_PATH+dd.const.slika);
	
	if(dd.const.slika_ring && dd.const.slika_ring.length > 1)
		dd.values.p_ring_b = svgDefs.append("pattern")
		.attr("preserveAspectRatio","none")
		.attr("id", dd.name+"-slika-ring-back")
		.attr("x", "0%")
		.attr("y", "0%")
		.attr("width", "100%")
		.attr("height", "200%")
		.attr("viewBox","0 0 1 1")
		.append("image")
		.attr("x", "0")
		.attr("y", "0")
		.attr("width", "1")
		.attr("height", "1")
		.attr("xlink:href", IMG_PATH+dd.const.slika_ring);
		
	if(dd.const.slika_ring && dd.const.slika_ring.length > 1)
	dd.values.p_ring_f = svgDefs.append("pattern")
		.attr("preserveAspectRatio","none")
		.attr("id", dd.name+"-slika-ring-front")
		.attr("x", "0%")
		.attr("y", "0%")
		.attr("width", "100%")
		.attr("height", "200%")
		.attr("viewBox","0 0 1 1")
		.append("image")
		.attr("x", "0")
		.attr("y", "-0.5")
		.attr("width", "1")
		.attr("height", "1")
		.attr("xlink:href", IMG_PATH+dd.const.slika_ring);
	
	dd.values.osi = dd.values.this.append("circle")
		.attr("class", "osi")
		.attr("r", dd.values.tVel*ORBIT_OSI_SCALE)
		.attr("cx", 0)
		.attr("cy", 0)
		.attr("fill","url(#osi-slika)");
	

	if(dd.const.slika_ring && dd.const.slika_ring.length > 1)
	dd.values.ring_back = dd.values.this.append("rect")
		.attr("class", "ring_back")
		.attr("x", -dd.values.tVel*5)
		.attr("y", -dd.values.tVel*2)
		.attr("width", dd.values.tVel*10)
		.attr("height", dd.values.tVel*2)
		.attr("fill","url(#"+dd.name+"-slika-ring-back)");
	
	dd.values.circle = dd.values.this.append("circle")
		.attr("class", "planet")
		.attr("r", dd.values.tVel)
		.attr("cx", 0)
		.attr("cy", 0)
		.attr("fill","rgba("+dd.box.bgcolor.r+","+dd.box.bgcolor.g+","+dd.box.bgcolor.b+","+dd.box.bgcolor.a+")")
		.attr("stroke","rgba("+dd.box.bcolor.r+","+dd.box.bcolor.g+","+dd.box.bcolor.b+","+dd.box.bcolor.a+")")
		.attr("stroke-width",PLANET_STROKE)
		;
	if(dd.const.slika && dd.const.slika.length > 1)
		dd.values.circle.attr("fill","url(#"+dd.name+"-slika)");
	
	
	dd.values.shader = dd.values.this.append("circle")
		.attr("class", "sjene")
         .attr("cx",0)
         .attr("cy",0)
         .style("stroke","none");
		 
	if(dd.class.localeCompare("zvijezda"))
	    dd.values.shader.attr("r",dd.values.tVel*1.01)
			.style("fill","url(#planetShadow)");
	else
		dd.values.shader.attr("r",dd.values.tVel*2)
			.style("fill","url(#starGlow)");
	
	if(dd.class.localeCompare("zvijezda"))
	dd.values.paths = dd.values.parent.insert("ellipse","circle,ellipse")
		.attr("class","putanja")
		.attr("cx", dd.values.tCent)
		.attr("cy", 0)
		.attr("rx", dd.values.tDist)
		.attr("ry", dd.values.tDist)
		.attr("fill","rgba(0,0,0,0)")
		.attr("stroke","gray")
		.attr("stroke-width",1)
		.on("mouseenter",function(d){
			dd.values.paths.attr("fill","url(#linesActive)");
		})
		.on("mouseleave",function(d){
			dd.values.paths.attr("fill","rgba(0,0,0,0)");
		})
		.on("mousedown",function(d){
			dd.values.mx = d3.event.x;
			dd.values.my = d3.event.y;
		})
		.on("mouseup",function(d){
			if( dd.values.mx == d3.event.x && dd.values.my == d3.event.y)
			if(Root.follow == null)
				Root.follow = dd;
			else
				if(Root.follow == dd)
					Root.follow = null;
				else {
					Root.moving = false;
					Root.follow = dd;
				}
		});
		
			
	if(dd.const.slika_ring)
	dd.values.ring_front = dd.values.this.append("rect")
		.attr("class", "ring_front")
		.attr("x", -dd.values.tVel*5)
		.attr("y", -0.01)
		.attr("width", dd.values.tVel*10)
		.attr("height", dd.values.tVel*2)
		.attr("fill","url(#"+dd.name+"-slika-ring-front)");
	
	dd.values.select = dd.values.this.append("circle")
		.attr("class","select")
		.attr("cx", 0)
		.attr("cy", 0)
		.attr("r", dd.values.tVel)
		.attr("fill", "rgba(0,0,0,0)")
		.attr("stroke", "none")
		.on("mouseenter",function(d){
			dd.values.select.attr("fill","rgba(255,255,255,0.3)");
		})
		.on("mouseleave",function(d){
			dd.values.select.attr("fill","rgba(0,0,0,0)");
		})
		.on("mousedown",function(d){
			dd.values.mx = d3.event.x;
			dd.values.my = d3.event.y;
		})
		.on("mouseup",function(d){
			if(dd.values.mx == d3.event.x && dd.values.my == d3.event.y)
			if(Root.follow == null)
				Root.follow = dd;
			else
				if(Root.follow == dd)
					Root.follow = null;
				else {
					Root.moving = false;
					Root.follow = dd;
				}
		});
	
	dd.values.this.selectAll("g")
		.data(dd.children)
		.enter()
		.append("g")
		.each(function(d){AddChildrenMod1(d3.select(this),d,dd);});
		
}

function TimerMod1(elapsed){
	
	Root.children.selectAll("g").each(AnimateMod1);
	if(Root.follow != null){
		var rad = Root.follow.box.rotate.x/180*Math.PI;
		var bRad = Root.follow.values.back.box.rotate.x/180*Math.PI;
		var bCos = Math.cos(bRad)*(Root.follow.values.back.box.translate.x);
		var bSin = Math.sin(bRad)*(Root.follow.values.back.box.translate.x);
		var cos = Math.cos(bRad+rad)*( Root.follow.box.translate.x);
		var sin = Math.sin(bRad+rad)*( Root.follow.box.translate.x);
		var xx = Root.follow.values.back.values.tCent + Root.follow.values.tCent + cos + bCos;
		var yy =  sin + bSin;
		Root.x = g_project.width_h - xx;
		Root.y = g_project.height_h - yy;
		Root.width = g_project.width_h - Root.scale*(xx) ;
		Root.height = g_project.height_h - Root.scale*(yy);
		if(!Root.moving)
			Root.scale = g_project.height/Root.follow.values.tVel/4;
		if(Root.scale > ORBIT_MAX_ZOOM) Root.scale = ORBIT_MAX_ZOOM;
		globZoom.scale(Root.scale);
		d3.selectAll(".putanja").attr("stroke-width", 1/Root.scale);
		if(!Root.moving){
			Root.children.transition()
				.ease("linear")
				.duration(ORBIT_ANIM_MOVE)
				.attr("transform"," translate("+(Root.width)+","+(Root.height)+"),"+"scale("+(Root.scale)+") ")
				.each("start", function(){ Root.moving = true; })
				.each("end", function(){Info_place(Info,Root.follow);});
		}
		else
			Root.children.attr("transform"," translate("+(Root.width)+","+(Root.height)+"),"+"scale("+(Root.scale)+") ");
	} else if(Root.moving){
		Info_remove(Info);
		Root.scale = Root.scale_old;
		globZoom.scale(Root.scale_old);
		var offsetX =  Root.scale*(Root.x - g_project.width_h) ;
		var offsetY =  Root.scale*(Root.y - g_project.height_h) ;
		Root.width = g_project.width_h + offsetX ;
		Root.height = g_project.height_h + offsetY ;
		Root.children.transition()
			.ease("linear")
			.duration(ORBIT_ANIM_MOVE)
			.attr("transform"," translate("+(Root.width)+","+(Root.height)+"),"+"scale("+(Root.scale)+") ")
			.each("end", function(){d3.selectAll(".putanja").attr("stroke-width", 1/Root.scale);})
			;
		Root.moving = false;
		}
	ScaleUpdate(sliderVel);
	ScaleUpdate(sliderDist);
	ScaleUpdate(sliderTime);
	
}

function TimerMod11(elapsed){
	globZoom.scale(Root.scale_old);
	g_viewMod = 1;
}

function AnimateMod1(dd){
	
	//if(dd.class.localeCompare("zvijezda")){
			if(!dd.class.localeCompare("satelit")) 
				if(dd.const.brzina_inv)
					dd.values.shader.attr("transform","rotate("+(dd.box.rotate.x)+")");
				else 
					dd.values.shader.attr("transform","rotate(-"+(dd.box.rotate.x)+")");
			
			g_project.size_scale = ORBIT_SIZE_SCALE*(1.3-sliderVel.progress);//+ dd.box.scale*sliderVel.progress*100;
			if(dd.class.localeCompare("zvijezda")){
				g_project.speed_scale = ORBIT_SPEED_SCALE*sliderTime.progress;
				//g_project.size_scale = ORBIT_SIZE_SCALE*(1.1-sliderVel.progress)/8;
				g_project.dist_scale = ORBIT_DIST_SCALE/(1.07-sliderDist.progress);
				dd.values.tDist = dd.values.tRad/g_project.dist_scale;
				dd.values.tCent = (dd.values.tDist-(dd.values.aphelion/g_project.dist_scale));
				dd.values.paths.attr("rx",dd.values.tDist );
				dd.values.paths.attr("ry",dd.values.tDist );
				dd.values.paths.attr("cx", dd.values.tCent);
				dd.box.translate.x = dd.values.tDist;
				dd.box.rotate.x += g_project.speed_scale/dd.values.brzina;
				if(dd.box.rotate.x >359) dd.box.rotate.x = 0;
			}
			dd.values.tVel = (dd.values.velicina)/g_project.size_scale;
			
			if(dd.const.slika_ring && dd.const.slika_ring.length > 1){
				dd.values.ring_front.attr("x",-dd.values.tVel*2.2);
				dd.values.ring_front.attr("y",-0.05);
				dd.values.ring_front.attr("width",dd.values.tVel*4.4);
				dd.values.ring_front.attr("height",dd.values.tVel*1.1/2);
				dd.values.ring_front.attr("transform","rotate("+(-dd.box.rotate.x+dd.values.kut)+")");
				dd.values.ring_back.attr("x",-dd.values.tVel*2.2);
				dd.values.ring_back.attr("y",-dd.values.tVel*1.1/2);
				dd.values.ring_back.attr("width",dd.values.tVel*4.4);
				dd.values.ring_back.attr("height",dd.values.tVel*1.1/2);
				dd.values.ring_back.attr("transform","rotate("+(-dd.box.rotate.x+dd.values.kut)+")");
			}
			dd.values.osi.attr("r",dd.values.tVel*ORBIT_OSI_SCALE);
			dd.values.circle.attr("r",dd.values.tVel);
			
			//dd.values.circle.attr("transform","rotate("+(-dd.box.rotate.x+dd.values.kut)+")");
			dd.values.osi.attr("transform","rotate("+(-dd.values.back.box.rotate.x-dd.box.rotate.x+dd.values.kut)+")");
			dd.values.circle.attr("transform","rotate("+(-dd.values.back.box.rotate.x-dd.box.rotate.x+dd.values.kut)+")");

			if(dd.class.localeCompare("zvijezda"))
				dd.values.shader.attr("r",dd.values.tVel*1.01);
			else 
				dd.values.shader.attr("r",dd.values.tVel*1.5);
			dd.values.select.attr("r",dd.values.tVel);
			
			if(dd.values.rotacija !=0) dd.box.rotate.y += ORBIT_ROT_SCALE/dd.values.rotacija*g_project.speed_scale;
			if(dd.box.rotate.y > 0) dd.box.rotate.y = -ORBIT_ROT_CICLE;
			if(dd.const.slika && dd.const.slika.length > 1) dd.values.picture.attr("x",dd.box.rotate.y);
			
			dd.values.group
				.attr("transform","translate("+(dd.values.tCent)+",0), rotate("+(dd.box.rotate.x)+"), translate("+(dd.box.translate.x)+",0)");
			//}
			
			
	//dd.values.this.selectAll("g").each(AnimateMod1);
}

function MicanjeMod1(){
	Root.x += d3.event.dx/Root.scale;
	Root.y += d3.event.dy/Root.scale;
	Root.children.attr("transform"," translate("+(Root.width)+","+(Root.height)+"), scale("+(Root.scale)+")"); 
}

function ZoomMod1(){
	if(Root.follow == null)Root.scale_old = d3.event.scale;
			projection.translate(d3.event.translate);
			projection.scale(d3.event.scale);
			Root.scale = d3.event.scale;//g_project.event_scale;
			var offsetX =  Root.scale*(Root.x - g_project.width_h) ;
			var offsetY =  Root.scale*(Root.y - g_project.height_h) ;
			Root.width = g_project.width_h + offsetX ;
			Root.height = g_project.height_h + offsetY ;
			d3.selectAll(".putanja").attr("stroke-width", 1/Root.scale);
			//d3.selectAll(".strokan").attr("stroke-width", PLANET_STROKE/Root.scale);
			if(Root.follow == null)				
				Root.children.attr("transform"," translate("+(Root.width)+","+(Root.height)+"), scale("+(Root.scale)+") ");
}

function Info_place(info,dd){
			info.x = INFO_X;
			info.y = INFO_Y;
			info.g.attr("transform","translate("+(info.x)+","+(info.y)+")");
			info.tName.html("Naziv: "+dd.name+"\n");
			info.tTip.html("Tip: "+dd.class+"\n");
			info.tInfo.html("Info: "+dd.const.info+"\n");
			info.tVel.html("Polumjer: "+dd.const.velicina+" m");
			info.tPel.html("Perihelion: "+dd.const.perihelion+" m");
			info.tApel.html("Aphelion: "+dd.const.aphelion+" m");
			info.tKut.html("Nagib: "+dd.const.kut+"°\n");
			info.tRot.html("Rotacija: "+dd.const.rotacija+" dana");
			if(dd.const.sateliti)
				info.tSat.html("Sateliti: "+dd.const.sateliti);
			else 
				info.tSat.html("Planeti: "+dd.const.planeti);
			info.tPov.html("Površina: "+dd.const.povrsina);
			info.tTemp.html("Temperatura:~ "+dd.values.temperatura.toFixed(2)+" °C");
			info.tGrav.html("Gravitacija: "+dd.const.gravitacija+" m/s");
			info.g.style("visibility","visible");
}

function Info_remove(info){
	info.g.style("visibility","hidden");
}