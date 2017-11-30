<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use App\Libs\GateEntryAction as GEA;
class Gate_pass extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_force();
	}

	public function index($id = null)
	{	

		$obj = GEA::cancel('No reason',2,3);

		$accounts = Models\Accounts::whereGroupName(['SundryDebtors','SundryCreditors'])->orderBy('name')->get();
		
		$gateEntry = $id ? Models\GateEntry::with('godownQcLaborAllocation')
								 ->with('stockItems.stockItem')
								 ->with('bagTypes.stockItem')
								 ->with('qualityCuts')
								 ->with('godownLaborAllocation')
								 ->with('cmrDetails')
								 ->with('cmrRiceDeliveryDetails')
								->find($id)
						: null;
					
		$cmrSocieties = Models\CMRSocieties::get();
		
		$cmrMarkets = Models\CMRMarkets::get();

		$labourParties = Models\Accounts::whereLabourParty()->with('laborPartyJobTypes.labourJobTypes')->get();
		$stockItems =  Models\StockItems::get();
		
		$forms = Models\Forms::with('modules.stockGroups.stockItems')
							->with('modules.labourJobCategories.jobTypes.parties')
							->with('modules.qualityCutTypes')
							->with('modules.stockItems.bagWeight')
							->orderBy('name')
							->get();
		
		$cmrMarkets = Models\CMRMarkets::get();
		
		$jsFiles = [
			base_url('assets/js/store.js'),
			base_url('assets/js/sweetalert.js?3354'),
			base_url('assets/js/make-all-caps.js?354'),
			base_url('assets/js/sha1.js'),
			base_url('assets/js/refill-gate-entry.js'),
			base_url('assets/js/components/datepicker.js'),
			base_url('assets/js/components/agdropdown.js'),
			base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
			base_url('assets/js/vue/select2.component.js'),
			base_url('assets/js/gate-pass-no-validation-method.js'),
			base_url('assets/js/quality-cut-validation-method.js'),
			base_url('assets/js/tp-date-validation-method.js'),

			!($this->config->item('allow_common_field_editing')) ? base_url('assets/js/gate-entry-weight-reader.js?5113') : '',
		];
		$jsFiles = array_merge($jsFiles, vue_app_bundle('gate-entry'));
		$cssFiles = [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')];
    
    $quality_cut_types = Models\QualityCutTypes::get();
    
		$data = [
		  'isUpdate' => (Boolean)$id,
			'autofill' => common_fields_autofill($id),
			'gateEntry' => $gateEntry,
			'godowns' 		=> Models\Godowns::get(),
			'cmr_agencies' 	=> Models\CMRAgencies::get(),
			'delivery_destinations' => Models\DeliveryDestinations::get(),
			'fci_godowns' 	=> Models\FCIGodowns::get(),
			'js_files' 		=> $jsFiles,
			'accounts' 			=> $accounts,
			'css_files' 		=> $cssFiles,
			'cmr_markets' 	=> $cmrMarkets,
			'for_js' => [
			  		'accounts' 			=> $accounts,
			  		'laborParties' 		=> $labourParties,
			  		'isUpdate' 			=> (Boolean)$id,
			  		'SECOND_WEIGHT' 	=> (Boolean)$id,
					'gate_entry'		=> $gateEntry,
					'forms' 			=> $forms,
					'labour_parties_with_job_types' => $labourParties,
					'cmr_markets'		=> $cmrMarkets,
					'cmr_societies'		=> $cmrSocieties,
					'm_serial_no'  => Models\GECMRDetails::max('m_serial_no') + 1,
				]			
	  	];

		$this->load->view('gate_pass/index', $data);
	}

	private function getPrice($post)
	{

		if (empty(@$post['account_id']))
			return [];

		// collect stop items
		$items = [];
		if (!empty(@$post['stock_items']))
			$items['GE_STOCK_ITEMS'] = array_keys($post['stock_items']);

		if (!empty(@$post['ge_godown_qc_labor_allocation']))
		{
			$items['GE_LABOR_ALLOCATION'] = [];
		
			foreach ($post['ge_godown_qc_labor_allocation'] as $item) 
				$items['GE_LABOR_ALLOCATION'][] = $item['stock_item_id'];
		}

		if (!class_exists('Rate_contracts'))
			$this->load->library('rate_contracts');

		$rateContracts = new Rate_contracts();

		$ret = [];
		foreach ($items as $inputSource => $ids) 
		{
			foreach ($ids as $stockId)
			{
				$resp = $rateContracts->getRate($post['account_id'], $stockId, date('Y-m-d'), 'BAGS', $inputSource);
				if (!is_null($resp))
					$ret[$inputSource][]  = array_merge($resp, ['stock_item_id' => $stockId]);
			}
		}

		return $ret;
	}

	private function storePrice($post, $gateId)
	{

		foreach ($this->getPrice($post) as $index => $items) 
		{
			foreach ($items as $v) 
			{
				$record = ($index == 'GE_STOCK_ITEMS') 
			        ? Models\GEStockItems::class
			        : Models\GEGodownQcLaborAllocation::class;	
			
				$updated = $record::where('stock_item_id', $v['stock_item_id'])
				   ->where('ge_id', $gateId)
				   ->update([
				   		'rate_contract_id' => $v['contract_id'],
				   		'rate' => $v['rate']
				   	]);
			}			
		}		
	}



	public function save($id = null)
	{ 
		$r = $_POST;
		
		//Dont bind again prefix and serial while update
		if(!$id)
			$r = bindSerialAndPrefix($r);

		if($id)
			$r['id'] = $id;
		
		if(isset($r['ge_godown_qc_labor_allocation'])){
			$data = array_values($r['ge_godown_qc_labor_allocation']);
			if(!isset($data[0]) || !isset($data[0]['labour_party_id']))
				unset($r['ge_godown_qc_labor_allocation']);
		}
		
		//Setting rate in gegodownqc labour allocation table for Daily Labour account entries
		if(isset($r['ge_godown_qc_labor_allocation'])){
			
					foreach ($r['ge_godown_qc_labor_allocation'] as $key => $v) {

						 if(!isset($v['labour_party_id']))							
								logErrors('undefined index labour_party_id',__FILE__,__LINE__, func_get_args());

							 $rate_entry = Models\LabourPartyJobTypes::where('account_id', $v['labour_party_id'])
								 													->where('labour_job_type_id', $v['labour_job_type_id'])
								 													->first();
								

						 	// if(!$rate_entry)
						 	// 	continue;
						 		$r['ge_godown_qc_labor_allocation'][$key]['rate'] = $rate_entry->rate;											
								// $v['rate'] = $rate_entry->rate;
					}

				



		}
		// if(isset($r['stock_items'])){
		// 	foreach ($r['stock_items'] as $key => $v) {
		// 		$rc = new Rate_contracts();

		// 		$rateContracts[] = !empty($rc->getContracts($r['account_id'], $key, date('Y-m-d H:i:s'), $v)) 
		// 		  					? $rc->getContracts($r['account_id'], $key, date('Y-m-d H:i:s'), $v)
		// 		  					: [];
		// 		}
		// }
	

	  // Checking for duplicate entries.
	  
		$obj = new Models\GateEntry;	
		$exists = $obj->checkSimilarEntries($r);
		
		if($exists){
			failure('Entry Already exists.');
			redirect('gate_pass/index');
		}

		$updateFlag = false;	

		if($id)	{
			$ge = Models\GateEntry::find($id);
			$updateFlag = true;
		}
		else{
			$ge = new Models\GateEntry();
			// $ge->setFirstWeightDate();
		}
		
		if(isset($r['deduct_packing_material'])){
			if($r['deduct_packing_material'] == 'on')
				$r['deduct_packing_material'] = true;
			else
				$r['deduct_packing_material'] = false;
		}
		
		$ge->saveCommonData($r);

		if(!$updateFlag){
				$ge->setFirstWeightDate();
		}
		
		if(isset($r['stock_items'])){
			$ge->saveStockItems($r['stock_items']);
			//Saving Transactions in transaction table
			// $ge->saveTransactions($r['stock_items'],$r['entry_type']);
		}
		
		if(isset($r['bag_types']))
			$ge->saveBagTypes($r['bag_types']);
		
		if(isset($r['quality_cut']))
			$ge->saveQualityCuts($r['quality_cut']);
		
		if(isset($r['ge_godown_labor_allocation']))
			$ge->saveGodownLaborAllocation($r['ge_godown_labor_allocation']);

    if(isset($r['ge_godown_qc_labor_allocation']))
			$ge->saveGodownQcLaborAllocation($r['ge_godown_qc_labor_allocation'], $r['net_weight']);

		if(isset($r['cmr_details'])){
			$ge->saveCMRDetails($r['cmr_details']);
		}

		if(isset($r['cmr_rice_delivery_details']))
			$ge->saveCMRRiceDeliveryDetails($r['cmr_rice_delivery_details']);

		// if(isset($r['stock_items']))
		// 	$ge->updateRateContractsInStockItems($rateContracts, $ge->id);

		if($updateFlag)
		{   
			$ge->setSecondWeightDate();
			$ge->completeStatus();
		  	success('Data Saved Successfully!');

		  	$this->storePrice($_POST, $id);

			redirect('weight_receipt/print_slip/'.$id);
		}

		success('Data Saved Successfully!');

		redirect('dashboard/index/'.$id);
	}
}

