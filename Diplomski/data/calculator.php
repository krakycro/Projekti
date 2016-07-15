<?php

$INF = "Infinite";
$style='<div>';
if(!empty($_REQUEST['style']))
$style='
<div class='.$_REQUEST['style'].'>
'; 
$wrap ='<div>';
if(!empty($_REQUEST['box']))
$wrap='
<div class='.$_REQUEST['box'].'>
';
if(!empty($_REQUEST['xypos'])){
	$tmp = explode(",",$_REQUEST['xypos']);
	if(sizeof($tmp) > 1){ 
		$task = $tmp;
		$task[0] = floatval($task[0]);
		if($task[0] <= 0) $task[0] = 1;
		$task[1] = floatval($task[1]);
		$task[2] = floatval($task[2]);
		}
	else $task = array(1,0,0);
	}
else
	$task = array(1,0,0);
if(!empty($_REQUEST['input']))
	$cin = filter_var($_REQUEST['input'], FILTER_SANITIZE_STRING);
else if(!empty($_POST['input']))
	$cin = filter_var($_POST['input'], FILTER_SANITIZE_STRING);
else { echo $wrap."Info:".$style."Unos prazan!</div></div>"; die();}
$cin = strtolower($cin);

$path = '../graph';
if ($handle = opendir($path)) {
	while (false !== ($file = readdir($handle))) {
        	if (strripos($file, '.png') !== false)
            		unlink($path.'/'.$file);
    	}
}


function DefineNumber($IN){
	settype($IN, "float");
	return $IN;
	}


class Constant {
    
	public $name= array(
        "e" => 2.718281828459045,
       	"x" => 1,
        "pi" => 3.1415926535897,
	"π" => 3.1415926535897,
	"¼" => 0.25,
	"½" => 0.5,
	"¾" => 0.75
        );
    	public $patern;
    	function Constant(){
             	$this->patern = $this->Validate();
             	}
	function Validate(){
            	$T="";
            	$a=0;
            	foreach($this->name as $indeks => $vrjednost){
                  	if(sizeof($this->name)-1 > $a) $T = $T.$indeks."|";
                  	else $T = $T.$indeks;
                  	$a++;
                  	}
            	return $T;
        }
	function addConstant(&$TXT, &$i, &$A, &$a, $xx){
             	$tmp = substr($TXT, $i);
             	preg_match('/^('.$this->patern.')/', $tmp, $match);
             	if(empty($match[0])) return 0;
             	else { 
		        $this->name["x"] = $xx;
                  	$A[$a] = $this->name[$match[0]];
                  	$a++;
                  	$i += strlen($match[0]); 
                  	return 1;
                }
	}
	function isConstant($TXT, $i){
             	if($i<0) $i=0;
             	$tmp = substr($TXT, $i,3);
             	preg_match('/(^|[\\+\\-\\/\\^\\*\\(\\)]{1})('.$this->patern.')/', $tmp, $match);
             	if(empty($match[0])) return 0;
             	else  return 1;
             	return 0;
	}
};

class MathFunction {
	public $name= array(
        "root" => '2',
        "pow" => '2',
        "log" => '10',
        "sin" => '1',
        "cos" => '1',
        "tan" => '1',
        "cot" => '1',
	"√" => '2'
        );
    	public $patern;
    	public $C;
    	function MathFunction(){
             	$this->patern = $this->Validate();
             	$this->C = new Constant();
             	}
	function Validate(){
            	$T="";
            	$a=0;
            	foreach($this->name as $indeks => $vrjednost){
                  	if(sizeof($this->name) - 1 > $a) $T = $T.$indeks."|";
                  	else $T = $T.$indeks;
                  	$a++;
                }
            	return $T;
        }
	function addMathFunction(&$TXT, &$i, &$B, &$A, &$a, $xx){
	     	if($i-1 >= 0) $tmp = substr($TXT, $i - 1);
             	else $tmp = substr($TXT, $i); //echo $tmp.'|';
             	preg_match('/(^([^\\+\\-\\/\\^\\*]){1})?('.$this->patern.')/', $tmp, $match); 
             	if(empty($match[0])) return 0;
             	else {
             		if($match[1] == '(') {
				$match[1] = '';
				$match[0] = substr($match[0],1);
				}
                  	if(empty($match[1])) {
				$A[$a] = $this->name[$match[0]]; 
				$a++; 
				$i += strlen($match[0]); 
				}
                  	else $i += strlen($match[0])-1;
                  	$B = $match;                  		
                  	return 1;
                }
        }
    	function isMathFunctionFind($TXT, $i){
    		if($i<0) $i=0;
             	$tmp = substr($TXT, $i);
             	preg_match('/^('.$this->patern.')/', $tmp, $match); 
             	if(empty($match[0])) return 0;
             	else return 1;
	}

