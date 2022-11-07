<div class="modal fade" id="modal-impersonate">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="entity/impersonate_user.php" method="POST">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title"><i class="fa fa-question-circle" aria-hidden="true"></i> Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="user-id" name="user_id" value="">
                    <input type="hidden"  name="clusterhead_id" value="<?= $_SESSION['clusterhead_id'];?>">
                    <p>Continue impersonate this user?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                    <button type="submit" class="btn btn-warning"><i class="fa fa-check-circle"></i> Ok</button>
                </div>
            </form> 
        </div>

    </div>
</div>