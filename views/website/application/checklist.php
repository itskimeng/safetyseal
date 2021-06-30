<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <small><b>Instruction: (✓) Check the appropriate box (Yes/No), if the following requirement is provided</b></small>
  </div>


  <!-- Table -->
  <div class="table-responsive p-0" style="height: 700px;">
    
  
  <table class="table table-responsive table-hover table-striped tableFixHead" style="font-size: 11pt;">
  <thead style="background-color: #1da6da; color: white;">
    <tr>
      <th class="text-center" style="width:2%;">#</th>
      <th class="text-center" style="width:10%;">REQUIREMENTS</th>
      <th class="text-center" style="width:10%;">MOVs to be Produced/ Uploaded</th>
      <th class="text-center" style="width:2%;">YES</th>
      <th class="text-center" style="width:2%;">NO</th>
      <th class="text-center" style="width:2%;">N/A</th>
      <th class="text-center" style="width:10%;">Reason why N/A</th>
      <th class="text-center" style="width:2%;">Attachments</th>
    </tr>
  </thead>
  <tbody id="chklist_body">
    <?php foreach ($appchecklists as $key => $list): ?>
      <tr>
        <td>
          <?php echo $key+1; ?>
          <input type="hidden" name="chklist_id[<?php echo $list['clist_id']; ?>]" value="<?php echo $list['clist_id']; ?>">
          <input type="hidden" id="cform-ulist_id" name="ulist_id[<?php echo $list['clist_id']; ?>]" value="<?php echo $list['ulist_id']; ?>">    
        </td>
        <td>
          <?php echo $list['requirement']; ?>
          <?php if ($key == 0): ?>
            <?php if ($list['is_disabled']): ?>
              <br><br>Other contact tracing tool. <input type="text" id="cform-other_tool" name="other_tool[<?php echo $list['clist_id']; ?>]" class="form-control other_tool" value="<?php echo $list['other_tool']; ?>" disabled/>  
            <?php else: ?>
              <br><br>Other contact tracing tool. <input type="text" id="cform-other_tool" name="other_tool[<?php echo $list['clist_id']; ?>]" class="form-control other_tool" value="<?php echo $list['other_tool']; ?>" <?php echo $list['otherTool_disabled'] ? 'disabled' : '' ; ?>/>
            <?php endif ?>
          <?php endif ?>    
        </td>
        <td>
          <ul>
            <?php foreach ($list['description'] as $description): ?>
              <li><?php echo $description ?></li>
            <?php endforeach ?>
          </ul>
        </td>
        <td class="text-center">
          <div class="form-group">
            <?php if ($list['otherTool_disabled']): ?>
              <input class="form-check-input chklist_yes" type="checkbox" value="" name="chklist_yes[<?php echo $list['clist_id']; ?>]" data-chkcol="yes" <?php echo $list['answer'] == 'yes' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
            <?php else: ?>
              <input class="form-check-input chklist_yes" type="checkbox" value="" name="chklist_yes[<?php echo $list['clist_id']; ?>]" data-chkcol="yes" <?php echo $list['answer'] == 'yes' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
            <?php endif ?>
          </div>
        </td>
        <td class="text-center">
          <div class="form-group">
            <input class="form-check-input chklist_no" type="checkbox" value="" name="chklist_no[<?php echo $list['clist_id']; ?>]" data-chkcol="no" <?php echo $list['answer'] == 'no' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
          </div>
        </td>
        <td class="text-center">
          <div class="form-group">
            <input class="form-check-input chklist_na" type="checkbox" value="" name="chklist_na[<?php echo $list['clist_id']; ?>]" data-chkcol="na" <?php echo $list['answer'] == 'n/a' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
          </div>
        </td>
        <td class="text-center">
          <div class="form-group">
            <textarea class="form-control form-check-reason" id="exampleFormControlTextarea1" rows="3" name="chklist_reason[<?php echo $list['clist_id']; ?>]" <?php echo $list['answer'] == 'n/a' ? '' : 'disabled'; ?>><?php echo $list['reason']; ?></textarea>
          </div>
        </td> 
        <td class="text-center">
          <!-- <div class="col-md-12"> -->
          
          <?php if (!$list['is_disabled']): ?>
            <!-- <div class="btn-group mb-1">
              <button type="button" class="btn btn-warning btn-sm btn-attachments_upload" data-bs-toggle="modal" <?php //echo $list['is_disabled'] ? 'disabled' : ''; ?> value="CL<?php //echo $key+1; ?>">
                <i class="fa fa-link"></i> Upload
              </button>
            </div><br> -->
            <div class="col-md-12 mb-1">
              <button type="button" class="btn btn-warning btn-block btn-sm btn-attachments_upload" data-bs-toggle="modal" <?php echo $list['is_disabled'] ? 'disabled' : ''; ?> value="CL<?php echo $key+1; ?>" style="width: 100%;">
                <i class="fa fa-link"></i> Upload
              </button>
            </div>
          <?php endif ?>
          <!-- <div class="btn-group"> -->
            <?php if (!empty($appchecklists_attchmnt[$list['ulist_id']])): ?>
              <input type="hidden" name="has_attachments[]" class="has_attachments" value="true"/>
              <!-- <button type="button" class="btn btn-warning btn-sm btn-attachments_view" data-bs-toggle="modal" >
                <i class="fa fa-link"></i> View
              </button> -->
              <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-sm btn-attachments_view" data-bs-toggle="modal" style="width: 100%;">
                  <i class="fa fa-link"></i> View
                </button>
              </div>
            <?php else: ?>
              <input type="hidden" name="has_attachments[]" class="has_attachments" value="false"/>
            <?php endif ?>
          </div>
          </div>
        </td> 

      </tr>
    <?php endforeach ?>
  </tbody>
</table>
</div>
</div>


<style type="text/css">
  thead {
    border-bottom-width: 3px;
  }

  tr > td:nth-child(4), td:nth-child(5), td:nth-child(6) {
    font-size: 20pt;
  }

  .chklist_yes:checked {
    background-color: #198754;
    border-color: #0d6efd;
  }

  .chklist_no:checked {
    background-color: #dc3545;
    border-color: #0d6efd;
  }

  .chklist_na:checked {
    background-color: #6c757d;
    border-color: #0d6efd;
  }

  .tableFixHead { 
    overflow: auto; height: 100px; 
  }
  
  .tableFixHead thead th { 
    position: sticky; 
    top: 0; 
    z-index: 1; 
    background-color: #1da6da;
  }

</style>


