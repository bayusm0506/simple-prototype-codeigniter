<div class="login-box-body">
  <p class="login-box-msg"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
    <?php
      if (isset($message)) {
    ?>
      <div class="alert alert-danger alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-window-close" aria-hidden="true"></i></a>
        <strong><?=lang('login_error')?></strong> <?=$message?>
      </div>
    <?php
      }
    ?>
  <?php echo form_open("administrator/auth/forgot_password");?>
    <div class="form-group has-feedback">
      <?php echo form_input($identity);?>
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="row">
	  <div class="col-xs-8">
	        
	  </div>
      <!-- /.col -->
      <div class="col-xs-4">
        <?php echo form_submit('submit', lang('forgot_password_submit_btn'), "class='btn btn-primary btn-block btn-flat'");?>
      </div>
      <!-- /.col -->
    </div>
  <?php echo form_close();?>
  <a href="<?=site_url('administrator/auth/login')?>">Back to Sign In</a>
</div>
