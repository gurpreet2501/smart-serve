<? $this->load->view('admin/partials/header');  ?>
 
<div class="row">
	<div class="col-lg-4">
		<h3><?=$type == 'OUT' ? 'Sales Report' : 'Purchase Report'?></h3>
	</div>
  <div class="col-lg-8">
		 <form  method="get" action="<?=site_url('manager_dashboard/generate_purchase_daily_report_csv')?>" class="form-inline report-gen-form">
		 	<input type="hidden" name="entry_type" value="<?=$type?>">
		  	<div class="form-group">
				  <label for="start_date">Start Date</label>
					<input type="text" id="start_date" class="form-control force-extend _datepicker" name="start_date" placeholder="Select Start Date" 
					value="<?=date('Y-m-d')?>" />
				</div>	
				<div class="form-group">
				  <label for="end_date">End Date</label>
					<input  type="text" value="<?=date('Y-m-d')?>" class="form-control force-extend _datepicker" name="end_date" placeholder="Select End Date" id="end_date">
				</div>
		  	<button type="submit" class="btn btn-success">Generate Report</button>
	  </form>	

		  
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <?php echo $output;  ?>
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>
