<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="height:300px;overflow:auto;padding:10px;">
                    <form action="application/functions/registration_save.php" method="POST" class="row g-3 needs-validation" novalidate>
                    <div class="row">
                        <div class="col-6">
                            <div class="col-md-12">
                                <label for="validationGovOffice" class="form-label">Name of Government Agency/Office</label>
                                <input required type="text" class="form-control" name="government_agency" id="validationGovOffice" aria-describedby="emailHelp">
                                <div class="invalid-feedback">
                                Name of Government Agency/Office is required

                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="validationGovDept" class="form-label">Name of Government Establishment</label>
                                <input type="text" class="form-control" name="government_esta" id="validationGovDept" required>
                                <div class="invalid-feedback">
                                Name of Government Establishment is required
                                </div>
                            </div>
                            <div class="mb-12">
                                <label for="validateAddress" class="form-label">Address</label>
                                <input required type="text" class="form-control" name="validateAddress" id="lname" aria-describedby="emailHelp">
                                <div class="invalid-feedback">
                                    Address is required

                                </div>
                            </div>
                            <div class="mb-12">
                                <label for="validatePosition" class="form-label">Position</label>
                                <input required type="text" class="form-control" name="position" id="validatePosition" aria-describedby="emailHelp">
                                <div class="invalid-feedback">
                                    Position is required

                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="validateAddress" class="form-label">Operating Hours</label><br>
                                <input required type="radio" value="24/7">24/7
                                <input required type="radio" value="24/7">Selected Days/Hours

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="vfname" class="form-label">First Name</label>
                                    <input required type="text" class="form-control" name="fname" id="vfname" aria-describedby="emailHelp">
                                    <div class="invalid-feedback">
                                        First Name is required

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="vmname" class="form-label">Middle Name</label>
                                    <input required type="text" class="form-control" name="mname" id="vmname" aria-describedby="emailHelp">
                                    <div class="invalid-feedback">
                                        Middle Name is required

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validatelname" class="form-label">Last Name</label>
                                    <input required type="text" class="form-control" name="lname" id="lname" aria-describedby="emailHelp">
                                    <div class="invalid-feedback">
                                        Last Name is required

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="validationPhone" class="form-label">Mobile No.</label>
                                    <input required type="number" class="form-control" name="phone_no" id="validationPhone" aria-describedby="emailHelp">
                                    <div class="valid-feedback">
                                        Mobile No. is required
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="validationEmail" class="form-label">Email Address</label>
                                    <input required type="text" class="form-control" name="emailAddress" id="validationEmail" aria-describedby="emailHelp">
                                    <div class="valid-feedback">
                                        Email Address is required
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="validationUsername" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" id="validationUsername" required>
                                    <div class="valid-feedback">
                                        Username is required
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationPass" class="form-label">Password </label>
                                    <input type="password" class="form-control" name="password" id="validationPass" required>
                                    <div class="valid-feedback">
                                        Password is required


                                    </div>
                                 </div>
                                <div class="col-md-6">
                                    <label for="validationConf" class="form-label">Confirmed Password </label>
                                    <input type="password" class="form-control" name="cpassword" id="validationConf">
                                    <div class="valid-feedback">
                                        Required Fields!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button id="submit" name="submit" class="btn btn-light-primary">Register</button>
            </div>
            </form>

        </div>
    </div>
</div>