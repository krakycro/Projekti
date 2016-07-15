// KONSTANTE --------------------------------------------------------------------------


// GLOB VARIJABLE --------------------------------------------------------------------------

var g_project = {
	width : WIDTH,
	height : HEIGHT,
	width_h : WIDTH/2,
	height_h : HEIGHT/2,
	padding : PADDING,
	dist_scale : ORBIT_DIST_SCALE,
	size_scale : ORBIT_SIZE_SCALE,
	speed_scale : ORBIT_SPEED_SCALE,
	zoom_scale : ORBIT_ZOOM_SCALE,
	rotate_scale : ORBIT_ROT_SCALE,
	start : Date.now()
};

var Root = {
		x : g_project.width_h,
		y : g_project.height_h,
		height : this.x,
		width : this.y,
		scale : 1,
		scale_old : 1,
		moving : false,
		follow : null
	}

var g_globusAngle = 0;
var g_globusRadius = g_project.height/2 - g_project.padding;
var g_globusScale = 1;
var g_viewMod = 0;
var g_allLoaded = false;

// DEFINICIJE --------------------------------------------------------------------------
	
	
var globDrag = d3.behavior.drag()
	.on("drag", Micanje); 
	
var globZoom = d3.behavior.zoom()
    .scaleExtent([1,ORBIT_MAX_ZOOM])
    .on("zoom", Zoom);		

var projection = d3.geo.orthographic()
    .scale(g_globusRadius)
    .translate([0, 0])
    .clipAngle(90)
    .precision(.1);

var path = d3.geo.path()
	.projection(projection);
	
// INICIJALIZACIJA + DEFS --------------------------------------------------------------------------

var SVG = d3.select("body").append("svg")
	.attr("id","SVG")
	.attr("width",g_project.width)
	.attr("height",g_project.height)
	.style("background","rgb(0,0,0)")
	//.call(globDrag)
	//.call(globZoom)
	;
	
var svgDefs = SVG.append("defs");
var planetShadow = svgDefs.append("radialGradient")
	.attr("id", "planetShadow")
    .attr("r", 0.7)
	.attr("cx", "15%")
	.attr("cy", "50%")
	.attr("fx", "15%")
	.attr("fy", "50%");
planetShadow.append("stop").attr("offset", "0%").style("stop-color", "rgba(0,0,0,0.1)");
planetShadow.append("stop").attr("offset", "60%").style("stop-color", "rgba(0,0,0,0.5)");
planetShadow.append("stop").attr("offset", "100%").style("stop-color", "rgba(0,0,0,1)");

var starGlow = svgDefs.append("radialGradient")
	.attr("id", "starGlow")
    .attr("r", 0.5)
	.attr("cx", "50%")
	.attr("cy", "50%")
	.attr("fx", "50%")
	.attr("fy", "50%");
starGlow.append("stop").attr("offset", "0%").style("stop-color", "rgba(255,255,200,0.8)");
starGlow.append("stop").attr("offset", "50%").style("stop-color", "rgba(255,255,200,0.3)");
starGlow.append("stop").attr("offset", "100%").style("stop-color", "rgba(255,255,200,0)");

var linesActive = svgDefs.append("radialGradient")
	.attr("id", "linesActive")
    .attr("r", 0.5)
	.attr("cx", "50%")
	.attr("cy", "50%")
	.attr("fx", "50%")
	.attr("fy", "50%");
linesActive.append("stop").attr("offset", "60%").style("stop-color", "rgba(255,255,255,0)");
linesActive.append("stop").attr("offset", "80%").style("stop-color", "rgba(255,255,255,0.05)");
linesActive.append("stop").attr("offset", "100%").style("stop-color", "rgba(255,255,255,0.1)");

var fShadow = svgDefs.append("filter")
	.attr("id", "shadow")
	.attr("x", "-20%")
	.attr("y", "-20%")
	.attr("width", "140%")
	.attr("height", "140%");
fShadow.append("feGaussianBlur")
	.attr("stdDeviation", "1 1")
	.attr("result", "shadow");
fShadow.append("feOffset")
	.attr("dx", "2")
	.attr("dy", "2");

svgDefs.append("pattern")
	.attr("id", "osi-slika")
	.attr("x", "0%")
	.attr("y", "0%")
	.attr("width", "100%")
	.attr("height", "100%")
	.attr("viewBox","0 0 1 1")
	.append("image")
	.attr("x", "0")
	.attr("y", "0")
	.attr("width", "1")
	.attr("height", "1")
	.attr("xlink:href", IMG_DATA_PATH+"arrow.png");
		

// KOD ----------------------------------------------------------------------------------------

		

// FUNKCIJE --------------------------------------------------------------------------

function Micanje() {
	switch(g_viewMod){
		case 1: 
			MicanjeMod1();
			break;
		case 2:
			MicanjeMod2();
			//g_globusAngle += (d3.event.dx/2);
			break;
		default: break;
	}
}
function Zoom() {
	switch(g_viewMod){
		case 1: 
			ZoomMod1();
			break;
		case 2: 
			ZoomMod2();
			//g_globusScale = d3.event.scale;
			//projection.scale(g_globusRadius*d3.event.scale);
			break;
		default: break;
	}
}
