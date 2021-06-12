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
                <option></option>
                <?php foreach ($province_opts as $key => $opts): ?>
                  <option value="<?php echo $opts['id']; ?>" data-code="<?php echo $opts['code']; ?>"><?php echo $opts['name']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>City/Municipality</label>
              <select class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                <option></option>
                <?php foreach ($citymun_opts as $key => $opts): ?>
                  <option value="<?php echo $opts['id']; ?>" data-province="<?php echo $opts['province']; ?>" data-code="<?php echo $opts['code']; ?>"><?php echo $opts['name']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <div class="col-md-3">
           <div class="form-group float-right">
              <!-- <label>City/Municipality</label> -->
              <div class="d-grid gap-2 d-md-block" style="margin-top: 19%;">
                <button class="btn btn-primary btn-md" type="button"><i class="fa fa-search"></i> Filter</button>
                <button class="btn btn-default btn-md" type="button"><i class="fa fa-sync-alt"></i> Reset</button>
              </div>
            </div>
          </div>
        </div>

        <div class="row float-right">
          <div class="col-md-12">
            
            
          </div>
        </div>

      </div>  
    </div>
  </div>
  </div>