<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Capsule\Manager as DB;

class Transactions extends Model
{
    protected $table    = 'transactions';
    protected $fillable = ['entry_type',  'primary_account_id', 'amount','remarks','secondary_account_id','transaction_date'];



    public static function balanceTill($date ,$accountId)
    {   
        $total = 0;
        $date = $date.' 23:59:59';
        $accountRecord = Accounts::where('ob_date','<=', $date)
                                ->where('id', $accountId)->first();
        
        $credit = self::creditUntil($date ,$accountId);
        $debit = self::debitUntil($date ,$accountId);
        
        if(!empty($accountRecord))
             $total = $debit  + $accountRecord->ob_amount - $credit;
         else
      	    $total =  $debit- $credit;
        return round($total,2);
    }

    public static function creditBetween($from, $to, $accountId){
        $amount = self::where('secondary_account_id', $accountId)
                         ->between($from, $to)
                         ->sum('amount');
        return round($amount,2);
    }

    public static function debitBetween($from, $to, $accountId){
        $amount = self::where('primary_account_id', $accountId)
                        ->between($from, $to)
                        ->sum('amount');
        return round($amount,2);
    }

    public static function creditUntil($date, $accountId){
        $amount = self::where('secondary_account_id', $accountId)
                        ->until($date)
                        ->sum('amount');
        return round($amount,2);        
    }

    public static function debitUntil($date, $accountId){
        $amount = self::where('primary_account_id', $accountId)
                        ->until($date)
                        ->sum('amount');
        return round($amount,2);        
    }

    public function scopeBetween($query, $from, $to){
        return $query->where('transaction_date', '>=', $from)
                    ->where('transaction_date', '<=', $to);
    }

    public function scopeWhereAccountID($query, $accId){
        return $query->where(function($query) use ($accId){
            $query->where('primary_account_id', $accId)
                  ->orWhere('secondary_account_id', $accId);
        });            
    }

    public function scopeUntil($query, $to){
        return $query->where('transaction_date', '<=', $to);
    }
     
    function laborPayment()
    {
        return $this->hasOne(LaborPayments::class, 'transaction_id', 'id');   
    }

    function primaryAccount()
    {
        return $this->hasOne(Accounts::class, 'id', 'primary_account_id');   
    }
      
    function secondaryAccount()
    {
        return $this->hasOne(Accounts::class, 'id', 'secondary_account_id');   
    }

    static function closingBalance($toDate, $primaryAccountId)
    {   
        if(empty($toDate))
            $toDate = date('Y-m-d');

        return Transactions::balanceTill($toDate,$primaryAccountId);
    }

    public static function openingBalance($fromDate, $accountId)
    {     
        $fromDate = date('Y-m-d', strtotime($fromDate . ' -1 day'));
        return Transactions::balanceTill($fromDate,$accountId);
    }
}
