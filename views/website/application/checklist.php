<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <small><b>Instruction: (✓) Check the appropriate box (Yes/No), if the following requirement is provided</b></small>
  </div>

  <!-- Table -->
  <table class="table table-responsive table-hover table-striped" style="font-size: 11pt;">
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
          <input type="hidden" name="chklist_id[<?php echo $list['id']; ?>]">    
        </td>
        <td><?php echo $list['requirement']; ?></td>
        <td>
          <ul>
            <?php foreach ($list['description'] as $description): ?>
              <li><?php echo $description ?></li>
            <?php endforeach ?>
          </ul>
        </td>
        <td class="text-center">
          <div class="form-group">
            <input class="form-check-input chklist_yes" type="checkbox" value="" name="chklist_yes[]" data-chkcol="yes">
          </div>
        </td>
        <td class="text-center">
          <div class="form-group">
            <input class="form-check-input chklist_no" type="checkbox" value="" name="chklist_no[]" data-chkcol="no">
          </div>
        </td>
        <td class="text-center">
          <div class="form-group">
            <input class="form-check-input chklist_na" type="checkbox" value="" name="chklist_na[]" data-chkcol="na">
          </div>
        </td>
        <td class="text-center">
          <div class="form-group">
            <textarea class="form-control form-check-reason" id="exampleFormControlTextarea1" rows="3" name="chklist_reason[]" disabled></textarea>
          </div>
        </td> 
        <td class="text-center">
          <div class="btn-group">
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
              <i class="fa fa-plus-square"></i> Upload
            </button>
          </div>
        </td> 

      </tr>
    <?php endforeach ?>
  </tbody>
</table>
</div>


<style type="text/css">
  thead {
    border-bottom-width: 3px;
  }

  tr > td:nth-child(4), td:nth-child(5), td:nth-child(6) {
    font-size: 20pt;
  }

</style>