	function isMathFunction($TXT){
             	preg_match('/'.$this->patern.'/', $TXT[0], $match);
             	if(empty($match[0])) return 0;
             	else return 1;
	}
    	function compile($TXT, $A, $B){
    		global $INF;
             	preg_match('/'.$this->patern.'/', $TXT[0], $match);
             	switch($match[0]){
                	case 'root': case '√': 
				if($A == 0) return $INF; 
				else return pow($B, 1/$A); break;
                      	case 'pow': return pow($B,$A); break;
                      	case 'log': 
				if($B <= 0 || $A <= 1) return $INF; 
				else return log($B)/log($A); break;
                      	case 'sin': return pow(sin($B),$A); break;
                      	case 'cos': return pow(cos($B),$A); break;
                      	case 'tan': return pow(tan($B),$A); break;
                      	case 'cot':  return pow(atan($B),$A); break;
                      	}
       	}
};

class Validation{
	
        public $F ;
        public $C ;
        public $N = '((\d)*(\\.)?(\d)+){1}(e(\\+|-)?\d{1,3})?';
        public $S = '((\\)|0)([\\+\\-\\/\\^\\*]))|(\\([\\+\\-])';
        public $G = '([\\(]+)?(0+)([\\)]+)?';
        public $D = '/[\\+\\-\\/\\^\\*]{2}/';
	public $NUMBER ;
        public $BAROPEN = '/\\(/';
        public $BARCLOSE = '/\\)/';
	public $SNUMBER ;
	public $SIGN ;
        public $GRUP ;
	public $FUNC ;
        public $CONST ;

	function Validation(){
		$this->F = new MathFunction();
    		$this->C = new Constant();
		$this->NUMBER = '/'.$this->N.'/';
		$this->SNUMBER = '/(\\+|-)?'.$this->N.'/';
		$this->SIGN = '/'.$this->S.'/';
        	$this->GRUP = '/'.$this->G.'/';
		$this->FUNC = '/(\\)?('.$this->F->patern.')[0\\(]+)/';
    		$this->CONST = '/('.$this->C->patern.')/';
	}
	
	function Pattern($S, $T, $L){
		preg_match($T, $S , $M, PREG_PATTERN_ORDER, $L);
		return $M;
	}
	function PatternAll($S, $T, $L){
		$M = "";
		preg_match_all($T, $S , $M, PREG_PATTERN_ORDER, $L);
		return $M[0];
	}
	function ReplacePattern($S, $TMP, $T, $L){
	    	$TSA = preg_split($T, $S, $L);
	    	$TS = "";
            	for($i = 0; $i < sizeof($TSA); $i++){
                	if($i < sizeof($TSA)-1) $TS = $TS.$TSA[$i].$TMP;
                 	else $TS = $TS.$TSA[$i];
                }
            	return $TS;
	}
	function RemovePattern($S, $T, $L){
	    	$TSA = preg_split($T, $S, $L);
	    	$TS = "";
            	for($i = 0; $i < sizeof($TSA); $i++)
                 	$TS = $TS.$TSA[$i];
            	return $TS;
	}
};

$VAL = new Validation();
$FUNC = new MathFunction();
$KON = new Constant();

function IsOperant($s){
     global $cin;
     if($cin[$s] =='^'  || $cin[$s]=='+'  || $cin[$s]=='-'  || $cin[$s]=='*' || $cin[$s]=='/'
	|| $cin[$s]=='('  || $cin[$s]==')' ) return true;
     else return false;
} 
     
function SecondRang($B){
     global $FUNC;
     if($FUNC->isMathFunction($B) || $B === '^') return 1;
     else return 0;
}
     
function FirstRang($B){
     if($B=='*' || $B=='/' || SecondRang($B)) return 1;
     else return 0;
}

function PrintOut($bar, $TXT){
	global $style,$wrap;
	echo $wrap.$bar;
	echo $style;
	print_r($TXT);
	echo '</div>'.'</div>';
}

