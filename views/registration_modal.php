<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 125%;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="height:500px;overflow:auto;padding:10px;">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-md-6">
                            <label for="validationGovOffice" class="form-label">Name of Government Agency/Office</label>
                            <input required type="text" class="form-control" name="government_agency" id="validationGovOffice" aria-describedby="emailHelp">
                            <div class="invalid-feedback">
                                Required Fields!

                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="validationGovDept" class="form-label">Name of Government Establishment</label>
                            <input type="text" class="form-control" name="governmenr_esta" id="validationGovDept" required>
                            <div class="invalid-feedback">
                                Required Fields!
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="vfname" class="form-label">First Name</label>
                            <input required type="text" class="form-control" name="fname" id="vfname" aria-describedby="emailHelp">
                            <div class="invalid-feedback">
                                Required Fields!

                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="vmname" class="form-label">Middle Name</label>
                            <input required type="text" class="form-control" name="mname" id="vmname" aria-describedby="emailHelp">
                            <div class="invalid-feedback">
                                Required Fields!

                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="validatelname" class="form-label">Last Name</label>
                            <input required type="text" class="form-control" name="validatelname" id="lname" aria-describedby="emailHelp">
                            <div class="invalid-feedback">
                                Required Fields!

                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="validateAddress" class="form-label">Address</label>
                            <input required type="text" class="form-control" name="validateAddress" id="lname" aria-describedby="emailHelp">
                            <div class="invalid-feedback">
                                Required Fields!

                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="validationPhone" class="form-label">Mobile No.</label>
                            <input required type="number" class="form-control" name="phone_no" id="validationPhone" aria-describedby="emailHelp">
                            <div class="valid-feedback">
                                Required Fields!
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="validateEmail" class="form-label">Email Address</label>
                            <input required type="email" class="form-control" name="fname" id="validateEmail" aria-describedby="emailHelp">
                            <div class="invalid-feedback">
                                Required Fields!

                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="validationUsername" required>
                            <div class="valid-feedback">
                                Required Fields!
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationPass" class="form-label">Password </label>
                            <input type="password" class="form-control" name="password" id="validationPass" required>
                            <div class="valid-feedback">
                                Required Fields!
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationConf" class="form-label">Confirmed Password </label>
                            <input type="password" class="form-control" name="password" id="validationConf">
                            <div class="valid-feedback">
                                Required Fields!
                            </div>
                        </div>

                        <!-- <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                <label class="form-check-label" for="invalidCheck">
                                    Agree to terms and conditions
                                </label>
                                <div class="invalid-feedback">
                                    You must agree before submitting.
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                        </div> -->

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>

        </div>
    </div>
</div>