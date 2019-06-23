<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Data
    <small>Pegawai</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Lihat</a></li>
    <li class="active"><?=$title?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- SELECT2 EXAMPLE -->
<?php $this->load->view('dataPegawai/_form'); ?>
<?php $this->load->view('dataPegawai/_search'); ?>
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$title?></h3>
    <div class="box-tools pull-right">
      <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
      <button type="button" class="btn bg-maroon btn-flat" onclick="add_pegawai()">
          <i class="fa fa-plus"></i> Tambah Data
      </button>
      <button class="btn bg-olive btn-flat" onclick="custom_filter()">
          <i class="fa fa-gear"></i> <span id="custom"></span>
      </button>
    </div>
  </div>
<!-- /.box-header -->
  <?php $this->load->view('dataPegawai/_dataTable'); ?>
</div>
<!-- /.box -->
</section>
<!-- /.content -->

<script type="text/javascript">
  var save_method; //for save method string
  var table;
  var base_url = '<?php echo base_url();?>';
  $("#custom").text('Filter');

  function custom_filter() {
      var x = document.getElementById("close-search");
      if (x.style.display === "block") {
          x.style.display = "none";
          $("#custom").text('Filter');
      } else {
          x.style.display = "block";
          $("#custom").text('Close Filter');
      }
  }

  $(document).ready(function() {
      //datatables
      table = $('#table').DataTable({ 
          language: {
              //search: "_INPUT_",
              searchPlaceholder: "Cari Disini..."
          },
          dom: 'Blfrtip',
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'pdfHtml5'
          ],
          "pagingType": "full_numbers",
          "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [], //Initial no order.

          // Load data for the table's content from an Ajax source
          "ajax": {
              "url": "<?php echo site_url('administrator/dataPegawai/ajax_list')?>",
              "type": "POST",
              "data": function ( data ) {
                  data.nip = $('#nip').val();
                  data.nm_pegawai = $('#nm_pegawai').val();
              }
          },

          //Set column definition initialisation properties.
          "columnDefs": [
            { 
                "targets": [ 0,-1 ], //last column
                "orderable": false, //set not orderable
            },
          ],

      });

      //datepicker
      // $('.datepicker').datepicker({
      //     autoclose: true,
      //     format: "yyyy-mm-dd",
      //     todayHighlight: true,
      //     //orientation: "top auto",
      //     todayBtn: true,
      //     todayHighlight: true,  
      // });

      $("input").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });
      $("input[type=radio]").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });
      $("textarea").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });
  });

  $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table
  });
  
  $('#btn-reset').click(function(){ //button reset event click
      $('#form-filter')[0].reset();
      table.ajax.reload();  //just reload table
  });

  function add_pegawai()
  {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Tambah Pegawai'); // Set Title to Bootstrap modal title
  }

  function reload_table()
  {
      table.ajax.reload(null,false); //reload datatable ajax 
  }

  function delete_pegawai(id)
  {
    swal({
      title: "Are you sure?",
      text: "You will delete this Record!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel plx!",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
          type: 'POST',
          url: '<?php echo site_url('administrator/dataPegawai/delete')?>',
          data: 'empid='+id
        });
        reload_table();
        swal("Deleted!", "Record has been deleted.", "success");

      } else {
        swal("Cancelled", "Your Record is safe :)", "error");
      }
    });
  }
</script>
<script type="text/javascript">

  function edit_pegawai(id)
  {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string


      //Ajax Load data from ajax
      $.ajax({
          url : "<?php echo site_url('administrator/dataPegawai/ajax_edit')?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
              $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Edit Pegawai'); // Set title to Bootstrap modal title

              $('[name="nip"]').val(data.NIP);
              $('[name="nm_pegawai"]').val(data.NM_PEGAWAI);

              $('[name="nip"]').prop('readonly', true);
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error get data from ajax');
          }
      });
  }

  function save()
  {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable 
      var url;

      if(save_method == 'add') {
          url = "<?php echo site_url('administrator/dataPegawai/save')?>";
      } else {
          url = "<?php echo site_url('administrator/dataPegawai/edit')?>";
      }

      // ajax adding data to database

      var formData = new FormData($('#form')[0]);
      $.ajax({
          url : url,
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "JSON",
          success: function(data)
          {
              if(data.status) //if success close modal and reload ajax table
              {
                $('#modal_form').modal('hide');
                reload_table();
                $.notify(data.msg,"success");
              }
              else
              {
                  for (var i = 0; i < data.inputerror.length; i++) 
                  {
                      $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                      $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                  }
              }
              $('#btnSave').text('save'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable 
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error adding / update data');
              $('#btnSave').text('save'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable 
          }
      });
  }
</script>