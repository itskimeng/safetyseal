<?php

function group_select($label, $name, $class, $options, $value, $label_size=1, $body_size, $attributes=[]) 
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
    $element .= group_options($options, $value);
    $element.= '</select>';
    $element.= '</div>';
    $element.= '</div>';

    return $element;
}

function group_options($options, $selected) 
{
    $element = '<option disabled selected></option>';
    foreach ($options as $key => $option) {
        if ($key == $selected) {
            $element .= '<option value="'.$key.'" selected="selected">'.$option.'</option>';
        } else {
            $element .= '<option value="'.$key.'">'.$option.'</option>';
        }
    }
    
    return $element;
}

function group_daterange($label, $name, $class, $label_size=1, $body_size)
{
    $element = '<div class="col-md-'.$body_size.'">';
    $element.= '<div class="form-group">';
    if ($label_size > 0) {
        $element.= '<label>'.$label.':</label>';
    }
    $element.= '<div class="input-group">';
    $element.= '<div class="input-group-prepend">';
    $element.= '<span class="input-group-text">';
    $element.= '<i class="far fa-calendar-alt"></i>';
    $element.= '</span>';
    $element.= '</div>';
    $element.= '<input type="text" name="'.$name.'" class="form-control '.$class.' float-right" id="cform-'.$name.'">';
    $element.= '</div>';
    $element.= '</div>';
    $element.= '</div>';

    return $element;
}

function group_datetime($label, $name, $class, $value, $label_size=1, $body_size)
{
    $element = '<div class="col-md-'.$body_size.'">';
    $element.= '<div class="form-group">';
    if ($label_size > 0) {
        $element.= '<label>'.$label.':</label>';
    }
    $element.= '<div class="input-group date" id="cform-'.$name.'" data-target-input="nearest">';
    $element.= '<input type="text" class="form-control datetimepicker-input" data-target="#cform-'.$name.'" value="'.$value.'"/>';
    $element.= '<div class="input-group-append" data-target="#cform-'.$name.'" data-toggle="datetimepicker">';
    $element.= '<div class="input-group-text"><i class="fa fa-calendar"></i></div>';
    $element.= '</div>';
    $element.= '</div>';
    $element.= '</div>';
    $element.= '</div>';

    return $element;
}