function Validate($A){
	global $VAL;
	$acc = array('greska' => '');
	$S = (String)$A;
	$TS = $VAL->ReplacePattern($S,"0",$VAL->SNUMBER, 2);
	$TS = $VAL->ReplacePattern($S,"0",$VAL->NUMBER, -1);
        $TS = $VAL->ReplacePattern($TS,"0",$VAL->CONST, -1);
        $TS = $VAL->ReplacePattern($TS,"0",$VAL->FUNC, -1);
	if(sizeof($VAL->PatternAll($TS,$VAL->SIGN, strlen($TS)-2 )) > 0) 
		$acc['greska'] = "<p>Greska u sintaksi!<p>";
	$TS = $VAL->RemovePattern($TS,$VAL->SIGN, -1);
        $TS = $VAL->RemovePattern($TS,$VAL->GRUP, -1);
	if(strlen($TS) > 0) {$acc['greska'] = "<p>Greska u sintaksi!<p>";}
	$XX = sizeof($VAL->PatternAll($S,$VAL->BAROPEN, 0))
	      -sizeof($VAL->PatternAll($S,$VAL->BARCLOSE, 0));
        if($XX != 0 && $XX != 1) {
		$acc['greska'] .= "<p>Greska sa zagradama!<p>"; 
		$acc['zagrade'] = $XX;}
		if(!empty($acc['greska'])) PrintOut('Info:', $acc['greska']);
		return $acc;
}


function Calculate(&$i,$xx){
	global $VAL,$KON,$FUNC,$cin,$INF;
	$a = 0;
	$b = 0;
	$n = 0;
	$B = array(0);
	$A = array(0);
	$UM = 0;
	$ti = $i;
	$minus = 0;
	if($cin[$i] === '-' || $cin[$i] === '+') { if($cin[$i] === '-')$minus = 1; $i++; }
	while( $i < strlen($cin) && $cin[$i] != ')'){
                if($cin[$i] === '(') { 
			if($i-1 >= 0) 
				if(($cin[$i-1] >= '0' && $cin[$i-1] <= '9') 
				    || $cin[$i-1] === ')' ) 
			$B[$b++] = '*'; 
			$i++; $A[$a++] = Calculate($i, $xx);
		}
                if($i >= strlen($cin)) break;
                if($i-1 >= 0) 
			if(($cin[$i-1] == ')' || ($cin[$i-1] >= '0' && $cin[$i-1]<= '9'))
		            && $KON->isConstant($cin, $i) && !IsOperant($i))  $B[$b++] = '*';
                if(($cin[$i] >= '0' && $cin[$i]<= '9' ) || $cin[$i] == '.') {
                	if($i-1 >= 0) if($cin[$i-1] === ')')  $B[$b++] = '*';
                	preg_match($VAL->SNUMBER, $cin, $match,0,$i); 
                    	$A[$a++]= DefineNumber($match[0]); 
                    	$i += strlen($match[0]);
                }
                else if($KON->addConstant($cin, $i, $A, $a, $xx)){ 
                    	if($i < strlen($cin)) 
				if($cin[$i] == '(' || ($cin[$i] >= '0' 
			           && $cin[$i]<= '9' ) || $cin[$i] == '.') $B[$b++] = '*';
                }
                else if(IsOperant($i) && $cin[$i]!='\0' && $cin[$i]!=')' && $cin[$i]!='(') {
			$B[$b++] = $cin[$i]; 
			$i++;
		}
                else if($FUNC->addMathFunction($cin, $i, $B[$b], $A, $a, $xx)){ $b++;}
                else if($cin[$i] != '(')$i++;
                    }
    	if($minus) $A[0] *= -1;
	$UM=$A[0];
    	for($k=0; $k < $b; $k++){
        	if($FUNC->isMathFunction($B[$k])){ 
			$A[$k] = $FUNC->compile($B[$k], $A[$k], $A[$k+1]); 
			$A[$k+1] = $A[$k]; 
			$UM = $A[$k+1];
		}
              	if($B[$k] === '^'){ 
			$A[$k] = pow($A[$k],$A[$k+1]); 
			$A[$k+1] = $A[$k]; 
			$UM = $A[$k+1];
		}     
        }
    	for($k=0; $k < $b; $k++){
                if($B[$k]=='*'){
                	for($n=$k+1 ; $n < sizeof($B)  && SecondRang($B[$n]) ;$n++) {} 
                                if(is_numeric($A[$k]) && is_numeric($A[$n])) $A[$k] *= $A[$n]; 
                                if(!is_numeric($A[$k]) || !is_numeric($A[$n])) 
					$A[$k] = $A[$n] = $INF;
				else $A[$n] = $A[$k]; 
                                $UM = $A[$n];
                        }
                if($B[$k]=='/') {
                        for($n=$k+1 ; $n < sizeof($B)  && SecondRang($B[$n]) ;$n++) {} 
                        if($A[$n] == 0) { $A[$n] = $A[$k] = $UM = $INF; }
                        else { 
                        	if(is_numeric($A[$k]) && is_numeric($A[$n]))$A[$k] /= $A[$n]; 
                                if(!is_numeric($A[$k]) || !is_numeric($A[$n])) 
					$A[$k] = $A[$n] = $INF; 
				else $A[$n] = $A[$k]; 
                                $UM=  $A[$n];}
                        }        
        }
    	for($k=0; $k < $b; $k++){
                if($B[$k]=='+'){
                       	for($n=$k+1 ; $n < sizeof($B) && FirstRang($B[$n]) ;$n++) {}
                                if(is_numeric($A[$k]) && is_numeric($A[$n])) $A[$k] += $A[$n];
                                if(!is_numeric($A[$k]) || !is_numeric($A[$n])) 
					$A[$k] = $A[$n] = $INF; 
				else $A[$n] = $A[$k];
                                $UM = $A[$n]; 
                        }
               	if($B[$k]=='-') {
                        for($n=$k+1 ; $n < sizeof($B) && FirstRang($B[$n]) ;$n++) {}
                                if(is_numeric($A[$k]) && is_numeric($A[$n]))$A[$k] -= $A[$n];
                                if(!is_numeric($A[$k]) || !is_numeric($A[$n])) 
					$A[$k] = $A[$n] = $INF; 
				else $A[$n] = $A[$k]; 
                                $UM=  $A[$n];
                        }    
        }
	$i += 1;
	return $UM;
}


