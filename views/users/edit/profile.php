<div class="card card-info">
  <div class="card-header">
    <h3 class="card-title"><i class="fa fa-user" aria-hidden="true"></i> Profile</h3>
  </div>
  <div class="card-body">
    
    <div class="d-flex flex-column align-items-center text-center">

      <div class="circle">
       <!-- User Profile Image -->
       <div>
        <?php if (!empty($user['profile'])): ?>
          <img class="profile-pic" src="_images/profile/<?php echo $user['profile']; ?>" style="height: 100% !important;
    width: 100% !important;
    object-fit: cover;">
        <?php else: ?>
            <img class="profile-pic" 
            src="_images/logo.png" style="height: 100% !important; width: 100% !important; object-fit: cover;">

        <?php endif ?>
       </div>

       <!-- Default Image -->
       <!-- <i class="fa fa-user fa-5x"></i> -->
     </div>
     <div class="p-image">
       <i class="fa fa-camera upload-button"></i>
        <input class="file-upload" type="file" name="file" accept="image/*"/>
     </div>

      <div class="mt-3">
        <h4><b><?php echo $user['name']; ?></b></h4>
        <p class="text-secondary mb-1"><?php echo $user['position']; ?></p>
        <p class="text-muted font-size-sm"><small><?php echo $user['address']; ?></small></p>
        <input type="checkbox" name="user_status" <?php echo $user['is_verified'] ? 'checked' : ''; ?>>
      </div>

      <div class="mt-3">
        <?php include 'acct_credentials.php'; ?>
      </div>
        
    </div>
  </div>
</div>