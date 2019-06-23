
<div class="box box-default" id="close-search" style="display: none;">
  <div class="box-header with-border">
    <h3 class="box-title">Custom Filter : </h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <form id="form-filter" class="form-horizontal">
      <div class="col-lg-4">
        <label for="tema">NIP</label>        
        <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa fa-object-group fa-lg" aria-hidden="true"></i>
            </div>
            <input class="form-control" placeholder="nip" type="text" id="nip" />          
        </div>
      </div>
      <div class="col-lg-4">
        <label for="tema">NAMA PEGAWAI</label>        
        <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa fa-object-group fa-lg" aria-hidden="true"></i>
            </div>
            <input class="form-control" placeholder="Nama Pegawai" type="text" id="nm_pegawai" />          
        </div>
      </div>
      <div class="col-lg-6">
        <label for="filter"></label>        
        <div class="input-group">
            <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
        </div>
      </div>
    </form>
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
    <!-- box-footer -->
  </div>
</div>
<script src="<?=base_url().takeJsAdmin()['js2']?>"></script>
<link rel="stylesheet" href="<?=base_url().takeCssAdmin()['css12']?>">
<script type="text/javascript">
  $( "#nip" ).autocomplete({
    source: "<?php echo site_url('administrator/dataPegawai/get_autocomplete/?');?>"
  });

  $( "#nm_pegawai" ).autocomplete({
    source: "<?php echo site_url('administrator/dataPegawai/get_autocomplete_name/?');?>"
  });
</script>
