<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Capsule\Manager as DB;

class LaborPayments extends Model
{
    protected $table    = 'labor_payments';
    protected $fillable = ['ge_id','labour_party_id','amount','from_balance_amount','payment_account_id','transaction_id'];

}
