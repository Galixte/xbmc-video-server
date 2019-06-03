<?php

/* @var $filterForm MovieFilterForm */
/* @var $dataProvider LibraryDataProvider */
$this->pageTitle = $title = Yii::t('TVShows', 'TV shows');

?>
<h2><?php echo $title; ?></h2>

<?php 

$this->widget('TVShowFilter', array(
	'model'=>$filterForm));

$this->renderPartial('//videoLibrary/_results', array(
	'dataProvider'=>$dataProvider,
	'widgetList'=>'ResultListTVShows'));
