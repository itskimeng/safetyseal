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

          <?php if ($key == 0 AND $alert_level >= 2): ?>
            <div class="wrapper">

              <?php if (in_array($userinfo['status'], ['Draft', 'Disapproved', 'Reassess', 'For Renewal'])): ?>
               <input type="radio" class="checklist1_opt" name="tracing_tool[<?php echo $list['clist_id']; ?>]" value='staysafe' id="option-1" <?php echo $list['tracing_tool'] == 'staysafe' ? 'checked' : ''; ?>>
               <input type="radio" class="checklist2_opt" name="tracing_tool[<?php echo $list['clist_id']; ?>]" value='others' id="option-2" <?php echo $list['tracing_tool'] == 'others' ? 'checked' : ''; ?>>
                 <label for="option-1" class="option option-1 btn-sm" data-val="staysafe">
                   <div class="dot"></div>
                    <span style="padding-left: 2px; font-size:11pt;"> StaySafe.ph</span>
                    </label>
                 <label for="option-2" class="option option-2 btn-sm" data-val="others">
                   <div class="dot"></div>
                    <span style="padding-left: 2px; font-size:11pt;">Other</span>
                 </label>
              <?php else: ?>
                <?php if ($list['tracing_tool'] == 'staysafe'): ?>
                  <input type="radio" class="checklist1_opt" name="tracing_tool[<?php echo $list['clist_id']; ?>]" value='staysafe' id="option-1" checked disabled>
                  <label for="option-1" class="option option-1 btn-sm" data-val="staysafe">
                    <div class="dot"></div>
                    <span style="padding-left: 2px; font-size:11pt;"> StaySafe.ph</span>
                  </label>
                <?php endif ?>
                <?php if ($list['tracing_tool'] == 'others'): ?>
                  <input type="radio" class="checklist2_opt" name="tracing_tool[<?php echo $list['clist_id']; ?>]" value='others' id="option-2" checked disabled>
                 <label for="option-2" class="option option-2 btn-sm" data-val="others">
                   <div class="dot"></div>
                    <span style="padding-left: 2px; font-size:11pt;">Other</span>
                 </label>
                <?php endif ?>
              <?php endif ?>


            </div>

            <div class="<?php echo $list['tracing_tool'] == 'others' ? '' : 'hidden-other_tools'; ?> other-sstools" style="margin-top:5%;">
            <?php if ($list['is_disabled']): ?>
              Other contact tracing tool. <br> <b><u><?php echo $list['other_tool']; ?></u></b>
            <?php else: ?>
              Other contact tracing tool. <input type="text" id="cform-other_tool" name="other_tool[<?php echo $list['clist_id']; ?>]" class="form-control other_tool" value="<?php echo $list['other_tool']; ?>" <?php echo $list['otherTool_disabled'] ? 'disabled' : '' ; ?>/>
            <?php endif ?>
            </div>
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
              <?php if ($list['tracing_tool'] == 'others'): ?>
                <input class="form-check-input chklist_yes" type="checkbox" value="" name="chklist_yes[<?php echo $list['clist_id']; ?>]" data-chkcol="yes" disabled> 
              <?php else: ?>
                <input class="form-check-input chklist_yes" type="checkbox" value="" name="chklist_yes[<?php echo $list['clist_id']; ?>]" data-chkcol="yes" <?php echo $list['answer'] == 'yes' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
              <?php endif ?>
            <?php endif ?>
          </div>
        </td>
        <td class="text-center">
          <div class="form-group">
            <?php if ($list['otherTool_disabled']): ?>
              <input class="form-check-input chklist_no" type="checkbox" value="" name="chklist_no[<?php echo $list['clist_id']; ?>]" data-chkcol="no" <?php echo $list['answer'] == 'no' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
            <?php else: ?>
              <?php if ($list['tracing_tool'] == 'others'): ?>
                <input class="form-check-input chklist_no" type="checkbox" value="" name="chklist_no[<?php echo $list['clist_id']; ?>]" data-chkcol="no" disabled>
              <?php else: ?>
                <input class="form-check-input chklist_no" type="checkbox" value="" name="chklist_no[<?php echo $list['clist_id']; ?>]" data-chkcol="no" <?php echo $list['answer'] == 'no' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
              <?php endif ?>
            <?php endif ?>
          </div>
        </td>
        <td class="text-center">
          <div class="form-group">
            <?php if ($list['otherTool_disabled']): ?>
              <input class="form-check-input chklist_na" type="checkbox" value="" name="chklist_na[<?php echo $list['clist_id']; ?>]" data-chkcol="na" <?php echo $list['answer'] == 'n/a' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
            <?php else: ?>
              <?php if ($list['tracing_tool'] == 'others'): ?>
                <input class="form-check-input chklist_na" type="checkbox" value="" name="chklist_na[<?php echo $list['clist_id']; ?>]" data-chkcol="na" disabled>
              <?php else: ?>
                <input class="form-check-input chklist_na" type="checkbox" value="" name="chklist_na[<?php echo $list['clist_id']; ?>]" data-chkcol="na" <?php echo $list['answer'] == 'n/a' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
              <?php endif ?>
            <?php endif ?>

          </div>
        </td>
        <td class="text-center">
          <div class="form-group">
            <?php if ($list['otherTool_disabled']): ?>
              <textarea class="form-control form-check-reason" id="exampleFormControlTextarea1" rows="3" name="chklist_reason[<?php echo $list['clist_id']; ?>]" <?php echo $list['answer'] == 'n/a' ? '' : 'disabled'; ?>><?php echo $list['reason']; ?></textarea>
            <?php else: ?>
              <?php if ($list['tracing_tool'] == 'others'): ?>
                <textarea class="form-control form-check-reason" id="exampleFormControlTextarea1" rows="3" name="chklist_reason[<?php echo $list['clist_id']; ?>]" disabled></textarea>
              <?php else: ?>
                <textarea class="form-control form-check-reason" id="exampleFormControlTextarea1" rows="3" name="chklist_reason[<?php echo $list['clist_id']; ?>]" <?php echo $list['answer'] == 'n/a' ? '' : 'disabled'; ?>><?php echo $list['reason']; ?></textarea>
              <?php endif ?>
            <?php endif ?>

          </div>
        </td> 
        <td class="text-center">
          <input type="hidden" name="checklist-order" id="checklist-order" value="<?php echo $key+1; ?>"/>

          <?php if (!$list['is_disabled']): ?>
            <div class="col-md-12 mb-1">
              <button type="button" class="btn btn-warning btn-block btn-sm btn-attachments_upload" data-bs-toggle="modal" <?php echo $list['is_disabled'] ? 'disabled' : ''; ?> value="CL<?php echo $key+1; ?>" style="width: 100%;">
                <i class="fa fa-link"></i> Upload
              </button>
            </div>
          <?php endif ?>
          
            <?php if (!empty($appchecklists_attchmnt[$list['ulist_id']])): ?>
              <input type="hidden" name="has_attachments[]" class="has_attachments" value="true"/>
              
              <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-sm btn-attachments_view" data-bs-toggle="modal" style="width: 100%;" data-checker_id="<?php echo $key+1; ?>">
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

  .hidden-other_tools {
    visibility: hidden;
  }

