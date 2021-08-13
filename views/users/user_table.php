<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-users"></i> Account List</h3>
      
        
      </div>

      <div class="card-body">
        <table id="list_table" class="table table-bordered table-striped" style="font-size:10pt;">
          <thead>
            <tr>
              <th hidden style="text-align: center;">ID</th>
              <!-- <th></th> -->
              <th style="text-align: center; width:30%;">NAME</th>
              <th style="text-align: center; width:12%;">USERNAME</th>
              <th style="text-align: center; width:15%;">PROVINCE</th>
              <th style="text-align: center; width:20%;">CITY/MUNICIPALITY</th>
              <th style="text-align: center; width:17%">EMAIL</th>
              <th style="text-align: center; width:14%;">STATUS</th>
              <th style="text-align: center; width:12%">ACTION</th>
            </tr>
          </thead>
          <tbody id="list_body">
            <?php foreach ($users as $id => $user): ?>
              <tr>
                <td hidden><?php echo $user['province_id']; ?></td>
                <!-- <td></td> -->
                <td>
                  <div class="paragraphs">
                    <div class="row">
                      <div class="span4">
                        
                        <p style="clear:both"><img style="float:left" src="<?php echo $user['profile']; ?>" width="32" height="32" class="rounded-circle my-n1"/> &nbsp;&nbsp;<?php echo $user['name']; ?></p>
                      </div>
                    </div>
                  </div></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['province']; ?></td>
                <td><?php echo $user['lgu']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td class="text-center" style="font-size:15pt;"><span class="badge badge-<?php echo $user['status'] == 'Active' ? 'success' : 'danger'; ?>"><?php echo $user['status']; ?></span></td>
                <td>
                  <a href="uac_edit.php?id=<?php echo $id; ?>" class="btn btn-info btn-block btn-sm" style="margin-bottom: -2%;" title="View Checklist">
                        <i class="fa fa-clipboard-list"></i> Edit
                      </a>
                </td>

              </tr>
            <?php endforeach ?>
          </tbody>   
        </table>
      </div>
    </div>
  </div>
</div>  