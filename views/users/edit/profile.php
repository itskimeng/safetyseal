<div class="card card-info">
  <div class="card-header">
    <h3 class="card-title"><i class="fa fa-user" aria-hidden="true"></i> Profile</h3>
  </div>
  <div class="card-body">
    <div class="d-flex flex-column align-items-center text-center">
      <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
      <div class="mt-3">
        <h4><b><?php echo $user['name']; ?></b></h4>
        <p class="text-secondary mb-1"><?php echo $user['position']; ?></p>
        <p class="text-muted font-size-sm"><small><?php echo $user['address']; ?></small></p>
        <input type="checkbox" name="user_status" <?php echo $user['is_verified'] ? 'checked' : ''; ?>>
      </div>
    </div>
  </div>
</div>