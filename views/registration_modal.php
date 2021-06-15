<?php require_once 'controller/RegistrationComponentsController.php';
?>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="height:300px;overflow:auto;padding:10px;">
                    <form action="application/functions/registration_save.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <input type="hidden" id="cform-array_citymuns" class="array_citymuns" name="array_citymuns" value='<?php echo json_encode(array_map(function($x) { return $x; }, $city_mun)); ?>'>
                        <!-- <input type="hidden" id="cform-array_citymuns" class="array_citymuns" name="array_citymuns" value='<?php //echo json_encode($city_mun); ?>;'> -->

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
                                <div class="col-md-12">
                                    <label for="validationGovDept" class="form-label">Government Nature</label>
                                    <input type="text" class="form-control" name="government_nature" id="validationGovDept" required>
                                    <div class="invalid-feedback">
                                        Government Nature is required
                                    </div>
                                </div>
                                <div class="mb-12">
                                    <label for="validateAddress" class="form-label">Address</label>
                                    <input required type="text" class="form-control" name="validateAddress" id="address" aria-describedby="emailHelp">
                                    <div class="invalid-feedback">
                                        Address is required

                                    </div>
                                </div>
                             
                                <div class="col-mb-12">
                                    <div class="form-group">
                                        <label>Province</label>
                                        <select class="form-control select2bs4 select2-hidden-accessible" name="province" id="province" tabindex="-1" aria-hidden="true">
                                        <option></option>
                                            <?php foreach ($provinces as $key => $province): ?>
                                                <option value="<?php echo $key;?>" data-code="<?php echo $province['code'];?>"><?php echo $province['name'];?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label>City/Municipality</label>
                                    <select class="form-control select2bs4 select2-hidden-accessible" name = "municipality" style="width: 100%;" id="city_mun" tabindex="-1" aria-hidden="true">
                                    </select>
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
                                    <div class="mb-12">
                                    <label for="validatePosition" class="form-label">Position</label>
                                    <input required type="text" class="form-control" name="position" id="validatePosition" aria-describedby="emailHelp">
                                    <div class="invalid-feedback">
                                        Position is required
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
                                        <input type="text" class="form-control" name="username" id="validationUsername" onclick="setUname();"  autocomplete="off">
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
<script>
    $(document).on('change','#province', function() {
        let province = $(this).val();
        let lgu_array = $('.array_citymuns').val();
        let lgu_opts = JSON.parse(lgu_array);
        let lgu_select = $('#city_mun');

        generateSelectOptions(lgu_select, lgu_opts[province]);
    });

    function generateSelectOptions($append_to, $options) {
        let opt = '<option></option>';
        $append_to.empty();
        $append_to.append(opt);
        
        $.each($options, function(key, item){
            opt = $('<option>', {value: item['id'], text: item['name'], attr:{'data-code': item['code']}});
            opt.appendTo($append_to);
        });

        return 0;   
    }

    function setUname(){
        var fname = $('#vfname').val();
        var mname = $('#vmname').val();
        var lname = $('#lname').val();
        var username=fname.charAt(0)+""+mname.charAt(0)+""+lname;
        $('#validationUsername').val(username.toLowerCase());
    }

</script>