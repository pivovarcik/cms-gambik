<?php

/**
 * Funkce odstraní interpunkci a převede do latinky
 * @return int
 */
function utfx($s)
{

	$s = recky_to_latinka($s);

	unset($xsea);
	unset($xrep);
	unset($xsea);
	unset($xrep);
  $xsea[]='î';
  $xrep[]='i';
  
  $xsea[]='ê';
  $xrep[]='e';    
  $xsea[]='ø';
  $xrep[]='o';             
  $xsea[]='Ø';
  $xrep[]='O';
    
  $xsea[]='æ';
  $xrep[]='ae';
             
  $xsea[]='è';
  $xrep[]='e';              
  $xsea[]='ô';
  $xrep[]='o';
  $xsea[]='ñ';
	$xrep[]='n';
  
  $xsea[]='å';
	$xrep[]='a';
  
     
  $xsea[]='ń';
	$xrep[]='n';
	$xsea[]='ĺ';
	$xrep[]='l';
  
 	$xsea[]='ą';
	$xrep[]='a';
  
  $xsea[]='ę';
	$xrep[]='e'; 
  
  
 		$xsea[]='ł';
	$xrep[]='l';
 		$xsea[]='ć';
	$xrep[]='c';
 
  		$xsea[]='ż';
	$xrep[]='z'; 
  
     
	$xsea[]='ě';
	$xrep[]='e';
	$xsea[]='š';
	$xrep[]='s';
	$xsea[]='č';
	$xrep[]='c';
	$xsea[]='ř';
	$xrep[]='r';
	$xsea[]='ž';
	$xrep[]='z';
	$xsea[]='ý';
	$xrep[]='y';
	$xsea[]='í';
	$xrep[]='i';
	$xsea[]='á';
	$xrep[]='a';
	$xsea[]='é';
	$xrep[]='e';
	$xsea[]='ú';
	$xrep[]='u';
	$xsea[]='ň';
	$xrep[]='n';
	$xsea[]='Ě';
	$xrep[]='E';
	$xsea[]='Š';
	$xrep[]='S';
	$xsea[]='Č';
	$xrep[]='C';
	$xsea[]='Ř';
	$xrep[]='R';
	$xsea[]='Ž';
	$xrep[]='Z';
	$xsea[]='Í';
	$xrep[]='I';
	$xsea[]='Ď';
	$xrep[]='D';
	$xsea[]='Á';
	$xrep[]='A';
	$xsea[]='É';
	$xrep[]='E';
	$xsea[]='Ý';
	$xrep[]='Y';
	$xsea[]='Ú';
	$xrep[]='U';
	$xsea[]='Ů';
	$xrep[]='U';
	$xsea[]='Ť';
	$xrep[]='T';
	$xsea[]='Ň';
	$xrep[]='N';
	$xsea[]='ů';
	$xrep[]='u';
	$xsea[]='Ö';
	$xrep[]='O';
	$xsea[]='ö';
	$xrep[]='o';
	$xsea[]='ü';
	$xrep[]='u';
	$xsea[]='ť';
	$xrep[]='t';
	$xsea[]='ď';
	$xrep[]='d';
	$xsea[]='ľ';
	$xrep[]='l';
	$xsea[]='Ć';
	$xrep[]='C';
	$xsea[]='Ü';
	$xrep[]='U';
	$xsea[]='ó';
	$xrep[]='o';
	$xsea[]='ű';
	$xrep[]='u';
	$xsea[]='ä';
	$xrep[]='a';
	$xsea[]='Ó';
	$xrep[]='O';
	$xsea[]='Ĺ';
	$xrep[]='L';



	$xsea[]='Б';
	$xrep[]='B';

	$xsea[]='б';
	$xrep[]='b';


	$xsea[]='ß';
	$xrep[]='ss'; 



	$xsea[]='в';
	$xrep[]='v';

	$xsea[]='г';
	$xrep[]='g';

	$xsea[]='Г';
	$xrep[]='G';

	$xsea[]='д';
	$xrep[]='d';

	$xsea[]='Д';
	$xrep[]='D';
	$xsea[]='ё';
	$xrep[]='jo';

	$xsea[]='е';
	$xrep[]='e';

	$xsea[]='ж';
	$xrep[]='z';
	$xsea[]='з';
	$xrep[]='z';
	$xsea[]='Ж';
	$xrep[]='Z';
	$xsea[]='З';
	$xrep[]='Z';
	$xsea[]='и';
	$xrep[]='i';
	$xsea[]='И';
	$xrep[]='I';

	$xsea[]='й';
	$xrep[]='j';

	$xsea[]='Й';
	$xrep[]='J';
	$xsea[]='к';
	$xrep[]='k';
	$xsea[]='К';
	$xrep[]='K';
	$xsea[]='л';
	$xrep[]='l';
	$xsea[]='Л';
	$xrep[]='L';
	$xsea[]='м';
	$xrep[]='m';

	$xsea[]='н';
	$xrep[]='n';

	$xsea[]='п';
	$xrep[]='p';
	$xsea[]='П';
	$xrep[]='P';

	$xsea[]='о';
	$xrep[]='o';

	$xsea[]='ы';
	$xrep[]='y';

	$xsea[]='ь';
	$xrep[]='';

	$xsea[]='э';
	$xrep[]='e';




	$xsea[]='т';
	$xrep[]='t';
	$xsea[]='у';
	$xrep[]='u';

	$xsea[]='Ф';
	$xrep[]='F';

	$xsea[]='ф';
	$xrep[]='f';

	$xsea[]='С';
	$xrep[]='C';

	$xsea[]='Е';
	$xrep[]='E';

	$xsea[]='М';
	$xrep[]='M';


	$xsea[]='Н';
	$xrep[]='H';

		$xsea[]='Т';
	$xrep[]='T';

	$xsea[]='А';
	$xrep[]='A';
	$xsea[]='а';
	$xrep[]='a';


	$xsea[]='Р';
	$xrep[]='R';

	$xsea[]='р';
	$xrep[]='r';

	$xsea[]='с';
	$xrep[]='s';

	$xsea[]='х';
	$xrep[]='ch';

	$xsea[]='ц';
	$xrep[]='c';

	$xsea[]='щ';
	$xrep[]='sc';

	$xsea[]='ъ';
	$xrep[]='';



	$xsea[]='ю';
	$xrep[]='ju';
	$xsea[]='Ю';
	$xrep[]='Ju';

	$xsea[]='я';
	$xrep[]='ja';
	$xsea[]='Я';
	$xrep[]='Ja';

	$xsea[]='ч';
	$xrep[]='c';
	$xsea[]='Ч';
	$xrep[]='C';

	$xsea[]='ш';
	$xrep[]='s';
	$xsea[]='Ш';
	$xrep[]='S';

	$xsea[]='ů';
	$xrep[]='u';

	$xsea[]='ď';
	$xrep[]='d';
	$xsea[]='í';
	$xrep[]='i';
	$xsea[]='ř';
	$xrep[]='r';
	$xsea[]='á';
	$xrep[]='a';


	$xsea[]='ý';
	$xrep[]='y';
	$xsea[]='š';
	$xrep[]='s';
	$xsea[]='ě';
	$xrep[]='e';
	$xsea[]='é';
	$xrep[]='e';


	$xsea[]='ó';
	$xrep[]='o';
	$xsea[]='ť';
	$xrep[]='t';
	$xsea[]='č';
	$xrep[]='c';
	$xsea[]='ž';
	$xrep[]='z';




	/*
	   а А a A ,
	   б Б b B,
	   в В v V,
	   г Г g G, д Д d D,
	   е Е je Je,
	   ё Ё jo Jo;
	   ж Ж ž Ž;
	   з З z Z;
	   и И i I;
	   й Й j J;
	   к К k K;
	   л Л l L;
	   м М m M;
	   н Н n N;
	   о О o O;
	   п П p P;
	   р Р r R;
	   с С s S;
	   т Т t T;
	   у У u U;
	   ф Ф f F;
	   х Х ch Ch;
	   ц Ц c C;
	   ч Ч č Č;
	   ш Ш š Š ;
	   щ Щ šč Šč;
	   ъ Ъ tvrdý znak ы Ы;
	   y Y ь Ь ;
	   měkký znak э Э e E ;
	   ю Ю ju Ju ;
	   я Я ja Ja
	*/
	return str_replace($xsea, $xrep, $s);
}

