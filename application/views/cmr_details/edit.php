<? $this->load->view('admin/partials/header'); ?> 
<div id="cmr-details">
  <div class="row clearfix">
        <div class="col-xs-12 ">
          <br>
          <button type="button" class="btn btn-danger pull-right" onclick="goBack()">Go Back</button>

        </div>
      </div>
  <form action="<?=site_url('cmr_details/cmr_update')?>" method="post" class="validate">
    <fieldset class="cmr-details">
      <legend>Add CMR Slip Details</legend>
      <div class="row">
        <div class="col-md-6">
          <input type="hidden" name="entry_id" value="<?=$entry_id?>">
          <!-- //Account name -->
          <div class="form-group form-inline">
            <label for="exampleInputEmail1">Account Name</label>
            <agdropdown name="cmr_agency_name" input_class='required' next_field_id="cmr_agency_id" hidden_field_name="cmr_details[account_id]" v-bind:options="accounts" v-model="account_id"> 
            </agdropdown> 

          </div>      

          <!-- Market Name -->
           <div class="form-group form-inline">

            <label for="cmr_agency">Market Name</label>
              
             <agdropdown next_field_id="tp_no" input_class='required' v-on:change="getSocietyDetail" hidden_field_name="cmr_details[cmr_market_id]" v-bind:options="markets" v-model="cmr_market_id" > 
            </agdropdown> 

            <div class="glyphicon glyphicon-plus add-pop-up" onclick="addMarketNameInCmrDetails()"></div>

        </div> <!-- form-group --> 

        <!-- Tp no   -->
        <div class="form-group form-inline">
          <label for="tp_no">TP No</label>
          <input type="text" class="form-control required" id="tp_no"  placeholder="Enter TP No"
          name="cmr_details[tp_no]"
          v-model="tp_no">
        </div> 

        <!-- //Ac Note no  -->
         <div class="form-group form-inline">
            <label for="ac_note_no">AC Note No</label>
            <input type="text" class="form-control" id="ac_note_no"  placeholder="Enter AC Note No"
            name="cmr_details[ac_note_no]"
            v-model="ac_note_no">
         </div>

         <!-- Quintals -->
        <div class="form-group form-inline">
            <label for="quintals">Quintals</label>
            <input type="text" class="form-control required"   id="quintals"
            name="cmr_details[quintals]"
            v-model="quintals" min=".001">
        </div> 

        <!-- //M serial no -->
        <div class="form-group form-inline">
          <label for="remarks">M.Serial No.</label>
          <input type="text" class="form-control"
          name="cmr_details[m_serial_no]"
          v-model="m_serial_no" >
        </div> 

        </div> <!-- col-md-6 -->

        <div class="col-md-6">
        <div class="form-group form-inline">
        <label for="truckNo">Truck No: </label>
        <input 
        type="text" 
        v-on:keyup="upper()" 
        class="form-control required" 
        id="truckNo" 
        placeholder="Enter Truck No"
        name="cmr_details[truck_no]"
        v-model="truck_no" 
        v-bind:value="truck_no">
      </div>  

      <div class="form-group form-inline">
        <label for="tp_date">Society Name</label>
        <select class="form-control required" name="cmr_details[cmr_society_id]">
        <option v-for="society in getSocietyDetail()" v-bind:value="society.id">{{society.name}}</option>
        <!-- <option v-for="society in getSocietyDetail()" v-bind:value="society.id">{{society.name}}</option> -->
        </select>
      </div>  

      <div class="form-group form-inline">
        <label for="tp_date">TP Date</label>
        <datepicker 
          class="form-control required" 
          name="cmr_details[tp_date]"
          v-model="tp_date" tabnext="ac_note_date" id="tp_date"  
        />
      </div>  

      <div class="form-group form-inline">
        <label for="ac_note_date">AC Note Date</label>
          <datepicker 
            class="form-control" 
            name="cmr_details[ac_note_date]"  
            v-model="ac_note_date" tabnext="no_of_bags" id="ac_note_date"
          />
      </div>  

        <div class="form-group form-inline">
          <label for="no_of_bags">No of bags</label>
          <input type="text" class="form-control required" id="no_of_bags" min='1'   placeholder="No of bags"
          name="cmr_details[no_of_bags]"
          v-model="no_of_bags">
        </div> 

        </div> <!-- col-md-6 -->

      </div> <!-- row -->
      <!-- //Fields autofill on edit; -->
    </fieldset>
    <br>
    <input type="submit" value="Update" class="btn btn-danger pull-right submit-btn" />
    <div class="fieldset-spacer"></div>
  </form>
  </div>

<? $this->load->view('admin/partials/footer') ?>