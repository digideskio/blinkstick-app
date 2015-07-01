<nav class="navbar navbar-inverse navbar-embossed" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
      <span class="sr-only">Toggle navigation</span>
    </button>
    <?php echo $this->Html->link(__('BlinkStick App'), array('action' => 'index'), array('class'=>'navbar-brand')); ?>
  </div>
  <div class="collapse navbar-collapse" id="navbar-collapse-01">
    <ul class="nav navbar-nav navbar-left">
      <li><?php echo $this->Html->link(__(''), array('action' => 'add'), array('class'=>'fui-plus')); ?></li>
      <li><?php echo $this->Html->link(__(''), array('action' => 'edit','controller'=>'users'), array('class'=>'fui-gear')); ?></li>
     </ul>
  </div><!-- /.navbar-collapse -->
</nav><!-- /navbar -->

<?php echo $this->Session->flash(); ?>

<div class="programs index">

	<?php if($currentProgram){ ?>
	<div style="border-color:#1abc9c;border-style:solid;border-width:4px;border-radius:6px;margin-bottom:20px;">
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tbody>
			<?php $program = $currentProgram; ?>
				<tr style="border-style:solid; border-width:5px; border-color:#fff">
					<td>
						<div id="currentTableContainer" style="background-color:#2f4154; border-radius:6px; border-style:solid; border-width:6px; border-color:#2f4154;">
						</div>

						<script>
							generateVisualTable(
								$("#currentTableContainer"),
									100,
									100);
							var programValue = '<?php echo $program["Program"]["value"]; ?>';
							loadModel({value:programValue},100);
							iteration(100,100);
						</script>
					</td>
					<td>&nbsp;
						<?php echo $this->Html->link(__(''), array('action' => 'edit', $program['Program']['id']), array("class"=>"fui-list")); ?>
					</td>
					<td>&nbsp;
						<?php echo $this->Form->postLink(__(''), array('action' => 'delete', $program['Program']['id']), array("class"=>"fui-trash"), __('Are you sure you want to delete # %s?', $program['Program']['id'])); ?>
					</td>
					<td>&nbsp;
						<?php echo $this->Html->link(__(''), array('action' => 'select', $program['Program']['id']), array("class"=>"fui-radio-checked")); ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php } ?>


	<div>
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tbody>
			<?php $programIndex = 0;?>
			<?php foreach ($programs as $program): ?>
				<tr style="border-style:solid; border-width:5px; border-color:#fff">
					<td>
						<div id="tableContainer<?php echo $program['Program']['id']; ?>" style="background-color:#2f4154; border-radius:6px; border-style:solid; border-width:6px; border-color:#2f4154;">
						</div>

						<script>
							generateVisualTable(
								$("#tableContainer<?php echo $program['Program']['id']; ?>"),
								<?php echo $programIndex;?>,
								<?php echo $programIndex;?>);
							var programValue = '<?php echo $program["Program"]["value"]; ?>';
							loadModel({value:programValue},<?php echo $programIndex;?>);
							iteration(<?php echo $programIndex;?>,<?php echo $programIndex;?>);
						</script>
					</td>
					<td>&nbsp;
						<?php echo $this->Html->link(__(''), array('action' => 'edit', $program['Program']['id']), array("class"=>"fui-list")); ?>
					</td>
					<td>&nbsp;
						<?php echo $this->Form->postLink(__(''), array('action' => 'delete', $program['Program']['id']), array("class"=>"fui-trash"), __('Are you sure you want to delete # %s?', $program['Program']['id'])); ?>
					</td>
					<td>&nbsp;
						<?php echo $this->Html->link(__(''), array('action' => 'select', $program['Program']['id']), array("class"=>"fui-radio-unchecked")); ?>
					</td>
				</tr>
			<?php $programIndex += 1;?>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div>
		<?php
		echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}')
		));
		?>
	</div>
	<div class="pagination">
		<ul>
			<li class="previous"><?php
			echo $this->Paginator->prev('<', array('class' => 'previous'), null, array('class' => 'previous'));?>
			</li>
			<?php
			echo $this->Paginator->numbers(array('separator' => '','tag'=>'li', 'currentTag'=>'a', 'currentClass'=>'active'));
			?>
			<li class="next">
			<?php
			echo $this->Paginator->next('>', array('class' => 'next'), null, array('class' => 'next'));
			?>
			</li>
		</ul>
	</div>
</div>

