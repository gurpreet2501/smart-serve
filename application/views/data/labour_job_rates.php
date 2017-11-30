<? $this->load->view('admin/partials/header') ?>

<br>
<div class="row">
	<form method="GET">
	 	<div class="col-lg-8 col-lg-offset-2">
		  	<div class="row">
		  		<div class="col-lg-2 col-lg-offset-5 text-right" style="margin-top: 10px;padding-right: 0px;">
		  			<label for="category_id_dropdown">Accounts</label>
		  		</div>
		  		<div class="col-lg-3 " style="margin-top: 7px;">
			  		<select name="account_id" class="form-control" id="category_id_dropdown">
				       	<option selected disabled>Select Account</option>
				       	<?php foreach($accounts as $account):?>
				       	<option value="<?=$account['id']?>" <?= $account['id'] == $account_id ? 'selected' : '' ?>><?=$account['name']?></option>
				     	<?php endforeach;?>
				  	</select>
				</div>
				<div class="col-lg-2">
				  	<div class="form-group"><button type="submit" class="btn btn-danger">Select</button></div>
				</div>
	  		</div><!-- row -->
	 	</div>
	</form>	
</div><!-- row -->

<div class="row">
  <div class="col-lg-8 col-lg-offset-2">

  	<?php if ($this->session->flashdata('success_msg')): ?>
	<div class="alert alert-success" role="alert">
		<?=$this->session->flashdata('success_msg')?>		
	</div>
	<?php endif; ?>

 <?php if(!empty($jobTypes)): ?>
 <h2 class="text-center">Labour Job Rates</h2> 
 	<form method="POST" action="<?= site_url('data/store_labour_job_rates') ?>">
 		<input type="hidden" name="account_id" value="<?= $account_id ?>">
	 	<table class="table table-stripped">
	  	<tr>
	  		<td>Job Type</td>
	  		<td>Rate</td>
	  	</tr>

	  	<?php foreach($jobTypes as $type): ?>
	  		<tr>
	  			<td class="text-left">
	  				<strong><?= $type['name'] ?></strong>
	  				<br> <i><?= $type['job_description'] ?></i>
	  			</td>
	  			<td>
	  				<input type="text" name="labour_job_type[<?= $type['id']?>]" value="<?= @$rates[$type['id']] ?>" class="form-control">
	  			</td>
	  		</tr>
	    <?php endforeach; ?> 	
	   	</table>
		<div class="form-group text-center">
			<button type="submit" class="btn btn-success">Save</button>
		</div>
	</form>
 <?php else: ?>
	 	<h2 class="text-center">No job type found!</h2>
 <?php endif; ?>
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>
