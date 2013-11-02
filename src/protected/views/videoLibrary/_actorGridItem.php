<?php

/* @var $this MovieController */

// Unlike movies and TV shows, actors don't always have the thumbnail property
$thumbnailPath = isset($data->thumbnail) ? $data->thumbnail : '';
$thumbnail = new ThumbnailActor($thumbnailPath, Thumbnail::SIZE_SMALL);

$label = $data->name.' as <em>'.$data->role.'</em>';

if(!isset($itemUrl))
	$itemUrl = false;

$this->renderPartial('//videoLibrary/_gridItem', array(
	'label'=>$label,
	'itemUrl'=>$itemUrl,
	'thumbnail'=>$thumbnail,
));