<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-filter"></i> Filters</h3>
        <div class="card-tools">
          <!-- <button type="button" class="btn btn-tool btn-tool-filter" data-card-widget="collapse"> -->

          <?php
          
          if ($_SESSION['username'] == 'jdtorres') {
                    echo ' <label class="switch">
        <input type="checkbox" data-toggle="modal" data-target="#exampleModal">
        <span class="slider"></span>
        </label>';
          }
          ?>
          <!-- </button> -->
        </div>
      </div>

      <form id="form-filter">
        <div class="card-body card-body-filter collapse show">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Region</label>
                <select class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                  <option selected="selected" data-select2-id="19">Region IV-A Calabarzon</option>
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Province</label>
                <input type="hidden" id="sel_province" />
                <input type="hidden" id="sel_municipality" />

                <select class="form-control select2bs4 select2-hidden-accessible" id="province" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true" disabled>
                  <option></option>
                  <?php foreach ($province_opts as $key => $opts) : ?>
                    <?php if ($key == $province) : ?>
                      <option value="<?php echo $key; ?>" data-code="<?php echo $opts['code']; ?>" selected><?php echo $opts['name']; ?></option>
                    <?php else : ?>
                      <option value="<?php echo $key; ?>" data-code="<?php echo $opts['code']; ?>"><?php echo $opts['name']; ?></option>
                    <?php endif ?>
                  <?php endforeach ?>
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>City/Municipality</label>

                <?php if (!$is_clusterhead) : ?>
                  <select id="cform-citymun" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" name aria-hidden="true" <?php echo !$is_pfp ? 'disabled' : ''; ?>>
                    <option></option>
                    <?php foreach ($citymun_opts as $key => $opts) : ?>
                      <?php if ($opts['code'] == $citymun) : ?>
                        <option value="<?php echo $opts['code']; ?>" data-province="<?php echo $opts['province']; ?>" data-code="<?php echo $opts['code']; ?>" selected><?php echo $opts['name']; ?></option>
                      <?php else : ?>
                        <option value="<?php echo $opts['code']; ?>" data-province="<?php echo $opts['province']; ?>" data-code="<?php echo $opts['code']; ?>"><?php echo $opts['name']; ?></option>
                      <?php endif ?>
                    <?php endforeach ?>
                  </select>
                <?php else : ?>
                  <select id="  " class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                    <option></option>
                    <?php foreach ($citymun_opts as $key => $opts) : ?>
                      <?php if ($opts['code'] == $citymun) : ?>
                        <option value="<?php echo $opts['code'] ?>" data-province="<?php echo $opts['province']; ?>" data-code="<?php echo $opts['code']; ?>" selected><?php echo $opts['name']; ?></option>
                      <?php else : ?>
                        <option value="<?php echo $opts['code'] ?>" data-province="<?php echo $opts['province']; ?>" data-code="<?php echo $opts['code']; ?>"><?php echo $opts['name']; ?></option>
                      <?php endif ?>
                    <?php endforeach ?>
                  </select>
                <?php endif ?>

              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="cform-name" />  
                <!-- <select id="cform-name" class="form-control select2  select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true"> -->
                  <!-- <option></option> -->
                  <?php //foreach ($applicants as $key => $app) : ?>
                    <option value="<?php //echo $app['fname']; ?>"><?php //echo $app['fname']; ?></option>
                  <?php //endforeach ?>
                <!-- </select> -->
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Agency</label>
                <input type="text" id="cform-agency" class="form-control" />
                <!-- <select id="cform-agency" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                  <option></option>
                  <?php foreach ($applicants as $key => $app) : ?>
                    <option value="<?php echo $app['agency']; ?>"><?php echo $app['agency'] ?></option>
                  <?php endforeach ?>
                </select> -->
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Location</label>
                <input type="text" id="cform-location" class="form-control" />
                <!-- <select id="cform-location" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                  <option></option>
                  <?php foreach ($applicants as $key => $app) : ?>
                    <option value="<?php echo $app['address']; ?>"><?php echo $app['address']; ?></option>
                  <?php endforeach ?>
                </select> -->
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Status</label>
                <select id="cform-status" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                  <option></option>
                  <?php foreach ($status_opts as $key => $opt) : ?>
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
              <div class="form-group">
                <label>Application Type:</label>
                <select id="cform-app_type" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                  <option></option>
                  <?php foreach ($apptype_opts as $key => $opt) : ?>
                    <option value="<?php echo $opt; ?>"><?php echo $opt; ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group float-right">
                <div class="d-grid gap-2 d-md-block">
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


<style>
  .dataTables_length {
    display: none;
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    margin: 9px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s cubic-bezier(0, 1, 0.5, 1);
    border-radius: 4px;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s cubic-bezier(0, 1, 0.5, 1);
    border-radius: 3px;
  }

  input:checked+.slider {
    background-color: #52c944;
  }

  input:focus+.slider {
    box-shadow: 0 0 4px #7efa70;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }

  input:checked+.slider.red {
    background-color: crimson;
  }

  input:focus+.slider.red {
    box-shadow: 0 0 4px crimson;
  }

  input:checked+.slider.red {
    background-color: crimson;
  }

  #round {
    border-radius: 34px;
  }

  #round:before {
    border-radius: 50%;
  }

  input:checked+.slider.red {
    background-color: crimson;
  }

  input:focus+.slider.blue {
    box-shadow: 0 0 4px #424bf5;
  }

  input:checked+.slider.blue {
    background-color: #424bf5;
  }
</style>
<script type="text/javascript">
  $(document).ready(function() {
    $(function() {
      $('select').selectpicker();
    });
    $(".btn-tool-filter").click(function() {
      $(".card-body-filter").collapse('toggle');
    });
  })
</script>