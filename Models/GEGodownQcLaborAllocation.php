<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEGodownQcLaborAllocation extends Model
{
    protected $table    = 'ge_material_qc_labour_allocation';
    protected $fillable = [
      'stock_item_id',
			'godown_id',
			'labour_party_id',
			'quality_cut_id',
			'remarks',
			'bags',
			'labour_job_type_id',
      'rate_per_unit',
      'weight_unit',
      'weight_in_kg',
      'rate',
      'rate_contract_id'
    ];

  public function godown(){
    return $this->belongsTo(Godowns::class, 'godown_id', 'id');
  }
    
  public function stockItems(){
    return $this->belongsTo(StockItems::class, 'stock_item_id', 'id');
  }

  public function rateContract(){
    return $this->belongsTo(RateContracts::class, 'rate_contract_id', 'id');
  }

  public function labourJobType(){
    return $this->belongsTo(LabourJobTypes::class, 'labour_job_type_id', 'id');
  }

  public function gateEntry(){
  	 return $this->belongsTo(GateEntry::class, 'ge_id', 'id');
  }

  function scopeWhereAccountIds($query,$ids){
    return $query->whereHas('gateEntry', function ($query) use ($ids) {
           $query->whereIn('account_id', $ids);
      });
  }  

}
