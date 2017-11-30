<fieldset> 
  <legend>Credit / Payment Transactions</legend>
   <div class="form-group">
   <table class="table table-stripped" id="credit_trans">
     <tr>
       <th>Account</th>
       <th>Amount</th>
       <th>Remarks</th>
       <th>Date</th>
       <th></th>
     </tr>
     <tr  v-for='(item, index) in transactionsFilter("CREDIT")' :key="item.hash" v-bind:id="index">
      <td colspan="4">
        <table>
          <tr>
             <td>
           
                 <input type="hidden" class="mousetrap" :name="'trx['+ item.hash + '][id]'" v-bind:value="item.id" />
                 <input type="hidden" :name="'trx['+ item.hash + '][secondary_account_id]'" v-bind:value="item.secondary_account_id" />

                   <agdropdown  class="cash_transaction_forms" v-bind:hidden_field_name="'trx['+ item.hash + '][primary_account_id]'" v-bind:options="accounts" v-model="item.primary_account_id" @input=agDropDownInputCallBack(index,'paid-amount')> 
                   </agdropdown>  

            
             </td>
             <input type="hidden" class="form-control mousetrap" 
                v-bind:value="item.id" 
                v-bind:name="'trx['+ item.hash + '][id]'">
             <td><input type="text" class="form-control mousetrap paid-amount" 
                v-model="item.amount" 
                min="0" 
                v-bind:name="'trx['+ item.hash + '][amount]'"></td>

          
             <td>
              <datepicker 
                class="form-control required transaction_date mousetrap" 
                v-bind:name="'trx['+ item.hash + '][transaction_date]'"
                v-model="item.transaction_date" v-bind:style="transactionDateStyle(item.date_valid)"
              />
             </td>
             <td> <span class="glyphicon glyphicon-trash mousetrap" id="delete_row" 
                v-on:click="removeTransaction(item.hash)" aria-hidden="true"></span> <input type="hidden" 
                v-bind:name="'trx['+ item.hash + '][entry_type]'" value="CASH">
              </td>
          </tr>
           <tr>
              <td colspan="4">
              <textarea type="text" v-tooltip class="mousetrap form-control"
                    v-bind:name="'trx['+ item.hash + '][remarks]'"   v-bind:title="item.remarks" v-model="item.remarks"
                    v-bind:value="item.remarks" class="form-control" rows="1" placeholder="Remarks"></textarea>
              </td>

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
      <span class="glyphicon glyphicon-plus ctrl_y_click" id="add_row" aria-hidden="true"  data-ctr_y_area_selector="#credit_trans" v-on:click="insertEmptyTransaction('CREDIT')"></span>
    </div>
  </div>
</fieldset>  
<div class="fieldset-spacer"></div>
