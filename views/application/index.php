<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0"> Application</h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Application</li>
        </ol>
      </div>
    </div>
    <hr>
  </div>
</div>
    
<!-- Main content -->
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-6 col-sm-3">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-filter"></i> Filters</h3>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Province</label>
                  <select class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true" disabled>
                    <option selected="selected" data-select2-id="19">Region IV-A Calabarzon</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Province</label>
                  <select class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                    <option selected="selected" data-select2-id="19">Laguna</option>
                    <option data-select2-id="47">Batangas</option>
                    <option data-select2-id="48">Cavite</option>
                    <option data-select2-id="49">Quezon Province</option>
                    <option data-select2-id="50">Lucena City</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>City/Municipality</label>
                  <select class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                    <option selected="selected" data-select2-id="19">Calamba City</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Name</label>
                  <select class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                    <option selected="selected" data-select2-id="19">Sample Name</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row float-right">
              <div class="col-md-12">
                <div class="d-grid gap-2 d-md-block">
                  <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-search"></i> Filter</button>
                  <button class="btn btn-default btn-sm" type="button"><i class="fa fa-sync-alt"></i> Reset</button>
                </div>
                
              </div>
            </div>

          </div>  
        </div>
      </div>
    </div> 

    <div class="row">
      <div class="col-lg-12 col-md-6 col-sm-3">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Application List</h3>
          </div>

          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center;">Name</th>
                  <th style="text-align: center; width:20%">Agency Name</th>
                  <th style="text-align: center; width:20%">Location</th>
                  <th style="text-align: center; width:20%">Date Registered</th>
                  <th style="text-align: center; width:15%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Mark Kim A. Sacluti</td>
                  <td>Bureau of Permits</td>
                  <td>Room 110, Manila City Hall, Padre Burgos St., Ermita, Barangay 659-A, CITY OF MANILA, NCR, FIRST DISTRICT, NATIONAL CAPITAL REGION</td>
                  <td style="text-align: center;">July 09, 2021</td>
                  <td>
                    <div class="col-md-12">
                      <button type="button" class="btn btn-danger btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-bell"></i> View Rating
                      </button>
                      <button type="button" class="btn btn-success btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-bell"></i> Rate
                      </button>
                      <button type="button" class="btn btn-warning btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-bell"></i> Ratings
                      </button>
                      <button type="button" class="btn btn-secondary btn-block btn-sm">
                        <i class="fa fa-bell"></i> History
                      </button>
                    </div>
                    
                  </td>
                </tr>
                <tr>
                  <td>Jan Eric Castillo</td>
                  <td>Bureau of Fire Protection</td>
                  <td>3/F Andenson Bldg. 1, National Highway, Brgy, 4027 Manila S Rd, Calamba, 4027 Laguna</td>
                  <td style="text-align: center;">July 07, 2021</td>
                  <td>
                    <div class="col-md-12">
                      <button type="button" class="btn btn-danger btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-bell"></i> View Rating
                      </button>
                      <button type="button" class="btn btn-success btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-bell"></i> Rate
                      </button>
                      <button type="button" class="btn btn-warning btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-bell"></i> Ratings
                      </button>
                      <button type="button" class="btn btn-secondary btn-block btn-sm">
                        <i class="fa fa-bell"></i> History
                      </button>
                    </div>
                    
                  </td>
                </tr>
              </tbody>   
            </table>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<script>
  $(function () {
    $("#example1").DataTable({
      // "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>