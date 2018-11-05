<div class="col-md-12  easy div_of_leve  m-b-30" style="position: relative; background: #dedede; padding: 20px 10px;">

      <?php 

      $b_type = $_SESSION['t']['b_type'];
      
      if($b_type==3){
      
       ?>

        <div class="col-md-12">
            <div class="form-group">
                <label>Select the option you’d like to use to award the bonus:</label>
                <select class="form-control" name="a_type[]">
                    <option selected value="1">Purchased Tokens</option>
                    <option value="2">Purchased Amount</option>
                </select>
            </div>
        </div>

       <div class="col-md-12 nopad easy _bi">
       <div class="col-md-6">
            <div class="form-group">
                <label>Minimum Investment Amount/Tokens</label>
                <input name="min_invest[]" type="number" step="0.1" class="form-control" value="0.00">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Maximum Investment Amount/Tokens</label>
                <input name="max_invest[]" type="number" step="0.1" class="form-control" value="">
            </div>
        </div>
    </div>

<?php } ?>





        <div class="col-md-6">
            <div class="form-group">
                <label>Bonus (%) <sup>*</sup></label>
                <input name="bonus[]" type="number" step='0.01' class="form-control" required value="">
            </div>
        </div>
       
       
        
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-12" style="font-style: italic;">
           <i class="fa fa-info"></i> <label>Please enter date and time according EST timezone</label>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Start Date <small style="font-style:italic;">(Optional)</small></label>
                <div class="input-group">
                    <input  name="start_date[]" type="text" class="form-control" placeholder="yyyy-mm-dd" id="birth_date" value="">
                    <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                </div>
                <i class="fa fa-warning"></i> <small style="font-style:italic;">If you want this bonus applied all the time, leave this empty</small>
            </div>
        </div>



        <div class="col-md-6">
            <div class="form-group">
                <label>End Date <small style="font-style:italic;">(Optional)</small></label>
                <div class="input-group">
                    <input name="end_date[]" type="text" class="form-control" placeholder="yyyy-mm-dd" id="end_date" value="">
                    <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <hr>
        </div>

        <?php if(!$hide_remove){ ?>
        <button style="position: absolute;top:0;right:0;" onclick="remove_leve(this)" type="button" class="btn btn-danger bt-sm pull-right">
            <i class="fa fa-times"></i>
        </button>
    <?php } ?>
        
        

    </div>