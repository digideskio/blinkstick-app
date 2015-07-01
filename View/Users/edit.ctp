<nav class="navbar navbar-inverse navbar-embossed" role="navigation" >
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
      <span class="sr-only">Toggle navigation</span>
    </button>
    <?php echo $this->Html->link(__('BlinkStick App'), array('controller'=>'programs', 'action' => 'index'), array('class'=>'navbar-brand')); ?>
  </div>
  <div class="collapse navbar-collapse" id="navbar-collapse-01">
    <ul class="nav navbar-nav navbar-left">
		<li><?php echo $this->Html->link(__('Services'), array('controller'=>'services','action' => 'index')); ?></li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Logout'), array('action' => 'logout')); ?></li>
     </ul>
  </div><!-- /.navbar-collapse -->
</nav><!-- /navbar -->

<div class="grid_12">
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('role');
		echo $this->Form->input('service_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
</div>
