<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
</head>
<body>
	
	<canvas id="canvas" width="1000" height="300">
		
	</canvas>
	
	<br>
	
	<div class="botoesMovimento">
		<button id="iniciar"> INICIAR </button>
		<button id="pausar"> PAUSAR </button>
		<button id="continuar"> CONTINUAR </button>
	</div>	


	<div class="botoesDeslizamento">
		<h3>
			<font color = "#1E90FF"> 
			Campo(T): <input type="range" name="campo" id="campo" value="5" min="0" max="15" width = "50" />
			Ângulo: <input type="range" name="angulo" id="angulo" value="180" min="90" max="180" />
			Área(m²): <input type="range" name="area" id="area" value="7.5" min="7.5" max="12.5" />
			</font>
		</h3>

		


	</div>	

	<div class ="informacoes">
		Fluxo Magnético<br></br>
		φ = B . A . Cos α
	</div>

	<div class ="fluxo">
		<h1 id='teste'></h1>
	</div>




	
	

	



</body>




<script>
	






	var canvas=document.getElementById("canvas");
	var contexto=canvas.getContext("2d");
	
	var pequeno180=[];
	var fundoPequeno180=[];
	var pequeno225=[];
	var fundoPequeno225=[];
	var pequeno270=[];
	var fundoPequeno270=[];
	var campoGeradoPorCI180=[];
	var campoGeradoPorCI180Invertido=[];
	var campoGeradoPorCI225=[];
	var campoGeradoPorCI225Invertido=[];

	var setas3=[];
	var setas5=[];
	var setas7=[];
	
	var j=0;
	var d=0;
	var anterior=[]; 
	var k=0;

	var campoPT 	= true;
	var campoMT 	= false;
	var campoGT 	= false;

	var areaPT 		= true;
	var areaMT		= false;
	var areaGT		= false;

	var angulo180 	= true;
	var angulo225 	= false;
	var angulo270 	= false;
	var sentindoCorrenteInduzida = true;
	
	for(var i=0;i<=8;i++){
		pequeno180[i] = new Image();
		pequeno180[i].src = 'fisica/Pequeno180/campo3/'+i+'.png';
		pequeno225[i] = new Image();
		pequeno225[i].src = 'fisica/Pequeno225/campo3/'+i+'.png';
		pequeno270[i] = new Image();
		pequeno270[i].src = 'fisica/Pequeno270/'+i+'.png';
	}	


	for(var i=0;i<=7;i++){
		setas3[i] = new Image();
		setas3[i].src = 'fisica/setas/setas3/'+i+'.png';
		setas5[i] = new Image();
		setas5[i].src = 'fisica/setas/setas5/'+i+'.png';
		setas7[i] = new Image();
		setas7[i].src = 'fisica/setas/setas7/'+i+'.png';
	}

	for(var i=0;i<=7;i++){
		fundoPequeno180[i] = new Image();
		fundoPequeno180[i].src = 'fisica/Fundo Pequeno180/'+i+'.png';	
		fundoPequeno225[i] = new Image();
		fundoPequeno225[i].src = 'fisica/Fundo Pequeno225/'+i+'.png';
		fundoPequeno270[i] = new Image();
		fundoPequeno270[i].src = 'fisica/Fundo Pequeno270/'+i+'.png';			
	}

	for(var i=0;i<=12;i++){
		campoGeradoPorCI180[i] = new Image();
		campoGeradoPorCI180[i].src = 'fisica/Corrente Induzida 180/'+i+'.png';	
		campoGeradoPorCI180Invertido[i] = new Image();
		campoGeradoPorCI180Invertido[i].src = 'fisica/Corrente Induzida 180 - sentido contrario/'+i+'.png';
		campoGeradoPorCI225[i] = new Image();
		campoGeradoPorCI225[i].src = 'fisica/Corrente Induzida 225/'+i+'.png';
		campoGeradoPorCI225Invertido[i] = new Image();
		campoGeradoPorCI225Invertido[i].src = 'fisica/Corrente Induzida 225 - sentido contrario/'+i+'.png';			
	}		

	var inicia=0;
	var pausa=1;
	var continua=0;


	function iniciar(){
		pausa=0;
		inicia=1;
		continua=0;
	}

	function pausar(){
		pausa=1;
		inicia=0;
		continua=0;
	}

	function continuar(){
		pausa=0;
		inicia=0;
		continua=1;
	}

	document.getElementById("iniciar").onclick=iniciar;
	document.getElementById("pausar").onclick=pausar;
	document.getElementById("continuar").onclick=continuar;


