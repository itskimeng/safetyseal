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
              <th style="text-align: center;">NAME</th>
              <th style="text-align: center;">USERNAME</th>
              <th style="text-align: center;">PROVINCE</th>
              <th style="text-align: center;">CITY/MUNICIPALITY</th>
              <th style="text-align: center;">EMAIL</th>
              <th style="text-align: center;">STATUS</th>
              <th style="text-align: center;">ACTION</th>
            </tr>
          </thead>
          <tbody id="list_body">
            <?php foreach ($users as $id => $user): ?>
              <tr>
                <td hidden><?= $user['province_id']; ?></td>
                <td>
                  <div class="paragraphs">
                    <div class="row">
                      <div class="span4">
                        <p style="clear:both"><img style="float:left" src="<?= $user['profile']; ?>" width="32" height="32" class="rounded-circle my-n1"/> &nbsp;&nbsp;<?= $user['name']; ?></p>
                      </div>
                    </div>
                  </div></td>
                <td><?= $user['username']; ?></td>
                <td><?= $user['province']; ?></td>
                <td><?= $user['lgu']; ?></td>
                <td><?= $user['email']; ?></td>
                <td class="text-center" style="font-size:15pt;">
                  <span class="badge badge-<?= $user['status'] == 'Active' ? 'success' : 'danger'; ?>">
                    <?= $user['status']; ?>    
                  </span>
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="uac_edit.php?id=<?= $id; ?>" class="btn btn-info btn-block btn-sm" style="margin-bottom: -2%;" title="View Checklist">
                          <i class="fa fa-clipboard-list"></i> Edit
                    </a>
                  </div>

                  <div class="btn-group">
                    <!-- <a href="entity/impersonate_user.php?id=<?= $id; ?>" class="btn btn-warning btn-block btn-sm" style="margin-bottom: -2%;" title="Impersonate selected user">
                          <i class="fa fa-sign-in-alt" aria-hidden="true"></i> Impersonate
                    </a> -->
                    <button type="button" class="btn btn-warning btn-sm btn-impersonate" data-toggle="modal" data-target="#modal-impersonate" data-user_id="<?= $id; ?>">
                    <i class="fa fa-sign-in-alt" aria-hidden="true"></i> Impersonate
                    </button>
                  </div>
                </td>

              </tr>
            <?php endforeach ?>
          </tbody>   
        </table>
      </div>
    </div>
  </div>
</div>  