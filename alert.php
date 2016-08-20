<?php //in Controller
if($eventList > 6) {
			Yii::$app->session->setFlash('maxEvent', "<b><i class='fa fa-warning'></i> Maximum Events Limit Reached, you can not add more event for this day</b>");
			return $this->redirect(['index']);
		} 

?>
<?php //in view
	if(\Yii::$app->session->hasFlash('maxEvent')) 
      {
?>
<div class="col-xs-12 no-padding">
    <div class="alert alert-warning alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo \Yii::$app->session->getFlash('maxEvent'); ?>
    </div>
</div>
<?php
      } 
?>