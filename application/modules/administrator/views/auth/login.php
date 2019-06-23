<div class="login-box-body">
  <p class="login-box-msg">Sign in to start your session</p>
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
  <?php echo form_open("administrator/auth/login");?>
    <div class="form-group has-feedback">
      <?php echo form_input($identity);?>
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <?php echo form_input($password);?>
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
      <div class="col-xs-8">
        <div class="checkbox icheck">
          <label>
            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?> Remember Me
          </label>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-xs-4">
        <?php echo form_submit('submit', lang('login_submit_btn'), "class='btn btn-primary btn-block btn-flat'");?>
      </div>
      <!-- /.col -->
    </div>
  <?php echo form_close();?>
  <a href="<?=site_url('administrator/auth/forgot_password')?>">I forgot my password</a>
</div>