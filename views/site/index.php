<?php
/**
 * @var yii\base\View $this
 */
$this->title = 'My Yii Application';

//$koInitJS = <<<KOINIT
//KOINIT;
//$this->registerJs($koInitJS)
?>

<div class="row">
	
	<div class="col-md-3">
		
		<h2 class="title-white">Tags</h2>
		<?php echo $this->render('/tag/_list') ?>

	</div><!-- /.col-md-4 -->
	
	<div class="col-md-9">
		<h2 class="title-white">Notes</h2>
		<?php echo $this->render('/note/_notes') ?>
	</div><!-- /.col-md-8 -->

</div><!-- /.row -->

<script>

</script>