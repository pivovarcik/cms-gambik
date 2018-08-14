<?php

/**
 * Funkce převede znaky z latinky do azbuky
 * @return int
 */
function latinToAzbuka($s)
{
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

	$xsea[]='а';
	$xrep[]='a';
	$xsea[]='А';
	$xrep[]='A';
	$xsea[]='б';
	$xrep[]='b';
	$xsea[]='Б';
	$xrep[]='B';
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
	$xsea[]='е';
	$xrep[]='je';
	$xsea[]='е';
	$xrep[]='je';
	$xsea[]='E';
	$xrep[]='Je';
	$xsea[]='ё';
	$xrep[]='jo';
	$xsea[]='Ё';
	$xrep[]='Jo';
	$xsea[]='ж';
	$xrep[]='ž';
	$xsea[]='з';
	$xrep[]='z';
	$xsea[]='Ж';
	$xrep[]='Ž';
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
	$xsea[]='Н';
	$xrep[]='N';
	$xsea[]='п';
	$xrep[]='p';
	$xsea[]='П';
	$xrep[]='P';

	$xsea[]='р';
	$xrep[]='r';
	$xsea[]='P';
	$xrep[]='R';

	$xsea[]='о';
	$xrep[]='o';
	$xsea[]='О';
	$xrep[]='O';


	$xsea[]='c';
	$xrep[]='s';
	$xsea[]='C';
	$xrep[]='S';


	$xsea[]='т';
	$xrep[]='t';
	$xsea[]='у';
	$xrep[]='u';
	$xsea[]='Ф';
	$xrep[]='F';
	$xsea[]='ф';
	$xrep[]='f';

	$xsea[]='x';
	$xrep[]='ch';
	$xsea[]='X';
	$xrep[]='Ch';
	$xsea[]='ю';
	$xrep[]='ju';
	$xsea[]='Ю';
	$xrep[]='Ju';

	$xsea[]='я';
	$xrep[]='ja';
	$xsea[]='Я';
	$xrep[]='Ja';

	$xsea[]='ч';
	$xrep[]='č';
	$xsea[]='Ч';
	$xrep[]='Č';

	$xsea[]='ш';
	$xrep[]='š';
	$xsea[]='Ш';
	$xrep[]='Š';

	return str_replace($xsea, $xrep, $s);
}