function recky_to_latinka($s){


	unset($xsea);
	unset($xrep);



	$xsea[]="'";
	$xrep[]="'";

		$xsea[]='&';
	$xrep[]='&';

	$xsea[]='Α';
	$xrep[]='A';

	$xsea[]='α';
	$xrep[]='a';

	$xsea[]='ά';
	$xrep[]='a';


	$xsea[]='Β';
	$xrep[]='B';

	$xsea[]='β';
	$xrep[]='b';

	$xsea[]='Γ';
	$xrep[]='G';

	$xsea[]='γ';
	$xrep[]='g';


	$xsea[]='Δ';
	$xrep[]='D';

	$xsea[]='δ';
	$xrep[]='d';



	$xsea[]='Ε';
	$xrep[]='E';

	$xsea[]='Έ';
	$xrep[]='E';


	$xsea[]='ε';
	$xrep[]='e';

	$xsea[]='έ';
	$xrep[]='e';



	$xsea[]='Ζ';
	$xrep[]='Z';

	$xsea[]='ζ';
	$xrep[]='dz';


	$xsea[]='Η';
	$xrep[]='E';

	$xsea[]='η';
	$xrep[]='e';

	$xsea[]='ή';
	$xrep[]='e';


	$xsea[]='Θ';
	$xrep[]='th';

	$xsea[]='θ';
	$xrep[]='th';


	$xsea[]='Ι';
	$xrep[]='I';

	$xsea[]='ι';
	$xrep[]='i';

	$xsea[]='ί';
	$xrep[]='i';


	$xsea[]='Κ';
	$xrep[]='K';

	$xsea[]='κ';
	$xrep[]='k';


	$xsea[]='Λ';
	$xrep[]='L';

	$xsea[]='λ';
	$xrep[]='l';


	$xsea[]='Μ';
	$xrep[]='M';

	$xsea[]='μ';
	$xrep[]='m';


	$xsea[]='Ν';
	$xrep[]='N';

	$xsea[]='ν';
	$xrep[]='n';

	$xsea[]='Ξ';
	$xrep[]='X';

	$xsea[]='ξ';
	$xrep[]='x';

	$xsea[]='Ο';
	$xrep[]='O';

	$xsea[]='ο';
	$xrep[]='o';

	$xsea[]='ό';
	$xrep[]='o';



	$xsea[]='Π';
	$xrep[]='P';


	$xsea[]='π';
	$xrep[]='p';

	$xsea[]='Ρ';
	$xrep[]='R';

	$xsea[]='ρ';
	$xrep[]='r';

	$xsea[]='Σ';
	$xrep[]='S';

	$xsea[]='σ';
	$xrep[]='s';

	$xsea[]='ς';
	$xrep[]='s';


	$xsea[]='Τ';
	$xrep[]='T';

	$xsea[]='τ';
	$xrep[]='t';

	$xsea[]='Υ';
	$xrep[]='Y';

	$xsea[]='υ';
	$xrep[]='y';

	$xsea[]='ύ';
	$xrep[]='y';



	$xsea[]='Φ';
	$xrep[]='F';

	$xsea[]='φ';
	$xrep[]='f';

	$xsea[]='Χ';
	$xrep[]='CH';

	$xsea[]='χ';
	$xrep[]='ch';

	$xsea[]='Ψ';
	$xrep[]='PS';

	$xsea[]='ψ';
	$xrep[]='ps';

	$xsea[]='Ω';
	$xrep[]='O';




	$xsea[]='ω';
	$xrep[]='o';

	$xsea[]='ώ';
	$xrep[]='o';


  	$xsea[]='Χ';
	$xrep[]='X';
  
    	$xsea[]='Β';
	$xrep[]='B';
        	$xsea[]='’';
	$xrep[]="'";  
	return str_replace($xsea, $xrep, $s);
}