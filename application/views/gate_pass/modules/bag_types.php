<fieldset> 
  <legend>Bag Type</legend>

  <div class="form-group">
   <table class="table table-stripped">
     <tr>
      <td width="100px">
      <div class='bold'>Bag Type</div>
      <div class='bold'>No. of Bags</div>
     </td>
        <td v-for='_bagType in bag_types'>
          <div class='bold'>{{_bagType.stock_item.name}}</div>
          <div>
            <input type="number" 
                   class="form-control bag_type bag_wt_update" 
                   min="0" 
                   v-bind:style="validBagCountTypeStyle"
                   v-model="_bagType.bags" 
                   v-bind:name="'bag_types[' + _bagType.stock_item.id + ']'" 
            />

          </div>
        </td>      
       <td>
          <div>Total</div>
          <div class="bag_type_total color_red">{{computedBagTypesBag}}</div>
      </td>
     </tr>
   </table>
<!--     <input type="text" 
           style='height:0;width:0; border:0'  
           name="_validate_bag_types"
           data-rule-bagtypes="true" 
           /> -->
  </div>

</fieldset>

<div class="fieldset-spacer"></div>
