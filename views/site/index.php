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
		
		<!--<h2 class="title-white">Search</h2>
		<form action="#">
			<input type="text">
		</form>-->

		<h2 class="title-white">Tags</h2>
		<?php //echo $this->render('/tag/_list', array()) ?>
		<ul id="tags" data-bind="foreach: {data: tags, as: 'tag'}">
			<?php // visible: $root.getNotesByTag(tag).length > 0 ?>
		    <li data-bind="css: { 'active': active() }">
		    	<a href="#" data-bind="click: $parent.showNotesForTag">
		    		<span data-bind="text: name"></span>
		    		<strong data-bind="text: $root.getNotesByTag(tag).length"></strong>
		    	</a>
	    		<ul data-bind="foreach: {data: $root.getNotesByTag(tag), as: 'note'}, style: { display: active() ? 'block' : 'none'}">
	    			<li>
	    				<a href="#" data-bind="disableClick: note.active(), click: $root.openNote, text: note.title, css: {active: note.active()}"></a>
	    			</li>
	    		</ul>
		    </li>
		</ul>

	</div><!-- /.col-md-4 -->
	
	<div class="col-md-9">
		<h2 class="title-white">Notes</h2>
		<?php echo $this->render('/note/_notes') ?>
	</div><!-- /.col-md-8 -->
<?php
/*
<form data-bind="submit: addItem">
    New item:
    <input data-bind='value: itemToAdd, valueUpdate: "afterkeydown"' />
    <button type="submit" data-bind="enable: itemToAdd().length > 0">Add</button>
    <p>Your items:</p>
    <select multiple="multiple" width="50" data-bind="options: items"> </select>
</form>
*/ ?>



</div><!-- /.row -->

<script>

</script>