<div class="container" style="width:340px">
<p>
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User');?>
    <fieldset>
        <!--legend><?php echo __('Please enter your username and password'); ?></legend-->
    <?php
        echo $this->Form->input('username',array('class'=>'form-control'));
        echo $this->Form->input('password',array('class'=>'form-control'));
    ?>
    </fieldset>
    <p>
    <?php echo $this->Form->submit("Login",array('class'=>'btn btn-block btn-lg btn-primary'));?></p>
<!--?php echo $this->Form->end(__('Login'), array('class'=>'btn btn-block btn-lg btn-primary'));?-->
</p>
</div>