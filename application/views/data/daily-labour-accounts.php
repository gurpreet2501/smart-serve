<?php $this->load->view('admin/partials/header');
$party_id = !empty($_GET['party_id']) ? $_GET['party_id'] : 0;  ?>
<div class="row">
  <div class="col-lg-1"></div>
  <div class="col-lg-10">
	  <form class="form-inline">	
				<div class="form-group">
				    <label for="end_date">Select Party </label>
				  	<select name="party_id" class="form-control">
				       <option selected disabled>Select Party</option>
				       <?php foreach($accounts as $account):?>
				       <option value="<?=$account->id?>" <?=$party_id == $account->id ? 'selected' : ''?> ><?=$account->name?></option>
				     <?php endforeach;?>
			     	</select>
			  </div>	
		  	<div class="form-group">
				  <label for="start_date">Start Date</label>
					<input type="text" id="start_date" class="form-control force-extend _datepicker" name="start_date" value="<?=$stub['start_date']?>" placeholder="Select Start Date"  />
				</div>	
				<div class="form-group">
				  <label for="end_date">End Date</label>
					<input type="text" class="form-control force-extend _datepicker" name="end_date" placeholder="Select End Date" id="end_date" value="<?=$stub['end_date']?>"/>
				</div>
		  	<button type="submit" class="btn btn-success" name="date_filter">Go</button>
		  	<button type="submit" class="btn btn-success" name="_today_filter">Generate For Today</button>
	
	  	<?php if(is_role('manager')): ?>
		  	<hr/>
	        <div class="btns-group pull-right"> 
			  
			  	<div class="form-group">
			  		<a href="<?=site_url('data/otherLabourJob/'.$party_id)?>"><button type="button" class="btn btn-danger">Add Job</button></a>
			  	</div>
			  	<div class="form-group">
			  		<a href="<?=site_url('data/customLabourJobs/'.$party_id)?>"><button type="button" class="btn btn-danger">Add Custom Job</button></a>
			  	</div>
			  </div>	
        <?php endif;?> 
	  </form>	
  </div>
  <div class="col-lg-1"></div>
</div>
<br>

<div class="row">
 <div class="col-lg-12">
  <?php if($resultsFlag): ?>
  <h2 class="text-center">Daily Labour Account</h2>
  <form method="post" action="<?=site_url('data/updateLabourPartyRates/?').$get_string?>">
		 <input type="hidden" class="form-control" value="<?=$party_id?>" name="party_id" />
  <?php /*<table class="table table-stripped">
		 		<tr>
		  		<td>Id.</td>
		  		<td>Item</td>
		  		<td>Rate</td>
 		  	  <?php foreach ($godowns as $key => $godown): ?>
		  			<td><?=$godown->name?></td>
		  	  <?php endforeach; ?>
		  		<td>Amount</td>
		  	</tr>
  	<?php 
  	 $sno = 1; 

		 
  	 foreach($filtered_results as $records):  //$ids = implode(', ', $records['ids']); ?>
  	 	  <tr class="labAcc">
			  		<td>#<?=$records['id']?></td>
			  		<td><?=$records['labour_job_type_name']?></td>
			  		<td width="10%">
			  			<input type="text" class="form-control labour_acc_rate" value="<?=$records['rate']?>" name="rate[<?=$sno?>][rate]" readonly />
			  			<input type="hidden" class="form-control" value="<?=$records['bags']?>" name="rate[<?=$sno?>][bags]" />
			  		</td>
			  		<input type="hidden" class="form-control labour_acc_rate" name="rate[<?=$sno?>][ge_id]" value="<?=$records['ge_id']?>" />
			  		
     <?php  foreach($godowns as $godown): ?>
     			<td class="bag_exists">

   					<?=($records['godown_id'] == $godown['id']) ? $records['bags']: 0 ?>
     			</td>
     <?php endforeach; ?>
     		<td><div class="labour_acc_entry_total">0</div></td>
       </tr>
    <?php   $sno++;  endforeach; ?>
    
		
<? /* foreach($other_jobs_data as  $ojobs): ?>
			  	<tr>
			  		<td><?=$sno?></td>
			  		<td><?=$ojobs['labour_job_type_name']?></td>
			  		<td><?=$ojobs['rate']?></td>
			  		<td><?=$ojobs['godown_name']?></td>
			  		<td><?=$ojobs['bags']?></td>
			  		<td><?=$ojobs['amount']?></td>
			  	</tr>
    <?php $sno++; endforeach; ?> 
    <tr>
    <td colspan="6"><h3>Other Jobs</h3></td>
    </tr> 
    
      
 			
   </table> */?>
     <table class="table table-stripped">
		 		<tr>
		  		<td>Sno.</td>
		  		<td>Item</td>
		  		<td>Rate</td>
 		  	  <?php foreach ($godowns as $key => $godown): ?>
		  			<td><?=$godown->name?></td>
		  	  <?php endforeach; ?>
		  		<td>Amount</td>
		  	</tr>
  	<?php 
  	 $sno = 1; 

  	 foreach($filtered_results as $records): 
  	 			$ids = implode(', ', $records['ids']); ?>
  	 	  <tr class="labAcc">
			  		<td><?=$sno?></td>
			  		<td><?=$records['labour_job_type_name']?></td>
			  		<td width="10%"><input type="text" class="form-control labour_acc_rate " readonly value="<?=$records['rate']?>" name="rate[<?=$sno?>][value][]" /></td>
			  		<input type="hidden" class="form-control labour_acc_rate" name="rate[<?=$sno?>][ids]" value="<?=$ids?>" />
			  		
     <?php foreach($godowns as $godown): ?>
     			<td class="bag_exists">
   					<?=isset($records['godowns'][$godown->id]) ? $records['godowns'][$godown->id]['bags']: 0?>
     			</td>
     <?php endforeach; ?>
     		<td><div class="labour_acc_entry_total">0</div></td>
       </tr>
    <?php   $sno++;     endforeach; ?>
    
		