.wrapper {
    margin-left: -6px;
    display: inline-flex;
    /* background: #fff; */
    /*height: 40%;*/
    /*width: 85%;*/
    align-items: center;
    justify-content: space-evenly;
    /* border-radius: 5px; */
    /*padding: 20px 10px;*/
    /* box-shadow: 5px 5px 30px rgb(0 0 0 / 20%); */
}
.wrapper .option {
    background: #fff;
    /* height: 100%; */
    /* width: 100%; */
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    margin: 0 5px;
    border-radius: 5px;
    cursor: pointer;
    /* padding: 0 8px; */
    border: 2px solid lightgrey;
    transition: all 0.3s ease;
}
.wrapper .option .dot {
    height: 15px;
    width: 15px;
    background: #d9d9d9;
    border-radius: 50%;
    position: relative;
}
.wrapper .option .dot::before{
  position: absolute;
  content: "";
  /*top: 4px;*/
  /*left: 4px;*/
  width: 15px;
  height: 15px;
  background: #fff;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
input[type="radio"]{
  display: none;
}

/*.checklist1_opt {
  display: none;
}*/

.checklist1_opt:checked:checked ~ .option-1,
.checklist2_opt:checked:checked ~ .option-2{
  border-color: #0069d9;
  background: #0069d9;
  /*border-color: #ea6d6d;*/
  /*background: #c90000;*/
}
.checklist1_opt:checked:checked ~ .option-1 .dot,
.checklist2_opt:checked:checked ~ .option-2 .dot{
  background: #fff;
}
.checklist1_opt:checked:checked ~ .option-1 .dot::before,
.checklist2_opt:checked:checked ~ .option-2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper .option span{
  font-size: 20px;
  color: #808080;
}
.checklist1_opt:checked:checked ~ .option-1 span,
.checklist2_opt:checked:checked ~ .option-2 span{
  color: #fff;
}

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


