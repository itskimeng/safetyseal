<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-filter"></i> Filters</h3>
      </div>

      <form id="form-filter">
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Province</label>
              <select class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true" disabled>
                <option selected="selected" data-select2-id="19">Region IV-A Calabarzon</option>
              </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label>Province</label>
              <select class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true" disabled>
                <option></option>
                <?php foreach ($province_opts as $key => $opts): ?>
                  <?php if ($key == $province): ?>
                    <option value="<?php echo $key; ?>" data-code="<?php echo $opts['code']; ?>" selected><?php echo $opts['name']; ?></option>
                  <?php else: ?>
                    <option value="<?php echo $key; ?>" data-code="<?php echo $opts['code']; ?>"><?php echo $opts['name']; ?></option>  
                  <?php endif ?>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label>City/Municipality</label>
              <select class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true" disabled>
                <option></option>
                <?php foreach ($citymun_opts as $key => $opts): ?>
                  <?php if ($key == $citymun): ?>
                    <option value="<?php echo $key; ?>" data-province="<?php echo $opts['province']; ?>" data-code="<?php echo $opts['code']; ?>" selected><?php echo $opts['name']; ?></option>
                  <?php else: ?>
                    <option value="<?php echo $key; ?>" data-province="<?php echo $opts['province']; ?>" data-code="<?php echo $opts['code']; ?>"><?php echo $opts['name']; ?></option>
                  <?php endif ?>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <!-- <div class="col-md-3">
           <div class="form-group float-right">
              <div class="d-grid gap-2 d-md-block" style="margin-top: 19%;">
                <button class="btn btn-primary btn-md" type="button"><i class="fa fa-search"></i> Filter</button>
                <button class="btn btn-default btn-md" type="button"><i class="fa fa-sync-alt"></i> Reset</button>
              </div>
            </div>
          </div> -->
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Name</label>
              <select id="cform-name" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                <option></option>
                <?php foreach ($applicants as $key => $app): ?>
                  <option value="<?php echo $app['fname']; ?>"><?php echo $app['fname']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label>Agency</label>
              <select id="cform-agency" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                <option></option>
                <?php foreach ($applicants as $key => $app): ?>
                  <option value="<?php echo $app['agency']; ?>"><?php echo $app['agency'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label>Location</label>
              <select id="cform-location" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                <option></option>
                <?php foreach ($applicants as $key => $app): ?>
                  <option value="<?php echo $app['address']; ?>"><?php echo $app['address']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Status</label>
              <select id="cform-status" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                <option></option>
                <?php foreach ($status_opts as $key => $opt): ?>
                  <option value="<?php echo $opt; ?>"><?php echo $opt; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
                <label>Date range:</label>

                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right" id="reservation">
                </div>
                <!-- /.input group -->
              </div>
          </div>

          <div class="col-md-4">
            <div class="form-group float-right">
              <div class="d-grid gap-2 d-md-block" style="margin-top: 19%;">
                <button class="btn btn-primary btn-md" id="btn-filter" type="button"><i class="fa fa-search"></i> Filter</button>
                <button class="btn btn-default btn-md" id="btn-reset" type="button"><i class="fa fa-sync-alt"></i> Reset</button>
              </div>
            </div>  
          </div>
        </div>

        <div class="row float-right">
          <div class="col-md-12">
            
            
          </div>
        </div>

      </div>  
    </form>
    </div>
  </div>
  </div>