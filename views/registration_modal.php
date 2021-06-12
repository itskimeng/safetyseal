<?php require_once 'controller/RegistrationComponentsController.php';
?>


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
<script>
 $(document).on('change','#province', function() {
  let province = $(this).val();
//   let city_mun = <?php //echo json_encode(array_map(function($x) { return $x; }, $city_mun)); ?>;
    let city_mun = {"1":[{"id":"1","code":"01","name":"BATANGAS CITY (Capital)"},{"id":"2","code":"02","name":"LIPA CITY"},{"id":"3","code":"03","name":"CITY OF STO. TOMAS"},{"id":"4","code":"04","name":"CITY OF TANAUAN"},{"id":"5","code":"05","name":"AGONCILLO"},{"id":"6","code":"06","name":"ALITAGTAG"},{"id":"7","code":"07","name":"BALAYAN"},{"id":"8","code":"08","name":"BALETE"},{"id":"9","code":"09","name":"BAUAN"},{"id":"10","code":"10","name":"CALACA"},{"id":"11","code":"11","name":"CALATAGAN"},{"id":"12","code":"12","name":"CUENCA"},{"id":"13","code":"13","name":"IBAAN"},{"id":"14","code":"14","name":"LAUREL"},{"id":"15","code":"15","name":"LEMERY"},{"id":"16","code":"16","name":"LIAN"},{"id":"17","code":"17","name":"LOBO"},{"id":"18","code":"18","name":"MABINI"},{"id":"19","code":"19","name":"MALVAR"},{"id":"20","code":"20","name":"MATAASNAKAHOY"},{"id":"21","code":"21","name":"NASUGBU"},{"id":"22","code":"22","name":"PADRE GARCIA"},{"id":"23","code":"23","name":"ROSARIO"},{"id":"24","code":"24","name":"SAN JOSE"},{"id":"25","code":"25","name":"SAN JUAN"},{"id":"26","code":"26","name":"SAN LUIS"},{"id":"27","code":"27","name":"SAN NICOLAS"},{"id":"28","code":"28","name":"SAN PASCUAL"},{"id":"29","code":"29","name":"SANTA TERESITA"},{"id":"30","code":"30","name":"TAAL"},{"id":"31","code":"31","name":"TALISAY"},{"id":"32","code":"32","name":"TAYSAN"},{"id":"33","code":"33","name":"TINGLOY"},{"id":"34","code":"34","name":"TUY"}],"2":[{"id":"35","code":"01","name":"CITY OF BACOOR"},{"id":"36","code":"02","name":"CAVITE CITY"},{"id":"37","code":"03","name":"CITY OF DASMARI\u00d1AS"},{"id":"38","code":"04","name":"CITY OF GENERAL TRIAS"},{"id":"39","code":"05","name":"CITY OF IMUS"},{"id":"40","code":"06","name":"TAGAYTAY CITY"},{"id":"41","code":"07","name":"TRECE MARTIRES CITY"},{"id":"42","code":"08","name":"ALFONSO"},{"id":"43","code":"09","name":"AMADEO"},{"id":"44","code":"10","name":"CARMONA"},{"id":"45","code":"11","name":"GEN. EMILIO AGUINALDO"},{"id":"46","code":"12","name":"GEN. MARIANO ALVAREZ"},{"id":"47","code":"13","name":"INDANG"},{"id":"48","code":"14","name":"KAWIT"},{"id":"49","code":"15","name":"MAGALLANES"},{"id":"50","code":"16","name":"MARAGONDON"},{"id":"51","code":"17","name":"MENDEZ (MENDEZ-NU\u00d1EZ)"},{"id":"52","code":"18","name":"NAIC"},{"id":"53","code":"19","name":"NOVELETA"},{"id":"54","code":"20","name":"ROSARIO"},{"id":"55","code":"21","name":"SILANG"},{"id":"56","code":"22","name":"TANZA"},{"id":"57","code":"23","name":"TERNATE"}],"3":[{"id":"88","code":"01","name":"CITY OF BI\u00d1AN"},{"id":"89","code":"02","name":"CITY OF CABUYAO"},{"id":"90","code":"03","name":"CITY OF CALAMBA"},{"id":"91","code":"04","name":"SAN PABLO CITY"},{"id":"92","code":"05","name":"CITY OF SAN PEDRO"},{"id":"93","code":"06","name":"CITY OF SANTA ROSA"},{"id":"94","code":"07","name":"ALAMINOS"},{"id":"95","code":"08","name":"BAY"},{"id":"96","code":"09","name":"CALAUAN"},{"id":"97","code":"10","name":"CAVINTI"},{"id":"98","code":"11","name":"FAMY"},{"id":"99","code":"12","name":"KALAYAAN"},{"id":"100","code":"13","name":"LILIW"},{"id":"101","code":"14","name":"LOS BA\u00d1OS"},{"id":"102","code":"15","name":"LUISIANA"},{"id":"103","code":"16","name":"LUMBAN"},{"id":"104","code":"17","name":"MABITAC"},{"id":"105","code":"18","name":"MAGDALENA"},{"id":"106","code":"19","name":"MAJAYJAY"},{"id":"107","code":"20","name":"NAGCARLAN"},{"id":"108","code":"21","name":"PAETE"},{"id":"109","code":"22","name":"PAGSANJAN"},{"id":"110","code":"23","name":"PAKIL"},{"id":"111","code":"24","name":"PANGIL"},{"id":"112","code":"25","name":"PILA"},{"id":"113","code":"26","name":"RIZAL"},{"id":"114","code":"27","name":"SANTA CRUZ (Capital)"},{"id":"115","code":"28","name":"SANTA MARIA"},{"id":"116","code":"29","name":"SINILOAN"},{"id":"117","code":"30","name":"VICTORIA"}],"4":[{"id":"118","code":"01","name":"CITY OF TAYABAS"},{"id":"119","code":"02","name":"AGDANGAN"},{"id":"120","code":"03","name":"ALABAT"},{"id":"121","code":"04","name":"ATIMONAN"},{"id":"122","code":"05","name":"BUENAVISTA"},{"id":"123","code":"06","name":"BURDEOS"},{"id":"124","code":"07","name":"CALAUAG"},{"id":"125","code":"08","name":"CANDELARIA"},{"id":"126","code":"09","name":"CATANAUAN"},{"id":"127","code":"10","name":"DOLORES"},{"id":"128","code":"11","name":"GENERAL LUNA"},{"id":"129","code":"12","name":"GENERAL NAKAR"},{"id":"130","code":"13","name":"GUINAYANGAN"},{"id":"131","code":"14","name":"GUMACA"},{"id":"132","code":"15","name":"INFANTA"},{"id":"133","code":"16","name":"JOMALIG"},{"id":"134","code":"17","name":"LOPEZ"},{"id":"135","code":"18","name":"LUCBAN"},{"id":"136","code":"19","name":"MACALELON"},{"id":"137","code":"20","name":"MAUBAN"},{"id":"138","code":"21","name":"MULANAY"},{"id":"139","code":"22","name":"PADRE BURGOS"},{"id":"140","code":"23","name":"PAGBILAO"},{"id":"141","code":"24","name":"PANUKULAN"},{"id":"142","code":"25","name":"PATNANUNGAN"},{"id":"143","code":"26","name":"PEREZ"},{"id":"144","code":"27","name":"PITOGO"},{"id":"145","code":"28","name":"PLARIDEL"},{"id":"146","code":"29","name":"POLILLO"},{"id":"147","code":"30","name":"QUEZON"},{"id":"148","code":"31","name":"REAL"},{"id":"149","code":"32","name":"SAMPALOC"},{"id":"150","code":"33","name":"SAN ANDRES"},{"id":"151","code":"34","name":"SAN ANTONIO"},{"id":"152","code":"35","name":"SAN FRANCISCO (AURORA)"},{"id":"153","code":"36","name":"SAN NARCISO"},{"id":"154","code":"37","name":"SARIAYA"},{"id":"155","code":"38","name":"TAGKAWAYAN"},{"id":"156","code":"39","name":"TIAONG"},{"id":"157","code":"40","name":"UNISAN"}],"5":[{"id":"158","code":"01","name":"ANTIPOLO CITY"},{"id":"159","code":"02","name":"ANGONO"},{"id":"160","code":"03","name":"BARAS"},{"id":"161","code":"04","name":"BINANGONAN"},{"id":"162","code":"05","name":"CAINTA"},{"id":"163","code":"06","name":"CARDONA"},{"id":"164","code":"07","name":"JALAJALA"},{"id":"165","code":"08","name":"RODRIGUEZ (MONTALBAN)"},{"id":"166","code":"09","name":"MORONG"},{"id":"167","code":"10","name":"PILILLA"},{"id":"168","code":"11","name":"SAN MATEO"},{"id":"169","code":"12","name":"TANAY"},{"id":"170","code":"13","name":"TAYTAY"},{"id":"171","code":"14","name":"TERESA"}],"6":[{"id":"172","code":"01","name":"LUCENA CITY"}]};

  $('#city_mun').empty();
    $.each(city_mun[province],function(key,data){
        $('#city_mun').append("<option value='"+data['id']+"'  data-code='"+data['code']+"'>"+data['name']+"</option> " );

    })
});


</script>