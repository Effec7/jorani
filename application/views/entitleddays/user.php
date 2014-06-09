<?php
CI_Controller::get_instance()->load->helper('language');
$this->lang->load('entitleddays', $language);?>

<table class="table table-bordered table-hover" id="entitleddaysuser">
<thead>
    <tr>
      <th>&nbsp;</th>
      <th><?php echo lang('entitleddays_user_index_thead_start');?></th>
      <th><?php echo lang('entitleddays_user_index_thead_end');?></th>
      <th><?php echo lang('entitleddays_user_index_thead_days');?></th>
      <th><?php echo lang('entitleddays_user_index_thead_type');?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($entitleddays as $days) { ?>
    <tr data-id="<?php echo $days['id'] ?>">
      <td><a href="#" onclick="delete_entitleddays(<?php echo $days['id'] ?>);" title="<?php echo lang('entitleddays_user_index_thead_tip_delete');?>"><i class="icon-remove"></i></a></td>
      <td><?php echo $days['startdate']; ?></td>
      <td><?php echo $days['enddate']; ?></td>
      <td><?php echo $days['days']; ?></td>
      <td><?php echo $days['type']; ?></td>
    </tr>
  <?php } ?>
  <?php if (count($entitleddays) == 0) { ?>
    <tr id="noentitleddays">
        <td colspan="5"><?php echo lang('entitleddays_user_index_no_data');?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>

<label for="startdate"><?php echo lang('entitleddays_user_index_field_start');?></label>
<input type="input" name="startdate" id="startdate" required />
<label for="enddate"><?php echo lang('entitleddays_user_index_field_end');?></label>
<input type="input" name="enddate" id="enddate" required />
<label for="type"><?php echo lang('entitleddays_user_index_field_type');?></label>
<select name="type" id="type" required>
<?php foreach ($types as $types_item): ?>
    <option value="<?php echo $types_item['id'] ?>" <?php if ($types_item['id'] == 1) echo "selected" ?>><?php echo $types_item['name'] ?></option>
<?php endforeach ?> 
</select>    
<label for="days" required><?php echo lang('entitleddays_user_index_field_days');?></label>
<input type="input" name="days" id="days" />
<button id="cmdAddEntitledDays" class="btn btn-primary" onclick="add_entitleddays();"><?php echo lang('entitleddays_user_index_button_add');?></button>

<link href="<?php echo base_url();?>assets/datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

<!--Avoid datepicker to appear behind the modal form//-->
<style>
    .datepicker{z-index:1151 !important;}
</style>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<script type="text/javascript">
    
    function validate_form() {
        result = false;
        var fieldname = "";
        if ($('#startdate').val() == "") fieldname = "<?php echo lang('entitleddays_user_index_field_start');?>";
        if ($('#enddate').val() == "") fieldname = "<?php echo lang('entitleddays_user_index_field_end');?>";
        if ($('#type').val() == "") fieldname = "<?php echo lang('entitleddays_user_index_field_type');?>";
        if ($('#days').val() == "") fieldname = "<?php echo lang('entitleddays_user_index_field_days');?>";
        if (fieldname == "") {
            return true;
        } else {
            bootbox.alert(<?php echo lang('entitleddays_user_mandatory_js_msg');?>);
            return false;
        }
    }
    
    function delete_entitleddays(id) {
        $.ajax({
            url: "<?php echo base_url();?>entitleddays/userdelete/" + id
          }).done(function() {
              $('tr[data-id="' + id + '"]').remove();
              var rowCount = $('#entitleddaysuser tbody tr').length;
              if (rowCount == 0) {
                  $('#entitleddaysuser > tbody:last').append('<tr id="noentitleddays"><td colspan="5"><?php echo lang('entitleddays_user_index_no_data');?></td></tr>');
              }
          });
    }
    
    function add_entitleddays() {
        if (validate_form()) {
            $.ajax({
                url: "<?php echo base_url();?>entitleddays/ajax/user",
                type: "POST",
                data: { user_id: <?php echo $id; ?>,
                        startdate: $('#startdate').val(),
                        enddate: $('#enddate').val(),
                        days: $('#days').val(),
                        type: $('#type').val()
                    }
              }).done(function( msg ) {
                  id = parseInt(msg);
                  $('#noentitleddays').remove();
                  myRow = '<tr data-id="' + id + '">' +
                            '<td><a href="#" onclick="delete_entitleddays(' + id + ');" title="<?php echo lang('entitleddays_user_index_thead_tip_delete');?>"><i class="icon-remove"></i></a></td>' +
                            '<td>' + $('#startdate').val() + '</td>' +
                            '<td>' + $('#enddate').val() + '</td>' +
                            '<td>' + $('#days').val() + '</td>' +
                            '<td>' + $('#type option:selected').text() + '</td>' +
                        '</tr>';
                  $('#entitleddaysuser > tbody:last').append(myRow);
            });
        }
    }
    
    $(function () {
        $('#startdate').datepicker({format: 'yyyy-mm-dd', autoclose: true});
        $('#enddate').datepicker({format: 'yyyy-mm-dd', autoclose: true});
    });
</script>