function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1){
	if ($thick == 1)
        	return imageline($image, $x1, $y1, $x2, $y2, $color);
	$t = $thick / 2 - 0.5;
    	if ($x1 == $x2 || $y1 == $y2)
        	return imagefilledrectangle(
					    $image, 
					    round(min($x1, $x2) - $t), 
					    round(min($y1, $y2) - $t), 
					    round(max($x1, $x2) + $t), 
					    round(max($y1, $y2) + $t), 
					    $color
					    );
    	$k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
    	$a = $t / sqrt(1 + pow($k, 2));
    	$points = array(
        	round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
        	round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
        	round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
        	round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
    		);
    	imagefilledpolygon($image, $points, 4, $color);
    	return imagepolygon($image, $points, 4, $color);
}

function drawArrow($im, $x1,$y1, $x2, $y2, $r, $col, $size){
	if($r == 0){
		imagelinethick($im, $x1,$y1-2, $x2, $y2, $col, $size);
		imagelinethick($im, $x1,$y1+2, $x2, $y2, $col, $size);
	}
	else{
		imagelinethick($im, $x1-2,$y1, $x2, $y2, $col, $size);
		imagelinethick($im, $x1+2,$y1, $x2, $y2, $col, $size);
	}
}

function Graph($xx, $scl = 1, $mx = 0, $my = 0){
      	$i = 0;
        $sizer = 25.5;
        $ID = mt_rand();
        $f = fopen('../graph/graph'.$ID.'.png', 'w') or die("can't open file");
        fclose($f);
        if($xx){
           	$rezx = 500;
              	$rezy = 350;
              	$scale = $scl*10;
              	$my *= $sizer/$scl;
		$mx *= -$sizer/$scl;
              	$compx =  $rezx/$scale-2;
              	$compy =  $rezy/$scale-2;
              	$omjer = $rezx/$rezy;
              	$im = @imagecreate($rezx,$rezy)
              	or die("Cannot Initialize new GD image stream");
              	$background_color = imagecolorallocate($im, 255, 255, 255);
              	$text_color = imagecolorallocate($im, 233, 14, 91);
              	for($kk= -10; $kk <= 10 ; $kk++){
              	imagelinethick(
			$im,
			$rezx/2+$kk*$rezx/20,
			0,
			$rezx/2+$kk*$rezx/20,
			$rezy,
			imagecolorallocate($im, 180, 180, 180),
			1
			);
              	}
              	for($kk= 10; $kk >= -10 ; $kk--){
                      	imagelinethick(
				$im,
				0,
				$rezx/2-$kk*$rezx/20,
				$rezx,
				$rezx/2-$kk*$rezx/20,
				imagecolorallocate($im, 180, 180, 180),
				1
				);
                }
              	drawArrow(
			$im,
			$rezx-10,
			$rezy/2+$my,
			$rezx,$rezy/2+$my,
			0,
			imagecolorallocate($im, 0, 0, 0),
			2
			);
              	drawArrow(
			$im,
			$rezx/2+$mx,
			10,$rezx/2+$mx,
			0,
			1,
			imagecolorallocate($im, 0, 0, 0),
			2
			);
              	imagelinethick(
			$im,
			0,
			$rezy/2+$my,
			$rezx,
			$rezy/2+$my,
			imagecolorallocate($im, 0, 0, 0),
			2
			);
              	imagelinethick(
			$im,
			$rezx/2+$mx,
			0,
			$rezx/2+$mx,
			$rezy,
			imagecolorallocate($im, 0, 0, 0),
			2
			);
              	$old = $new = Calculate($i,-$scale-1); 
              	$i = 0;
              	for($kk= 0; $kk <= $rezx; $kk+=2.4){ 
              	  	$rangx = -$scale+($kk*($scale*2)/$rezx);
                  	$new = Calculate($i, $rangx-($mx/($sizer-0.5)*$scl)); 
                  	$i = 0; 
                  	$pomak = $my;
                  	if(is_Numeric($old))
				imagelinethick(
					$im, 
					$kk-1, 
					round($rezy/2-($old*($rezx/$scale)/2)+$pomak), 
					$kk, 
					round($rezy/2-($new*($rezx/$scale)/2)+$pomak), 
					imagecolorallocate($im, 200, 100, 100),
					2
					);
                  	$old = $new; 
               	}
            	$my /= -$sizer/$scl;
            	$mx /= -$sizer/$scl;
            	$newx = number_format(($mx*$sizer/$scl)-$rezx/2, 2,".","");
            	$newy = number_format($rezy/2-($my*$sizer/$scl), 2,".","");
            	$graf = '<form id="gform" name="gform" action="" onsubmit="calculate($(\''
		     .'#grafsxy\').val(),\'#input\',\'#output\'); return false;" method="post">';
            	$graf .= '<div id="graf" align="center"><img id="grafimg" src="./graph/graf'.$ID.'.png">';
         	$graf .= '<p>Omjer 1:<input id="grafs" type="text" style="width:40px" value="'.
			($scale/10).'"> Koordinate <input id="grafx" type="text" style="width:'
			.'40px" value="'.$mx.'">x <input id="grafy" type="text" style="width:4'
			.'0px" value="'.(-$my).'">y</p>';
         	$graf .= '<input id="grafmod" type="button" onclick="calculate($(\'#grafs\').v'
			.'al()+\',\'+$(\'#grafx\').val()+\' ,\'+$(\'#grafy\').val(),\'#input\''
			.',\'#output\'); return false;" value="Pogledaj"></div>';
         	$graf .= '<input id="grafsxy" type="hidden" value="'
			.number_format(($sizer*10)/$scale, "6",".","").','.$newx.','.$newy.'"';
         	$graf .= '</form>';
         	PrintOut('Graf:', $graf); 
         	imagepng($im,'../graph/graf'.$ID.'.png');
         	imagedestroy($im);    
              }
	else{
              	$rezx = 500;
              	$rezy = 50;
              	$scale = $scl;
              	$compx =  $rezx/$scale;
              	$compy =  $rezy/$scale;
              	$omjer = $rezx/$rezy;
              	$im = @imagecreate($rezx,$rezy)
              	or die("Cannot Initialize new GD image stream");
              	$background_color = imagecolorallocate($im, 255, 255, 255);
              	$text_color = imagecolorallocate($im, 233, 14, 91);
              	$br = round(Calculate($i,1));
              	$old = $rezx/2+$br*$compx/2-10;
              	imagelinethick(
			$im,
			0,
			$rezy/2,
			$rezx,
			$rezy/2,
			imagecolorallocate($im, 0, 0, 0),
			2
			);
              	$size = round($rezx/((strlen($br)+2)*10));
              	for($kk= -$size; $kk <= $size ; $kk++)
              	imagestring(
			$im, 
			1, 
			$rezx/2-$kk*($rezx/$size)/2-(strlen($br)*3), 
			$rezy/2+2, $br-$kk, 
			imagecolorallocate($im, 100, 100, 100)
			);
              	imagelinethick(
			$im, 
			$rezx/2-5, 
			$rezy/2-15, 
			$rezx/2-5, 
			$rezy/2-15, 
			imagecolorallocate($im, 200, 100, 100),
			4
			);
              	$graf = '<div align="center"><img src="./graph/graf'.$ID.'.png"></div>';
         	  	PrintOut('Graf:', $graf);
         	  	imagepng($im,'../graph//graf'.$ID.'.png');
        	  	imagedestroy($im);  
     	}
}


$i = 0;
$acc = Validate($cin);
If(strlen($acc['greska']) == 0) {
	if(!preg_match('/x/', $cin, $match)) {
		PrintOut('Rezultat:', Calculate($i,1)); 
		Graph(0);
	} 
	else Graph(1,$task[0],$task[1],$task[2]); 
}

?>
