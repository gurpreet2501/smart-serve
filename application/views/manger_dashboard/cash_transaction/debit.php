<fieldset> 
  <legend>Debit / Received Transactions</legend>
   <div class="form-group" >
     <table class="table table-stripped" id="debit_trans">
       <tr>
         <th>Account</th>
         <th>Amount</th>
         <th>Date</th>
         <th></th>
       </tr>
       <tr v-for='(item, index) in transactionsFilter("DEBIT")' :key="item.hash" v-bind:id="index">
        <td colspan="4">
          <table cellpadding="0px" cellspacing="0px">
            <tr>
              <td>
                <input type="hidden" class="mousetrap" :name="'trx['+ item.hash + '][id]'" v-bind:value="item.id" />
                <input type="hidden" class="mousetrap" :name="'trx['+ item.hash + '][primary_account_id]'" v-bind:value="item.primary_account_id" />

                  <agdropdown class="mousetrap cash_transaction_forms"  next_field_id="" v-bind:hidden_field_name="'trx['+ item.hash + '][secondary_account_id]'"  v-bind:options="accounts" v-model="item.secondary_account_id" @input=agDropDownInputCallBack(index,'debit_amount') > 
                  </agdropdown>  
                
               </td>

               <td ><input type="text" class="form-control mousetrap received-items debit_amount" 
                    v-model="item.amount" v-bind:name="'trx['+ item.hash + '][amount]'"></td>

                <input type="hidden" class="form-control mousetrap" 
                    v-bind:value="item.id" 
                    v-bind:name="'trx['+ item.hash + '][id]'">

          

                <td>
                
                <datepicker 
                  class="form-control required mousetrap" 
                  v-bind:name="'trx['+ item.hash + '][transaction_date]'"
                  v-bind:style="transactionDateStyle(item.date_valid)"
                  v-model="item.transaction_date"
                />
                </td>

                <td> <span class="glyphicon glyphicon-trash mousetrap" id="delete_row" 
                    v-on:click="removeTransaction(item.hash)" aria-hidden="true"></span></td>
                <input type="hidden" 
                    v-bind:name="'trx['+ item.hash + '][entry_type]'" class="mousetrap" value="CASH">
              
            </tr>
            <tr>
              <td colspan="4">
                  <textarea type="text" class="mousetrap form-control" placeholder="Remarks" 
                          v-tooltip
                          v-bind:value="item.remarks"   
                          v-bind:title="item.remarks" 
                          v-model="item.remarks"
                          v-bind:name="'trx['+ item.hash + '][remarks]'"  class="form-control _tooltip" rows="1"></textarea> </td>
            </tr>
          </table>
          </td> 
        </tr>
        <br/>
     </table>
  </div> <!-- div ends -->

   <div class="row pull-right">
    <div class="col-xs-12 ">
    <span class="shortcut">(ctrl+y)</span>
      <span class="glyphicon glyphicon-plus ctrl_y_click" aria-hidden="true"
       data-ctr_y_area_selector="#debit_trans"
       id="add_row" aria-hidden="true" 
          v-on:click="insertEmptyTransaction('DEBIT')"></span>
    </div>
  </div>
</fieldset>  
<div class="fieldset-spacer"></div>

