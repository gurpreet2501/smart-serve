<?php 

function getPaymentBalance($party_id){
	$ci = &get_instance();
	$query = $ci->db->query("SELECT sum(transactions.amount) as total FROM `transactions` 
						left join `labor_payments` on transactions.id=labor_payments.transaction_id
						where secondary_account_id = ".$ci->db->escape($party_id)."
						AND labor_payments.transaction_id IS NULL");

	$total = $query->result_array()[0]['total'];

	$from_balance_amount = getFromBalanceAmount($party_id);
	
	return $total - $from_balance_amount;

}

function getFromBalanceAmount($party_id){

	$total = 0;
	$entries = Models\LaborPayments::where('labour_party_id', $party_id)->get();

	foreach ($entries as $key => $v) 
		$total = $total + $v->from_balance_amount;

	return $total;	

}


function payLaborParty($amount, $from_balance_amount, $ge_id, $payment_account_id, $labor_party_id){
	
	$transaction = Models\Transactions::create([
		'entry_type' => 'CASH',
		'transaction_date' => date('Y-m-d'),
		'amount' => $amount,
		'primary_account_id' => $payment_account_id,
		'secondary_account_id' => $labor_party_id
	]);

	if($transaction)
		Models\LaborPayments::create([
				'ge_id' => $ge_id,
				'labour_party_id' => $labor_party_id,
				'amount' => $amount,
				'from_balance_amount' => $from_balance_amount,
				'payment_account_id' => $payment_account_id,
				'transaction_id' => $transaction->id
		]);

}