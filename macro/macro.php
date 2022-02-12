<?php

function group_input_custom($label, $name, $id, $value, $attr=[]) {
    $attr['type'] = isset($attr['type']) ? $attr['type'] : 'text';
    $attr['readonly'] = isset($attr['readonly']) ? $attr['readonly'] : false;
    $attr['required'] = isset($attr['required']) ? $attr['required'] : false;
    $attr['class'] = isset($attr['class']) ? $attr['class'] : '';

    $el = '<div class="col-md-4 text-right">';
    $el .= '<label class="control-label">'.$label.'</label>';
    $el .= '</div>';
    $el .= '<div class="col-md-8">';
    $el .= '<input type="'.$attr['type'].'" name="'.$name.'" class="form-control custom-form-control '.$name.' '.$attr['class'].'" id="cform-'.$id.'" placeholder="Enter '.$label.'" value="'.$value.'">';
    $el .= '</div>';

    return $el;
}

function group_textarea_custom($label, $name, $id, $value, $attr=[]) {
    $attr['type'] = isset($attr['type']) ? $attr['type'] : 'text';
    $attr['readonly'] = isset($attr['readonly']) ? $attr['readonly'] : false;
    $attr['required'] = isset($attr['required']) ? $attr['required'] : 'required';
    $attr['class'] = isset($attr['class']) ? $attr['class'] : '';
    $attr['row'] = isset($attr['row']) ? $attr['row'] : '3';

    $el = '<div class="col-md-4 text-right">';
    $el .= '<label class="control-label">'.$label.'</label>';
    $el .= '</div>';
    $el .= '<div class="col-md-8">';

    $el .= '<textarea class="form-control custom-form-control '.$name.' '.$attr['class'].'" id="cform-'.$id.'" name="'.$name.'" rows="'.$attr['row'].'" '.$attr['required'].'>';
    $el .= $value;
    $el .= '</textarea>';

    $el .= '</div>';

    return $el;
}

function group_select_custom($label, $name, $id, $value, $options=[], $attr=[]) {
    $attr['type'] = isset($attr['type']) ? $attr['type'] : 'text';
    $attr['readonly'] = isset($attr['readonly']) ? $attr['readonly'] : 'required';
    $attr['required'] = isset($attr['required']) ? $attr['required'] : false;
    $attr['class'] = isset($attr['class']) ? $attr['class'] : '';
    $attr['custom-po'] = isset($attr['custom-po']) ? $attr['custom-po'] : false;
    $attr['custom-cm'] = isset($attr['custom-cm']) ? $attr['custom-cm'] : false;

    $el = '<div class="col-md-4 text-right">';
    $el .= '<label>'.$label.'</label>';
    $el .= '</div>';
    $el .= '<div class="col-md-8">';
    $el .= '<select class="form-control select2bs4 select2-hidden-accessible custom-form-control '.$name.' '.$attr['class'].'" name="'.$name.'" id="cform-'.$id.'" tabindex="-1" aria-hidden="true" '.$attr['required'].'>';
    
    if ($attr['custom-po']) {
        $el .= group_customoptions_province($options, $value, $label);
    } elseif ($attr['custom-cm']) {
        $el .= group_customoptions_citymun($options, $value, $label);
    } else {
        $el .= group_options_custom($options, $value, $label);
    }

    $el .= '</select>';
    $el .= '</div>';

    return $el;
}

function group_options($options, $selected, $label) {
    $el = '<option disabled selected>-- Please select '.$label.' --</option>';
    foreach ($options as $key=>$value) {
        if ($key == $selected) {
            $el .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
        } else {
            $el .= '<option value="'.$key.'">'.$value.'</option>';
        }
    }
    
    return $el;
}

function group_options_custom($options, $selected, $label) {
    $el = '<option disabled selected>-- Please select '.$label.' --</option>';
    foreach ($options as $key=>$value) {
        if ($value == $selected) {
            $el .= '<option value="'.$value.'" selected="selected">'.$value.'</option>';
        } else {
            $el .= '<option value="'.$value.'">'.$value.'</option>';
        }
    }
    
    return $el;
}

function group_customoptions_province($fields, $selected, $label) {
    $element = '<option disabled selected>-- Please select '.$label.' --</option>';
    foreach ($fields as $key=>$value) {
        if ($key == $selected) {
            $element .= '<option value="'.$key.'" selected="selected">'.$value['name'].'</option>';
        } else {
            $element .= '<option value="'.$key.'">'.$value['name'].'</option>';
        }
    }
    
    return $element;
}

function group_customoptions_citymun($fields, $selected, $label) {
    $element = '<option disabled selected>-- Please select '.$label.' --</option>';
    foreach ($fields as $key=>$value) {
        if ($value['code'] == $selected) {
            $element .= '<option value="'.$value['code'].'" selected="selected">'.$value['name'].'</option>';
        } else {
            $element .= '<option value="'.$value['code'].'">'.$value['name'].'</option>';
        }
    }
    
    return $element;
}