onload=function(){

		play();
	}
	


	function play(){
				if(inicia==1){
					j=0;
					inicia=0;
					
				}
				if(pausa==0){
					j=(j>5) ? 2: j+1;
					d=(d>10) ? 6: d+1;
					
				}
				
				if(document.getElementById("campo").value != anterior[k-1] && k>0){
					anterior[k] = document.getElementById("campo").value;
				//alert(anterior[k]);
				}

				if(document.getElementById("area").value >= 7.5 && document.getElementById("area").value < 10){
					areaPT = true;
					areaMT = false;
					areaGT = false;					
				}
				if(document.getElementById("area").value >= 10 && document.getElementById("area").value < 12.5){
					areaMT = true;	
					areaPT = false;
					areaGT = false;			
				}
				if(document.getElementById("area").value == 12.5){
					areaGT = true;
					areaMT = false;	
					areaPT = false;				
				}
				
				if(document.getElementById("campo").value >= 1 && document.getElementById("campo").value < 10){
					campoPT = true;	
					campoMT = false;
					campoGT = false;
				}
				if(document.getElementById("campo").value == 0){
					campoPT = false;	
					campoMT = false;
					campoGT = false;	
					//areaPT 	= false;
					pausar(); 	
							
				}
				if(document.getElementById("campo").value >= 10 && document.getElementById("campo").value < 15){
					campoMT = true;	
					campoPT = false;
					campoGT = false;							
				}
				if(document.getElementById("campo").value == 15){
					campoGT = true;	
					campoMT = false;
					campoPT = false;
					sentindoCorrenteInduzida = true;
					
				}
				
				if(document.getElementById("campo").value > anterior[k-1] && k > 0){
					sentindoCorrenteInduzida = true;
				}
				if(document.getElementById("campo").value < anterior[k-1] && k > 0){
					sentindoCorrenteInduzida = false;
				}
				if(document.getElementById("campo").value > 9 && anterior[k-1] < 10 && k > 0){
					sentindoCorrenteInduzida = true;
				}
				if(document.getElementById("campo").value < 10 && anterior[k-1] > 9 && k > 0){
					sentindoCorrenteInduzida = false;
				}
				

				var ang;

				if(document.getElementById("angulo").value < 135 && document.getElementById("angulo").value > 90){
					ang = 0.3;
				}
				if(document.getElementById("angulo").value < 180 && document.getElementById("angulo").value > 135){
					ang = 0.6;
				}
				if(document.getElementById("angulo").value == 90){
					angulo180 = false;
					angulo225 = false;
					angulo270 = true;
					ang = 0;
				}
				if(document.getElementById("angulo").value >= 120 && document.getElementById("angulo").value <= 140){
					angulo225 = true;
					angulo180 = false;
					angulo270 = false;
					ang = 0.7;
				}
				if(document.getElementById("angulo").value == 180){
					angulo270 = false;
					angulo180 = true;
					angulo225 = false;
					ang = 0.5;
				}
				if(document.getElementById("campo").value != anterior[k-1]){
					k++;
				}	

			if(areaPT){				
						contexto.clearRect(0,0,canvas.width,canvas.height);
						//if(pararr!=1){
							if(angulo180){
								contexto.drawImage(pequeno180[j],500,10,300,300);
								
								if(campoPT){contexto.drawImage(setas3[j],400,20,550,225);
									contexto.drawImage(fundoPequeno180[j],500,10,300,300);
									if(sentindoCorrenteInduzida){
										contexto.drawImage(campoGeradoPorCI180[d],500,10,300,300);
									}else{
										contexto.drawImage(campoGeradoPorCI180Invertido[d],500,10,300,300);
									}
								}
								if(campoMT){contexto.drawImage(setas5[j],400,20,550,225);
									if(j==3){contexto.drawImage(pequeno180[7],500,10,300,300);
									}	
									contexto.drawImage(fundoPequeno180[j],500,10,300,300);
									if(sentindoCorrenteInduzida){
										contexto.drawImage(campoGeradoPorCI180[d],500,10,300,300);
									}else{
										contexto.drawImage(campoGeradoPorCI180Invertido[d],500,10,300,300);
									}
								}
								if(campoGT){contexto.drawImage(setas7[j],400,20,550,225);
									if(j==3){contexto.drawImage(pequeno180[8],500,10,300,300);
									}
									contexto.drawImage(fundoPequeno180[j],500,10,300,300);
							    	if(sentindoCorrenteInduzida){
										contexto.drawImage(campoGeradoPorCI180[d],500,10,300,300);
									}else{
										contexto.drawImage(campoGeradoPorCI180Invertido[d],500,10,300,300);
									}
								}
								
							}
							if(angulo225){
								contexto.drawImage(pequeno225[j],500,-43,300,360);
								if(campoPT){contexto.drawImage(setas3[j],400,20,550,225);
									contexto.drawImage(fundoPequeno225[j],500,-43,300,360);
									if(sentindoCorrenteInduzida){
										contexto.drawImage(campoGeradoPorCI225[d],500,-43,300,360);
									}else{
										contexto.drawImage(campoGeradoPorCI225Invertido[d],500,-43,300,360);
									}

								}
								if(campoMT){contexto.drawImage(setas5[j],400,20,550,225);
									contexto.drawImage(fundoPequeno225[j],500,-43,300,360);
									if(sentindoCorrenteInduzida){
										contexto.drawImage(campoGeradoPorCI225[d],500,-43,300,360);
									}else{
										contexto.drawImage(campoGeradoPorCI225Invertido[d],500,-43,300,360);
									}
								}
								if(campoGT){contexto.drawImage(setas7[j],400,20,550,225);
									contexto.drawImage(fundoPequeno225[j],500,-43,300,360);
									if(sentindoCorrenteInduzida){
										contexto.drawImage(campoGeradoPorCI225[d],500,-43,300,360);
									}else{
										contexto.drawImage(campoGeradoPorCI225Invertido[d],500,-43,300,360);
									}
								}
								
							}
							if(angulo270){
								contexto.drawImage(pequeno270[j],500,0,300,300);
								if(campoPT){contexto.drawImage(setas3[j],400,20,550,225);
								contexto.drawImage(fundoPequeno270[j],500,0,300,300);}
								if(campoMT){contexto.drawImage(setas5[j],400,20,550,225);
								contexto.drawImage(fundoPequeno270[j],500,0,300,300);}
								if(campoGT){contexto.drawImage(setas7[j],400,20,550,225);
								contexto.drawImage(fundoPequeno270[j],500,0,300,300);}
								
							}
							document.getElementById("teste").innerHTML="φ = "+document.getElementById('campo').value * document.getElementById('area').value * ang + "T/m²";
						//}	
						setTimeout(play, 500);		
			}
				/*if(campoP225){
					contexto.clearRect(0,0,canvas.width,canvas.height);
					contexto.drawImage(pequeno225[j],500,10,300,300);
					contexto.drawImage(setas3[k],400,20,550,225);
					contexto.drawImage(fundoPequeno180[l],500,10,300,300);
						setTimeout(play, 500);
				}*/
				
			//if(document.getElementById("area").value >= 10 && document.getElementById("area").value < 12.5){
				
			//}
			
			
	}

	



</script>

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>


</html>