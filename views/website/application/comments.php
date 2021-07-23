<div class="panel panel-default mt-3">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <small><b>ONSITE VALIDATION/ INSPECTION</b></small>
  </div>

  <div class="tab-pane active" id="a">
      
    <div class="col-md-12">
      <div class="row">
        <div class="form-outline mb-2 col-md-12">
          <label>Defects/Defeciencies noted during inspection:</label>
            <textarea class="form-control" rows="5" name="defects" placeholder="Enter ..." readonly value="<?php echo isset($userinfo['defects']) ? $userinfo['defects'] : ''; ?>"><?php echo isset($userinfo['defects']) ? $userinfo['defects'] : ''; ?></textarea>
        </div>
        
      </div>
    </div>

    <div class="col-md-12">
      <div class="row">
        <div class="form-outline mb-2 col-md-12">
          <label>Recommendations:</label>
            <textarea class="form-control" rows="5" name="recommendations" placeholder="Enter ..." readonly value="<?php echo isset($userinfo['recommendations']) ? $userinfo['recommendations'] : ''; ?>"><?php echo isset($userinfo['recommendations']) ? $userinfo['recommendations'] : ''; ?></textarea>
        </div>
        
      </div>
    </div>

  </div>
</div>


<style type="text/css">

  .hidden-other_tools {
    visibility: hidden;
  }

.wrapper {
    margin-left: -6px;
    display: inline-flex;
    /* background: #fff; */
    /*height: 40%;*/
    /*width: 85%;*/
    align-items: center;
    justify-content: space-evenly;
    /* border-radius: 5px; */
    /*padding: 20px 10px;*/
    /* box-shadow: 5px 5px 30px rgb(0 0 0 / 20%); */
}
.wrapper .option {
    background: #fff;
    /* height: 100%; */
    /* width: 100%; */
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    margin: 0 5px;
    border-radius: 5px;
    cursor: pointer;
    /* padding: 0 8px; */
    border: 2px solid lightgrey;
    transition: all 0.3s ease;
}
.wrapper .option .dot {
    height: 15px;
    width: 15px;
    background: #d9d9d9;
    border-radius: 50%;
    position: relative;
}
.wrapper .option .dot::before{
  position: absolute;
  content: "";
  /*top: 4px;*/
  /*left: 4px;*/
  width: 15px;
  height: 15px;
  background: #fff;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
input[type="radio"]{
  display: none;
}

/*.checklist1_opt {
  display: none;
}*/

.checklist1_opt:checked:checked ~ .option-1,
.checklist2_opt:checked:checked ~ .option-2{
  border-color: #0069d9;
  background: #0069d9;
  /*border-color: #ea6d6d;*/
  /*background: #c90000;*/
}
.checklist1_opt:checked:checked ~ .option-1 .dot,
.checklist2_opt:checked:checked ~ .option-2 .dot{
  background: #fff;
}
.checklist1_opt:checked:checked ~ .option-1 .dot::before,
.checklist2_opt:checked:checked ~ .option-2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper .option span{
  font-size: 20px;
  color: #808080;
}
.checklist1_opt:checked:checked ~ .option-1 span,
.checklist2_opt:checked:checked ~ .option-2 span{
  color: #fff;
}

  thead {
    border-bottom-width: 3px;
  }

  tr > td:nth-child(4), td:nth-child(5), td:nth-child(6) {
    font-size: 20pt;
  }

  .chklist_yes:checked {
    background-color: #198754;
    border-color: #0d6efd;
  }

  .chklist_no:checked {
    background-color: #dc3545;
    border-color: #0d6efd;
  }

  .chklist_na:checked {
    background-color: #6c757d;
    border-color: #0d6efd;
  }

  .tableFixHead { 
    overflow: auto; height: 100px; 
  }
  
  .tableFixHead thead th { 
    position: sticky; 
    top: 0; 
    z-index: 1; 
    background-color: #1da6da;
  }

</style>


