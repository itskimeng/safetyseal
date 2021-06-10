<!-- Modal -->
<div class="modal fade" id="verification_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                <h1 class="modal-title" id="exampleModalLabel">Verify Email</h1>
                <p style="text-align:justify"> Thank you for signing up!

                    We have sent a verification email to <?PHP echo '<b>'.$_GET['email'].'</b>';?>. You need to verify your email address to continue</p>
                <button class="btn btn-light-primary" id="resend">Did not receive the email?Click here to resend</button>
                </center>
            </div>
            <div class="modal-footer">
                
            </div>
            </form>

        </div>
    </div>
</div>