<? /* foreach($other_jobs_data as  $ojobs): ?>
			  	<tr>
			  		<td><?=$sno?></td>
			  		<td><?=$ojobs['labour_job_type_name']?></td>
			  		<td><?=$ojobs['rate']?></td>
			  		<td><?=$ojobs['godown_name']?></td>
			  		<td><?=$ojobs['bags']?></td>
			  		<td><?=$ojobs['amount']?></td>
			  	</tr>
    <?php $sno++; endforeach; ?> 
    <tr>
    <td colspan="6"><h3>Other Jobs</h3></td>
    </tr> 
    <!-- Printing other jobs -->*/
      ?>
 			
   </table>

 <div class="row">
	 <div class="col-xs-9"></div>
	 	<div class="col-xs-3 pull-right">
		  	<h4>Total: <span class="grandTotal">Rs. 0</span></h4>
		  	<h5>Opening Bal: Rs. <?=$opening_balance?></h5>
		  	<h5>Closing Bal: Rs. <?=$closing_balance?></h5>
	 	</div>
 </div> <!-- row -->
 <br/>
 <div class="row">
 <div class="col-xs-7">
 	  <!-- <button class="btn btn-success pull-right" name="submit_btn" type="submit">Update Rates</button> -->

 	</div>
 	<div class="col-xs-2">
 				<input type="text" name="amount" class="form-control" placeholder="Enter Amount" />
 	</div>

 	<div class="col-xs-2">
	  		<select class="form-control" name="secondary_payment_account">
		  		<?php foreach (cashTransactionMenuItems() as $item): ?>
	          <option value="<?=$item->id?>"><?=$item->name?></option>
	        <?php endforeach; ?>
        </select>          
 	</div>
 	<div class="col-xs-1"><button class="btn btn-primary" type="submit" name="payment_btn">Pay</button></div>
 </div> <!-- row -->
 </form>
 <hr/>
 <h3>Other Jobs</h3>
<div class="row">
	<div class="col-xs-12">
		<?php if(count($custom_jobs_data)): ?>
		<table class="table table-stripped">
		   <tr>
		   	<td>Sno</td>
		   	<td>Party Name</td>
		   	<td>Job Name</td>
		   	<td>Godown Name</td>
		   	<td>Amount</td>
		   	<td>Remarks</td>
		   </tr>
	  <?php $total = 0; foreach($custom_jobs_data as  $custom_job):
					$total = $total + $custom_job['amount']; ?>
			  	<tr>
			  		<td><?=$sno?></td>
			  		<td><?=$custom_job['labour_party_name']?></td>
			  		<td><?=$custom_job['job_name']?></td>
			  		<td><?=$custom_job['godown_name']?></td>
			  		<td><?=$custom_job['remarks']?></td>
			  		<td><?=$custom_job['amount']?></td>
			  	</tr>
    <?php $sno++; endforeach; ?> 	

		</table>
		<div class="row">
			 <div class="col-xs-10"></div>
			 	<div class="col-xs-2">
				  	<h4>Total: <?=$total?></h4>
			 	</div>
		 </div> 
	<?php else: ?>
		<h2 class="text-center">No Records Found</h2>
	<?php endif; ?>
		<!-- ---------- -->
		
		<!-- ---------- -->

	</div>
</div>
 <br/>

<hr/>
 <?php else: ?>
	 	<h2 class="text-center"> No Records Found !</h2>
 <?php endif; ?>
 <div class="row pull-right">
 	<div class="col-xs-12">
  
			  	<div class="form-group">
			  		<a href="<?=site_url('data/add_new_labour_job/?'.$get_string)?>"><button type="button" class="btn-small btn-danger">Add Job</button></a>
			  		<a href="<?=site_url('data/customLabourJobs/?'.$get_string)?>"><button type="button" class="btn-small btn-danger">Add Other Job</button></a>
			  	</div>
 		
 	</div>
 </div> 
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>
