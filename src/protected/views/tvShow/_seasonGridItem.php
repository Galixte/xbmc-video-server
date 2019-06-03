<?php

/* @var $this TvShowController */
/* @var $data Season */

$itemUrl = $this->createUrl('season', array('tvshowid'=>$data->tvshowid, 'season'=>$data->season));
$thumbnail = ThumbnailFactory::create($data->getArtwork(),
	Thumbnail::SIZE_MEDIUM, ThumbnailFactory::THUMBNAIL_TYPE_SEASON);

$this->renderPartial('//videoLibrary/_gridItem', array(
	'label'=>CHtml::link($data->label, $itemUrl).CHtml::tag('p', array(), $data->getEpisodesString()),
	'itemUrl'=>$itemUrl,
	'thumbnail'=>$thumbnail,
));
