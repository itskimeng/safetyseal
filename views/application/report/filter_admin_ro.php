<?php
  function custom_group_select($label, $name, $class, $options, $value, $label_size=1, $body_size, $attributes=[]) 
  {
      $readonly = isset($attributes['readonly']) ? 'readonly' : '';
      $disabled = isset($attributes['disabled']) ? 'disabled' : '';
      $required = isset($attributes['required']) ? 'required' : ''; 

      $element = '<div class="col-md-'.$body_size.'">';
      $element.= '<div class="form-group">';
      if ($label_size > 0) {
          $element.= '<label>'.$label.':</label>';
      }
      $element.= '<select id="cform-'.$name.'" name="'.$name.'" class="form-control select2bs4 select2-hidden-accessible '.$class.'" style="width: 100%;" tabindex="-1" aria-hidden="true" '.$readonly.' '.$disabled.' '.$required.'>';
      $element .= custom_group_options($options, $value);
      $element.= '</select>';
      $element.= '</div>';
      $element.= '</div>';

      return $element;
  }

  function custom_group_options($options, $selected) 
  {
      $element = '<option disabled selected></option>';
      foreach ($options as $key => $option) {
          if ($key == $selected) {
              $element .= '<option value="'.$key.'" data-code="'.$option['code'].'" selected="selected">'.$option['name'].'</option>';
          } else {
              $element .= '<option value="'.$key.'" data-code="'.$option['code'].'">'.$option['name'].'</option>';
          }
      }
      
      return $element;
  }
?>


<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-filter"></i> Filters</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool btn-tool-filter" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>

      <form id="form-filter">
      <div class="card-body card-body-filter collapse show">
        <div class="row">
          <?php echo group_select('Region', 'region', 'region', ['Region IV-A Calabarzon'=>'Region IV-A Calabarzon'], 'Region IV-A Calabarzon', 1, 4, ['readonly'=>true, 'disabled'=>true]); ?>
          <?php //echo group_select('As of Date', 'as_of', 'as_of', $month_options, $today, 1, 4); ?>
          <?php echo group_datetime('As of Date', 'as_of', 'as_of', $current_time, 1, 4); ?>

          <div class="col-md-4">
            <div class="form-group float-right" style="margin-top: 7%;">
              <div class="d-grid gap-2 d-md-block">
                <button class="btn btn-primary btn-md" id="btn-filter_adminro" type="button"><i class="fa fa-search"></i> Filter</button>
                <button class="btn btn-success btn-md" id="btn-generate_adminro" type="button"><i class="fa fa-print"></i> Generate</button>
                <button class="btn btn-default btn-md" id="btn-reset" type="button"><i class="fa fa-sync-alt"></i> Reset</button>
              </div>
            </div>  
          </div>
        </div>

      </div>  
    </form>
    </div>
  </div>
  </div>

<script type="text/javascript">
  $(document).ready(function(){
    $(".btn-tool-filter").click(function(){
      $(".card-body-filter").collapse('toggle');
    });
  })
</script>
