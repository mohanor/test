(function ($)
{
	"use strict";

	var selectedInput = []

	function handleSelect(input, index) 
	{
		const formParent = document.getElementsByClassName('from-control-1-parent')
		const total = document.getElementById("hidden-mtn")

		if (input.readOnly == false) {
			input.readOnly = true;
			input.classList.remove("montant-select")
			formParent[index].classList.remove("montant-parent");
			input.value = ""

			selectedInput = selectedInput.filter(e => e !== input.id);
			if (selectedInput.length) {
				const input = document.getElementById(selectedInput[0])

				if (input.value == "0" || input.value == "")
					input.value = total.value
			}

			return ;
		}

		input.readOnly = false
		input.classList.add("montant-select");
		formParent[index].classList.add("montant-parent");

		if(selectedInput.length == 0) {
			input.value = total.value
			selectedInput.push(input.id)
		} else {
			selectedInput.push(input.id)
		}

		if (input.value == "")
			input.value = 0;

	}


	$(document).ready(function()
	{
		// atef card012
		var cash2 = document.getElementById('cash012')
        var card = document.getElementById('card012')
        var check = document.getElementById('check012')

		var isCashSelect = false
		var isCardSelect = false
		var isCheckSelect = false

		cash2.addEventListener("click", e => {
			var input = e.target
			isCashSelect = !isCashSelect
			handleSelect(input, 1)
		})

        	card.addEventListener("click", e => {

			var input = e.target
			isCardSelect = !isCardSelect

			handleSelect(input, 0)

		})

        	check.addEventListener("click", e => {
			var input = e.target
			isCheckSelect = !isCheckSelect
			handleSelect(input, 2)
		})
		// end

		$('.fs-modal').on('click', '.complete-payment', function ()
		{
			var payment_id = $('#info_modal_JS').data('payment-id');

			// atef
			var cash = document.getElementById('cash012').value
			var card = document.getElementById('card012').value
			var check = document.getElementById('check012').value
			// end

			// atef.  i add this 3 prams: cash, card, check

			if(!isCashSelect && !isCardSelect && !isCheckSelect) {
				booknetic.toast('Prière de sélectionner un mode de paiement', 'unsuccess');
				return
			}



			booknetic.ajax('payments.complete_payment', {id: payment_id, cash: cash, card: card, check: check}, function ()
			{
				booknetic.reloadModal( $('#info_modal_JS').data('mn') );
				booknetic.dataTable.reload( $("#fs_data_table_div") );
			});

		});

	});

})(jQuery);