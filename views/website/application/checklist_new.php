<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <small><b>Instruction: (✓) Check the appropriate box (Yes/No), if the following requirement is provided</b></small>
  </div>


  <!-- Table -->
  <div class="table-responsive p-0" style="height: 900px;">


    <table class="table table-responsive table-hover table-striped tableFixHead" style="font-size: 11pt;">
      <thead style="background-color: #1da6da; color: white;">
        <tr>
        <th class="text-center" colspan="3">MINIMUM PUBLIC HEALTH STANDARDS</th>

          <th class="text-center" style="width:2%;">YES</th>
          <th class="text-center" style="width:2%;">NO</th>
          <th class="text-center" style="width:2%;">N/A</th>
          <th class="text-center" style="width:10%;">Reason why N/A</th>
        </tr>
      </thead>
     
      <tbody id="chklist_body">
        <?php $x = 1 ;?>
        <td colspan="9" class="parent-header"><strong>STAFF</strong></td>

        <?php foreach ($appchecklists as $key => $list) : ?>
     
          <tr id="chklist_tr">
            <td>
              <?php if ($list['parent'] == 1) : ?>
              <?php elseif ($list['parent'] == 2) : ?>
              <?php elseif ($list['parent'] == 3) : ?>
              <?php elseif ($list['parent'] == 4) : ?>
              <?php else : ?>
              <?php echo '<strong>'.$x++.'.</strong>'; ?>
              <?php endif; ?>
              <input type="hidden" name="chklist_id[<?php echo $list['clist_id']; ?>]" value="<?php echo $list['clist_id']; ?>">
              <input type="hidden" id="cform-ulist_id" name="ulist_id[<?php echo $list['clist_id']; ?>]" value="<?php echo $list['ulist_id']; ?>">
            </td>
            <td>
              <?php echo $list['requirement']; ?>


            </td>
            <td>

            </td>
            <td class="text-center">
              <div class="form-group">
                <?php if ($list['otherTool_disabled']) : ?>
                  <input class="form-check-input chklist_yes" type="checkbox" value="" name="chklist_yes[<?php echo $list['clist_id']; ?>]" data-chkcol="yes" <?php echo $list['answer'] == 'yes' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
                <?php else : ?>
                  <?php if ($list['tracing_tool'] == 'others') : ?>
                    <input class="form-check-input chklist_yes" type="checkbox" value="" name="chklist_yes[<?php echo $list['clist_id']; ?>]" data-chkcol="yes" disabled>
                  <?php else : ?>
                    <input class="form-check-input chklist_yes" type="checkbox" value="" name="chklist_yes[<?php echo $list['clist_id']; ?>]" data-chkcol="yes" <?php echo $list['answer'] == 'yes' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
                  <?php endif ?>
                <?php endif ?>
              </div>
            </td>
            <td class="text-center">
              <div class="form-group">
                <?php if ($list['otherTool_disabled']) : ?>
                  <input class="form-check-input chklist_no" type="checkbox" value="" name="chklist_no[<?php echo $list['clist_id']; ?>]" data-chkcol="no" <?php echo $list['answer'] == 'no' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
                <?php else : ?>
                  <?php if ($list['tracing_tool'] == 'others') : ?>
                    <input class="form-check-input chklist_no" type="checkbox" value="" name="chklist_no[<?php echo $list['clist_id']; ?>]" data-chkcol="no" disabled>
                  <?php else : ?>
                    <input class="form-check-input chklist_no" type="checkbox" value="" name="chklist_no[<?php echo $list['clist_id']; ?>]" data-chkcol="no" <?php echo $list['answer'] == 'no' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
                  <?php endif ?>
                <?php endif ?>
              </div>
            </td>
            <td class="text-center">
              <div class="form-group">
                <?php if ($list['otherTool_disabled']) : ?>
                  <input class="form-check-input chklist_na" type="checkbox" value="" name="chklist_na[<?php echo $list['clist_id']; ?>]" data-chkcol="na" <?php echo $list['answer'] == 'n/a' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
                <?php else : ?>
                  <?php if ($list['tracing_tool'] == 'others') : ?>
                    <input class="form-check-input chklist_na" type="checkbox" value="" name="chklist_na[<?php echo $list['clist_id']; ?>]" data-chkcol="na" disabled>
                  <?php else : ?>
                    <input class="form-check-input chklist_na" type="checkbox" value="" name="chklist_na[<?php echo $list['clist_id']; ?>]" data-chkcol="na" <?php echo $list['answer'] == 'n/a' ? 'checked' : ''; ?> <?php echo $list['is_disabled'] ? 'disabled' : ''; ?>>
                  <?php endif ?>
                <?php endif ?>

              </div>
            </td>
            <td class="text-center">
              <div class="form-group">
                <?php if ($list['otherTool_disabled']) : ?>
                  <textarea class="form-control form-check-reason" id="exampleFormControlTextarea1" rows="3" name="chklist_reason[<?php echo $list['clist_id']; ?>]" <?php echo $list['answer'] == 'n/a' ? '' : 'disabled'; ?>><?php echo $list['reason']; ?></textarea>
                <?php else : ?>
                  <?php if ($list['tracing_tool'] == 'others') : ?>
                    <textarea class="form-control form-check-reason" id="exampleFormControlTextarea1" rows="3" name="chklist_reason[<?php echo $list['clist_id']; ?>]" disabled></textarea>
                  <?php else : ?>
                    <textarea class="form-control form-check-reason" id="exampleFormControlTextarea1" rows="3" name="chklist_reason[<?php echo $list['clist_id']; ?>]" <?php echo $list['answer'] == 'n/a' ? '' : 'disabled'; ?>><?php echo $list['reason']; ?></textarea>
                  <?php endif ?>
                <?php endif ?>

              </div>
            </td>


          </tr>
          <?php if ($key == 1) : ?>
            <td colspan="9" class="parent-header"><strong>ESTABLISHMENT</strong></td>

                    <?php endif; ?>
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

  .wrapper .option .dot::before {
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

  input[type="radio"] {
    display: none;
  }

  /*.checklist1_opt {
  display: none;
}*/

  .checklist1_opt:checked:checked~.option-1,
  .checklist2_opt:checked:checked~.option-2 {
    border-color: #0069d9;
    background: #0069d9;
    /*border-color: #ea6d6d;*/
    /*background: #c90000;*/
  }

  .checklist1_opt:checked:checked~.option-1 .dot,
  .checklist2_opt:checked:checked~.option-2 .dot {
    background: #fff;
  }

  .checklist1_opt:checked:checked~.option-1 .dot::before,
  .checklist2_opt:checked:checked~.option-2 .dot::before {
    opacity: 1;
    transform: scale(1);
  }

  .wrapper .option span {
    font-size: 20px;
    color: #808080;
  }

  .checklist1_opt:checked:checked~.option-1 span,
  .checklist2_opt:checked:checked~.option-2 span {
    color: #fff;
  }

  thead {
    border-bottom-width: 3px;
  }

  tr>td:nth-child(4),
  td:nth-child(5),
  td:nth-child(6) {
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
    overflow: auto;
    height: 100px;
  }

  .tableFixHead thead th {
    position: sticky;
    top: 0;
    z-index: 1;
    background-color: #1da6da;
  }
</style>