<div class="modal fade" id="modal_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <!-- <form method="POST" action="f"></form> -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-question-circle" aria-hidden="true"></i> User Transaction History</h5>
      </div>
      <div class="modal-body p-0 custom-box-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-hover" style="width:100%;">
              <thead>
                <tr>
                  <th>DATE</th>
                  <th>ACTION</th>
                  <th>REMARK</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($user_history as $key => $user): ?>
                  <tr>
                    <td><?= $user['interval']; ?><br><?= $user['action_date']; ?></td>
                    <td><?= $user['action']; ?></td>
                    <td><?= $user['message']; ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  