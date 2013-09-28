<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
#use app\assets;
use app\js;

/**
 * @var $this \yii\base\View
 * @var $content string
 */
app\config\AppAsset::register($this);
#app\js\KnockoutAsset::register($this);
app\js\NoteAppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="<?php echo Yii::$app->charset; ?>"/>
	<title><?php echo Html::encode($this->title); ?></title>
	<?php $this->head(); ?>
</head>
<body id="body">
<?php $this->beginBody(); ?>

	<a href="https://github.com/noxstyle/noteapp" class="github visible-lg visible-md"><img src="https://s3.amazonaws.com/github/ribbons/forkme_left_darkblue_121621.png" alt="Fork me on GitHub"></a>

	<header id="header">
		<h1><span class="title-em">N</span>ote<span class="title-em">A</span>pp</h1>
		<p class="lead">An Yii2 + Knockout.js experiment...</p>

		<div class="app-actions pull-right">
			<button id="new-note" class="btn btn-primary" data-bind="click: addNote">New Note</button>
			<button id="save-notes" class="btn btn-primary" data-bind="click: saveNote">Save Notes</button>
		</div><!-- /.app-actions -->

	</header><!-- /#header -->

	<div class="container">
		<?php echo $content; ?>
	</div>

	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p class="pull-left">noxstyle.info @ <?php echo date('Y'); ?></p>
					<p class="pull-right">
						<?php echo Yii::powered(); ?>
						&amp; <a href="http://knockoutjs.com">Knockout.js</a>
					</p>
				</div>
			</div><!-- /.row -->
		</div>
	</footer>

	<div id="status">
		<p>Some status text here</p>
	</div>

</div>

<?php $this->endBody(); ?>
<script>
/*
	$(document).ready(function(){
		$('#testt').select2({
			tags:["PHP","Knockout"],
			tokenSeparators: [","]
		});
	});*/
</script>
</body>
</html>
<?php $this->endPage(); ?>
