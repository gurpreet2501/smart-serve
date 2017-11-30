<?php $this->load->view('admin/partials/header'); ?>
<div class="row">
	<div class="col-xs-4"></div>
	<div class="col-xs-4">
	<h2>Add New Job</h2>
		<form action="<?=site_url('data/save_new_labor_job/?'.$get_string)?>" method="post">
		  <div class="form-group">
		    <label for="exampleInputEmail1">Party Name</label>
		    <select name="labour_party_id" class="form-control" id="party_id">
		    	<option selected disabled>-Select-</option>
		    <?php foreach ($accounts as $key => $account): ?>
		    	<option value="<?=$account->id?>" <?=($stub['party_id'] == $account->id) ? 'selected' : ''?>><?=$account->name?></option>
		    <?php endforeach ?>
		    </select>
		  </div>  	
		  <div class="form-group">
		    <label for="exampleInputEmail1">Labour Job Type</label>
		    <select name="labour_job_type_id" class="form-control" id="job_type" placeholder="Labour Job Type">
		    <option selected disabled>-Select-</option>
		    <?php foreach ($labour_job_types as $key => $job_type): ?>
		    	<option value="<?=$job_type->id?>"><?=$job_type->name?></option>
		    <?php endforeach ?>
		    </select>
		  </div>
		  <div class="form-group">
		    <label for="exampleInputEmail1">Godowns</label>
		    <select name="godown_id" class="form-control" id="job_type" placeholder="Labour Job Type">
		    	<option selected disabled>-Select-</option>
		    <?php foreach ($godowns as $key => $godown): ?>
		    	<option value="<?=$godown->id?>"><?=$godown->name?></option>
		    <?php endforeach ?>
		    </select>
		  </div>
		  <div class="form-group">
		  	<label for="exampleInputEmail1">Bags</label>
		  	<input type="text" name="bags" class="form-control" />
		  	<input type="hidden" name="date" class="form-control" value="<?=date('Y-m-d')?>" />
		  </div>
		  <div class="form-group">
		  	<label for="exampleInputEmail1">Rate</label>
		  	<input type="text" name="rate" class="form-control" />
		  </div>
		  <div class="form-group">
		    <label for="exampleInputEmail1">Weight unit</label>
		    <select name="weight_unit" class="form-control" id="job_type" placeholder="Labour Job Type">
		    	<option selected disabled>-Select-</option>
		    <?php foreach ($weight_units as $key => $wtunit): ?>
		    	<option value="<?=$wtunit->id?>"><?=$wtunit->name?></option>
		    <?php endforeach ?>
		    </select>
		  </div>
		  <button type="submit" class="btn btn-danger">Submit</button>
		</form>
	</div>
	<div class="col-xs-4"></div>
</div>
<?php $this->load->view('admin/partials/footer'); ?>
