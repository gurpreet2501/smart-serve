jQuery(function($){
    
    function calculateTotals(data){

       var rate = parseFloat(data.value);
	  	 var values = []  ;
	  	 var total = 0;
	  	 
	  	 $(data).parent().parent().find('.bag_exists').each(function(key, data){
	  	 		  var v = parseFloat($(data).text());
						total = total + v * rate;
	  	 });
	  	 
	  	 $(data).parent().parent().find('.labour_acc_entry_total').html(numeral(total).format('0,0.00'));

	  	 if(!total)
	  	   $(data).parent().parent().find('.labour_acc_entry_total').html(0.0);

	  	 //Grand total
	     var grandTotal = 0;
	  	 $('.labour_acc_entry_total').each(function(){
	  	 	 grandTotal = grandTotal + parseFloat($(this).text().replace(/,/g , ''));
	  	   $('.grandTotal').html(numeral(grandTotal).format('0,0.00'));
	  	 });

    }

    //Calculating totals on page load
    var records = $('tr.labAcc').find('.labour_acc_rate');
    $(records).each(function(){
     		 if(this.type == 'hidden')
     		 	return;

     		 calculateTotals(this);
     });

    //Calculating totals on keyUp when rate is entered
	  $('tr.labAcc .labour_acc_rate').keyup(function(){
	  	calculateTotals(this);
	  });



});		 
