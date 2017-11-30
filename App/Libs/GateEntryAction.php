<?php 
namespace App\Libs;
use Models;
use Illuminate\Database\Capsule\Manager as DB;
class GateEntryAction{
	function __construct(){

	}

   /*
	   @1 -Cancelation reason 
	   @2 - Canceled by user_id 
	   @3 - Original Gateentry id  
   */
	public static function cancel($reason,$user_id,$ge_id){
		
		GateEntryAction::copyGateEntryDataToCanceledTables($reason,$user_id,$ge_id);

	}

	public static function copyGateEntryDataToCanceledTables($reason,$user_id,$ge_id){

		
		$tables = [
			'canceled_ge_bag_types' => 'ge_bag_types',
			'canceled_ge_cmr_details' => 'ge_cmr_details',
			'canceled_ge_cmr_rice_delivery_details' => 'ge_cmr_rice_delivery_details',
			'canceled_ge_delivery_details' => 'ge_delivery_details',
			'canceled_ge_delivery_qc' => 'ge_delivery_qc',
			'canceled_ge_godown_labor_allocation' => 'ge_godown_labor_allocation',
			'canceled_ge_material_qc_labour_allocation' => 'ge_material_qc_labour_allocation',
			'canceled_ge_quality_cut' => 'ge_quality_cut',
			'canceled_ge_stock_items' => 'ge_stock_items',
		];

		$gateEntry = Models\GateEntry::find($ge_id);
		if(!$gateEntry)
			return 404;
		$gate_entry = $gateEntry->toArray();
		$gate_entry['orig_id'] = $gate_entry['id'];
		$gate_entry['cancelation_reason'] = $reason;
		$gate_entry['canceled_by_user_id'] = $user_id;
		
	 	unset($gate_entry['id']);	
		
		DB::beginTransaction();
		try{
			//Migration pending orig_id
		
			DB::table('canceled_gate_entries')->insert($gate_entry);


			foreach ($tables as $can_tab => $table) {
				if($can_tab == 'canceled_ge_delivery_details' || $can_tab == 'canceled_ge_delivery_qc' )
				 		$results = DB::table($table)->where('gate_entry_id', $ge_id)->get();				
				else
						$results =DB::table($table)->where('ge_id', $ge_id)->get();
					
				if(!count($results))
					continue;

				foreach ($results as $res) {			
					$origId = $res->id;					
					$res->orig_id = $origId;
					$savearray = (Array)$res;
					unset($savearray['id']);
				
					$resp = DB::table($can_tab)->insert($savearray);
					DB::table($table)->where('id',$origId)->delete();
				}


			}	

			DB::table('gate_entries')->where('id',$ge_id)->delete();
			


		}catch(\Exception $e){
			echo $e->getMessage();
			DB::rollBack();
			die('Unable to cancel due to some errors.');
		}
		DB::commit();
		return true;		
	}





}