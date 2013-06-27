<?php

/* @var $this TvShowController */
/* @var $details stdClass */

$pageTitle = $details->title;
if (!empty($details->year))
	$pageTitle .= ' ('.$details->year.')';

$this->pageTitle = $pageTitle;

?>
<div class="item-details">
	<div class="row">
		<div class="span3">
			<?php echo CHtml::image(new ThumbnailTVShow($details->thumbnail, 
					Thumbnail::THUMBNAIL_SIZE_LARGE), '', array(
				'class'=>'item-thumbnail hidden-phone',
			)); ?>
		</div>
		
		<div class="span9 item-description">
			<div class="item-top row-fluid">
				<div class="item-title span6">
					<h2>
						<?php echo $details->title; ?>
					</h2>

					<?php if(!empty($details->year))
						echo '<p>('.$details->year.')</p>'; ?>
				</div>
			</div>
			
			<div class="item-info clearfix">
				
				<?php
				
				$rating = (int)$details->rating;
				
				if ($rating > 0)
					$this->renderPartial('/videoLibrary/_rating', array('rating'=>$rating));
				
				?>
				
				<div class="pull-left">

					<div class="item-metadata clearfix">

						<p><?php echo implode(' / ', $details->genre); ?></p>

						<?php

						// MPAA rating is not always available
						if ($details->mpaa)
							echo '<p>MPAA rating: '.$details->mpaa.'</p>';
						
						?>
					</div>

				</div>
			</div>
			
			<h3>Plot</h3>
			
			<div class="item-plot">
				<p><?php echo $details->plot; ?></p>
			</div>
			
			<h3>Seasons</h3>
			
			TODO
		</div>
	</div>
</div>