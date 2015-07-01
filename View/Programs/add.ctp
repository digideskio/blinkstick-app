<nav class="navbar navbar-inverse navbar-embossed" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
      <span class="sr-only">Toggle navigation</span>
    </button>
        <?php echo $this->Html->link(__('BlinkStick App'), array('action' => 'index'), array('class'=>'navbar-brand')); ?>
  </div>
  <div class="collapse navbar-collapse" id="navbar-collapse-01">
    <ul class="nav navbar-nav navbar-left">
      <li><?php echo $this->Html->link(__(''), array('action' => 'edit','controller'=>'users'), array('class'=>'fui-gear')); ?></li>
     </ul>
  </div><!-- /.navbar-collapse -->
</nav><!-- /navbar -->

<?php echo $this->Session->flash(); ?>


<div id="tableContainer" style="background-color:#2f4154; border-radius:6px; border-style:solid; border-width:6px; border-color:#2f4154;">
</div>
<div class="programs form">
<?php echo $this->Form->create('Program'); ?>
	<fieldset>
		<!--legend><?php echo __('Add Program'); ?></legend-->
	<?php
		echo $this->Form->input('value', array('type'=>'hidden'));
	?>
	</fieldset>
<!--?php echo $this->Form->end(__('Submit')); ?-->
</div>
<script>
initEditor("#ProgramValue", "#tableContainer", "ProgramAddForm");
</script>
