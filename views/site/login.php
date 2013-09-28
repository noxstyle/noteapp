<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\base\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\LoginForm $model
 */
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
	<h1><?php echo Html::encode($this->title); ?></h1>

	<p>Please fill out the following fields to login:</p>

	<div class="row">
		<div class="col-lg-3">
			<?php $form = ActiveForm::begin(array('id' => 'login-form')); ?>
				<?php echo $form->field($model, 'username'); ?>
				<?php echo $form->field($model, 'password')->passwordInput(); ?>
				<?php echo $form->field($model, 'rememberMe')->checkbox(); ?>
				<div class="form-group">
					<?php echo Html::submitButton('Login', array('class' => 'btn btn-primary')); ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
		<div class="col-lg-5" style="color:#999;margin:1em;padding-top:60px">
			You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
			To modify the username/password, please check out the code <code>app\models\User::$users</code>.
		</div>
	</div>
</div>
