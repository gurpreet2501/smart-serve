<? $this->load->view('admin/partials/header'); ?>
<div class="row">
	<div class="col-xs-12">
		<h2 class="text-center">Rate Entries</h2>
		<br/>
	</div>
</div>
<div class="row">
  <div class="col-xs-2"></div>
	<div class="col-xs-10">
	<form class="form-inline" method="GET">
    <div class="form-group">
    	<label for="rate_assigned">Rate Assigned</label>
			<select class="form-control force-extend" name="_rate" id="rate_assigned">
				<option selected>-Select-</option>
				<option <?=$stub['_rate'] == 'ALL' ? 'selected' : ''?>>ALL</option>
				<option <?=$stub['_rate'] == 'YES' ? 'selected' : ''?>>YES</option>
				<option <?=$stub['_rate'] == 'NO' ? 'selected' : ''?>>NO</option>
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
		<div class="form-group">
		<br/>
		 <button type="submit" class="btn btn-danger">Filter</button>
		</div>	
		</form>
	</div>
</div>
<br/>
<div class="row">
	<div class="col-xs-2"></div>
	<div class="col-xs-8">
<?php if(count($forms)): ?>
		<table class="table table-bordered">
			<tr>
				<td align="center">Gate Entry Id</td>
				<td width="20%" align="center">Party Name</td>
				<td width="15%" align="center">Stock Item</td>
				<td width="10%" align="center">Bags</td>
				<td width="10%" align="center">Weight in Kg</td>
				<td width="10%" align="center">Weight in Quintals</td>
				<td width="15%" align="center">Weight unit</td>
				<td width="15%" align="center">Rate per unit</td>
				<td width="15%" align="center">Date</td>
				<td width="10%" align="center">Remarks</td>
			</tr>
	<form method="post" action="<?=site_url('data/rateEntryUpdate')?>">
	<?php  foreach($forms as $key => $form): ?>
			 <tr> 
		     <td align="center">#<?=$form->ge_id?></td>
		     <td align="center"><?=$form->gateEntry->accounts->name?></td>
				 <td align="center"><?=$form->stockItems->name?></td>
				 <td align="center"><?=$form->bags?></td>
				 <td align="center">
				 <select class="form-control" name="data[<?=$form->id?>][weight_unit]">
				 <?php foreach ($wtUnits as $unit): ?>
	 			 	<option <?=($form->weight_unit == $unit->name) ? 'selected' : '' ?> value="<?=$unit->name?>"><?=$unit->name?></option>
	 			 <?php endforeach; ?>	
				 </select>
				 </td>
				 <td align="center"><input type="text" name="data[<?=$form->id?>][rate_per_unit]" class='form-control' value="<?=$form->rate_per_unit?>"/></td>
				 <td align="center"><?=date('M d,Y',strtotime($form->created_at))?></td>
				 <td align="center"><?=$form->remarks?></td>
			</tr>
	<?php endforeach; ?>
			<td><button type="submit" class="btn btn-danger">Update</button></td>
		</form>		
		</table>
	<?php else:?>
	<h4 class="text-center">No Records Found ! </h4>
	<?php endif;?>

	</div>
</div>
<? $this->load->view('admin/partials/footer'); ?>
