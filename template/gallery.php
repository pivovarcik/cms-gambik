<?php
///////////////////////////////////////////////////////////////////
/*
$params = array();
$params['gallery_id'] = (int) PAGE_ID;
$params['gallery_type'] = T_CATEGORY;
$fotoController = new FotoController();
$fotoGallery = $fotoController->fotoUmisteniList($params);

*/
///////////////////////////////////////////////////////////////

$res = '<div class="photogalery">';
if (count($fotoGallery)>0)
{
	$width = 180;
	$height = 150;
	$imageController = new ImageController();
	for ($i=0;$i < count($fotoGallery);$i++)
	{

		if (!empty($fotoGallery[$i]->file) && $fotoGallery[$i]->id  != $main->foto_id)
		{
			$fullsizeUrl = $imageController->resize($fotoGallery[$i]->file,640,640,PATH_WATERMARK);
			$PreviewUrl = $imageController->get_thumb($fotoGallery[$i]->file,$width,$height,null,false,false);

			$res .= '<div class="foto_item">';
			$res .= '<a title="" href="' . $fullsizeUrl . '" rel="lightbox[roadtrip]" class="lightbox"><img class="imgobal" src="' . $PreviewUrl . '" alt="' . $fotoGallery[$i]->titulek . '"/></a>';
			$res .= '</div>';
		}
	}

	$res .= '<div class="clear"> </div>';

} else {

	//$res .= 'galerie produktu je prázdná!';
}

$res .= '</div>';
print $res;
?>