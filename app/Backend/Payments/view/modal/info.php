<?php

defined( 'ABSPATH' ) or die();

use BookneticApp\Backend\Appointments\Helpers\AppointmentSmartObject;
use BookneticApp\Providers\Helpers\Helper;
use BookneticApp\Providers\Helpers\Date;

/**
 * @var $parameters AppointmentSmartObject[]
 * @var mixed $_mn
 */

?>

<link rel="stylesheet" href="<?php echo Helper::assets('css/info.css', 'Payments')?>">
<script type="text/javascript" src="<?php echo Helper::assets('js/info.js', 'Payments')?>" id="info_modal_JS" data-mn="<?php echo $_mn?>" data-payment-id="<?php echo (int)$parameters['info']->getId()?>"></script>

<div class="fs-modal-title">
	<div class="title-icon badge-lg badge-purple"><i class="fa fa-credit-card "></i></div>
	<div class="title-text"><?php echo bkntc__('Payment info')?></div>
	<div class="close-btn" data-dismiss="modal"><i class="fa fa-times"></i></div>
</div>

<div class="fs-modal-body">
	<div class="fs-modal-body-inner">
		<div class="bordered-light-portlet">
			<div class="form-row">
				<div class="col-md-3">
					<label><?php echo bkntc__('Staff:')?></label>
					<div class="form-control-plaintext text-primary">
						<?php echo htmlspecialchars( $parameters['info']->getStaffInf()->name )?>
					</div>
				</div>
				<div class="col-md-3">
					<label><?php echo bkntc__('Location:')?></label>
					<div class="form-control-plaintext">
						<?php echo htmlspecialchars( $parameters['info']->getLocationInf()->name )?>
					</div>
				</div>
				<div class="col-md-3">
					<label><?php echo bkntc__('Service:')?></label>
					<div class="form-control-plaintext">
						<?php echo htmlspecialchars( $parameters['info']->getServiceInf()->name )?>
					</div>
				</div>
				<div class="col-md-3">
					<label><?php echo bkntc__('Date, time:')?></label>
					<div class="form-control-plaintext">
                        <?php echo Date::dateTime( $parameters['info']->getAppointmentInfo()->starts_at ); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="form-row mt-4">
			<div class="form-group col-md-12">
				<div class="fs_data_table_wrapper">
					<table class="table-gray-2 dashed-border">
						<thead>
						<tr>
							<th><?php echo bkntc__('CUSTOMER')?></th>
							<th><?php echo bkntc__('METHOD')?></th>
							<th><?php echo bkntc__('STATUS')?></th>
						</tr>
						</thead>
						<tbody>
						<?php

						$status = htmlspecialchars( $parameters['info']->getInfo()->payment_status );

						echo '<tr data-customer-id="' . (int)$parameters['info']->getInfo()->customer_id . '" data-id="' . (int)$parameters['info']->getId() . '">';
						echo '<td>' . Helper::profileCard($parameters['info']->getCustomerInf()->full_name, $parameters['info']->getCustomerInf()->profile_image, $parameters['info']->getCustomerInf()->email, 'Customers') . '</td>';
						echo '<td>' . Helper::paymentMethod( $parameters['info']->getInfo()->payment_method ) . '</td>';
						echo '<td><span class="payment-status-' . $status . '"></span></td>';
						echo '</tr>';
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		
		<div class="form-row" style="gap: 20px;">
			
			<!-- i want to make this part as plugin and show here -->
			<div  class="checkout-details col-md-6 mx-lg-auto"
				style="display: flex;
    				flex-direction: column;
    				justify-content: space-between;"
			>
				<h6 class="text-center mb-0">Méthode de paiement</h6>
				<div class="from-control-1-parent input-group">
					<div class="input-group-prepend">
						<span class="input-group-text input-group-text-svg" id="basic-addon1" style="width: 60px;">



						<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" version="1.1" style="shape-rendering:geometricPrecision;text-rendering:geometricPrecision;image-rendering:optimizeQuality;" x="0px" y="0px" clip-rule="evenodd" viewBox="0 0 8200 5159" fill="#8f8996" height="25">
							<defs>
								<style type="text/css">
								.fil0 {
									fill-rule: nonzero
								}
								</style>
							</defs>
							<g>
								<g>
								<path class="fil0" d="M305 1671l1713 0 0 -1366c0,-168 137,-305 305,-305l5572 0c168,0 305,137 305,305 0,959 0,1918 0,2877 0,168 -138,305 -305,305l-1713 0 0 1366c0,168 -137,306 -305,306l-5572 0c-167,0 -305,-138 -305,-306 0,-959 0,-1917 0,-2876 0,-168 137,-306 305,-306zm1857 0l3715 0c168,0 305,138 305,306l0 1366 1713 0c88,0 161,-73 161,-161l0 -2079 -5894 0 0 568zm5894 -712l0 -250 -5894 0 0 250 5894 0zm0 -394l0 -260c0,-88 -73,-161 -161,-161l-5572 0c-89,0 -161,73 -161,161l0 260 5894 0zm-7912 1671l5894 0 0 -259c0,-89 -73,-161 -161,-161l-5572 0c-88,0 -161,72 -161,161l0 259zm5894 539l-5894 0 0 2078c0,89 73,161 161,161l5572 0c88,0 161,-72 161,-161l0 -2078zm0 -395l-5894 0 0 251 5894 0 0 -251z" />
								<path class="fil0" d="M5561 4333c0,272 -303,442 -535,293 -19,12 -39,22 -59,30 -226,91 -477,-75 -477,-323 0,-247 251,-412 477,-322 20,8 40,18 59,30 232,-150 535,21 535,292zm-644 181c-68,-110 -68,-251 0,-362l-6 -2c-129,-51 -271,43 -271,183 0,141 143,235 271,184l6 -3zm157 -320c-76,76 -76,203 0,279 124,124 337,35 337,-140 0,-174 -213,-263 -337,-139z" />
								<path class="fil0" d="M712 3573l1101 0 0 432 -1176 0 0 -432 75 0zm951 150l-875 0 0 132 875 0 0 -132z" />
								<polygon class="fil0" points="616,4601 2508,4601 2508,4745 616,4745 " />
								<path class="fil0" d="M7623 2884c0,272 -304,442 -536,292 -18,12 -38,22 -59,31 -225,90 -477,-75 -477,-323 0,-248 252,-413 477,-323 21,9 41,19 59,31 232,-150 536,21 536,292zm-645 181c-68,-110 -67,-252 0,-362l-5 -2c-130,-51 -271,43 -271,183 0,141 142,235 270,184l6 -3zm157 -321c-76,77 -76,203 0,280 125,124 337,34 337,-140 0,-174 -212,-264 -337,-140z" />
								</g>
							</g>
						</svg>

						</span>
					</div>
					<input
						type="number"
						class="form-control montant"
						placeholder="Montant en Dhs" id="card012" aria-label="Username"
						readonly
						aria-describedby="basic-addon1"
					>

					<input
						id="hidden-mtn"
						type="hidden"
						class="form-control montant"
						placeholder="Montant en Dhs" id="card012" aria-label="Username"
						readonly
						value=<?php echo substr(Helper::price( $parameters['info']->getTotalAmount() ), 1) ?>
						aria-describedby="basic-addon1"
					>

				</div>

				<div class="from-control-1-parent input-group">
					<div class="input-group-prepend">
						<span class="input-group-text input-group-text-svg" id="basic-addon1" style="width: 60px;">

						<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" x="0px" y="0px" viewBox="2.5 15.56 89.97 63.88" fill="#8f8996" height="25">
								<defs>
									<style>
									.cls-1 {
										fill-rule: evenodd;
										stroke-width: 0px;
									}
									</style>
								</defs>
								<path class="cls-1" d="m19.4,39.72h2.48l41.76-11.19c.56-.15,1.14.18,1.29.75.39,1.47,1.35,2.64,2.57,3.34h0c1.22.7,2.71.94,4.18.55.56-.15,1.14.18,1.29.75l1.56,5.81h3.03l-4.49-16.74L4.65,41.31l9.19,34.29,3.63-.97v-9.35c-.24-.04-.49-.06-.74-.06-.49,0-.99.06-1.5.19-.56.15-1.14-.18-1.29-.75l-3.73-13.93c-.15-.56.18-1.14.75-1.29,1.47-.39,2.64-1.34,3.34-2.56.7-1.22.94-2.71.55-4.18-.15-.56.18-1.14.75-1.29l2.05-.55c.1-.21.23-.4.39-.56h0c.35-.36.83-.57,1.36-.57h0Zm-13.35-.97l-.63-2.34c-.14-.51-.05-1.03.2-1.46h0s0,0,0,0c.25-.43.66-.76,1.17-.9L75.53,15.63c.51-.14,1.03-.05,1.46.2h0s0,0,0,0c.43.25.76.66.9,1.17l6.09,22.73h6.57c.53,0,1.01.22,1.36.57h0c.35.36.56.84.56,1.37v35.84c0,.53-.22,1.01-.57,1.36h0c-.35.36-.83.57-1.36.57H19.4c-.53,0-1.01-.22-1.36-.57h0c-.35-.36-.57-.84-.57-1.37v-.69l-3.25.87c-.51.14-1.03.05-1.46-.2h0s0,0,0,0c-.43-.25-.76-.66-.9-1.17L2.57,41.69c-.14-.51-.05-1.03.2-1.46h0s0,0,0,0c.25-.43.66-.76,1.17-.9l2.12-.57h0Zm75.76.97h-2.09l-4.68-17.45c-.14-.51-.47-.93-.9-1.17-.43-.25-.95-.33-1.46-.2L8.09,38.21l-.58-2.17,68.41-18.33,5.9,22.02h0Zm-48.76,16.07c1.05,0,1.99.42,2.68,1.11.69.69,1.11,1.63,1.11,2.68s-.42,1.99-1.11,2.68c-.69.69-1.63,1.11-2.68,1.11s-1.99-.42-2.68-1.11c-.69-.69-1.11-1.63-1.11-2.68s.42-1.99,1.11-2.68c.69-.69,1.63-1.11,2.68-1.11h0Zm1.19,2.6c.3.3.49.72.49,1.19s-.19.88-.49,1.19-.72.49-1.19.49-.88-.19-1.19-.49-.49-.72-.49-1.19.19-.88.49-1.19c.3-.3.72-.49,1.19-.49s.88.19,1.19.49h0Zm42.66-2.6c1.05,0,1.99.42,2.68,1.11.69.69,1.11,1.63,1.11,2.68s-.42,1.99-1.11,2.68c-.69.69-1.63,1.11-2.68,1.11s-1.99-.42-2.68-1.11c-.69-.69-1.11-1.63-1.11-2.68s.42-1.99,1.11-2.68c.69-.69,1.63-1.11,2.68-1.11h0Zm1.19,2.6c.3.3.49.72.49,1.19s-.19.88-.49,1.19-.72.49-1.19.49-.88-.19-1.19-.49-.49-.72-.49-1.19.19-.88.49-1.19c.3-.3.72-.49,1.19-.49s.88.19,1.19.49h0Zm-23.11-10.36c3.19,0,6.08,1.29,8.16,3.38,2.09,2.09,3.38,4.98,3.38,8.16s-1.29,6.08-3.38,8.16-4.98,3.38-8.16,3.38-6.08-1.29-8.16-3.38c-2.09-2.09-3.38-4.98-3.38-8.16s1.29-6.08,3.38-8.16c2.09-2.09,4.98-3.38,8.16-3.38h0Zm6.67,4.87c1.71,1.71,2.76,4.07,2.76,6.67s-1.06,4.97-2.76,6.67c-1.71,1.71-4.07,2.76-6.67,2.76s-4.97-1.06-6.67-2.76c-1.71-1.71-2.76-4.07-2.76-6.67s1.06-4.97,2.76-6.67c1.71-1.71,4.07-2.76,6.67-2.76s4.97,1.06,6.67,2.76h0Zm-7.73.36c0-.58.47-1.05,1.05-1.05s1.05.47,1.05,1.05v.16c.59.18,1.12.5,1.55.92.67.67,1.08,1.59,1.08,2.6,0,.58-.47,1.05-1.05,1.05s-1.05-.47-1.05-1.05c0-.43-.18-.83-.46-1.11s-.68-.46-1.11-.46-.83.18-1.11.46-.46.68-.46,1.11c0,1.17.91,1.38,1.81,1.6,1.72.41,3.44.82,3.44,3.65,0,1.02-.41,1.94-1.08,2.6-.43.43-.96.75-1.55.92v.16c0,.58-.47,1.05-1.05,1.05s-1.05-.47-1.05-1.05v-.16c-.59-.18-1.12-.5-1.55-.92-.67-.67-1.08-1.59-1.08-2.6,0-.58.47-1.05,1.05-1.05s1.05.47,1.05,1.05c0,.43.18.83.46,1.11s.68.46,1.11.46.83-.18,1.11-.46.46-.68.46-1.11c0-1.17-.91-1.38-1.81-1.6-1.72-.41-3.44-.82-3.44-3.65,0-1.02.41-1.94,1.08-2.6.43-.43.96-.75,1.55-.92v-.16h0Zm-23.91-13.55l33.22-8.9c.66,1.56,1.8,2.81,3.2,3.62h0s0,0,0,0c1.4.81,3.06,1.17,4.74.96l1.16,4.31H30.02Zm-12.56,23.44c-.23-.03-.47-.04-.71-.04-.34,0-.69.01-1.04.06l-3.23-12.04c1.56-.66,2.81-1.81,3.62-3.21.81-1.4,1.17-3.06.96-4.74l.39-.1v20.07h0Zm67.9,2.65c-1.68.23-3.19,1.01-4.33,2.16s-1.92,2.65-2.16,4.33H31.09c-.23-1.68-1.01-3.19-2.16-4.33-1.14-1.14-2.65-1.93-4.33-2.16v-12.46c1.68-.23,3.19-1.01,4.33-2.16,1.14-1.14,1.92-2.65,2.16-4.33h47.78c.23,1.68,1.01,3.19,2.16,4.33,1.14,1.14,2.65,1.92,4.33,2.16v12.46h0Zm2.11-13.44v14.42c0,.58-.47,1.05-1.05,1.05-1.52,0-2.9.62-3.89,1.61-1,1-1.61,2.37-1.61,3.89,0,.58-.47,1.05-1.05,1.05H30.11c-.58,0-1.05-.47-1.05-1.05,0-1.52-.62-2.9-1.61-3.89-1-1-2.37-1.61-3.89-1.61-.58,0-1.05-.47-1.05-1.05v-14.42c0-.58.47-1.05,1.05-1.05,1.52,0,2.9-.62,3.89-1.61s1.61-2.37,1.61-3.89c0-.58.47-1.05,1.05-1.05h49.75c.58,0,1.05.47,1.05,1.05,0,1.52.62,2.9,1.61,3.89s2.37,1.61,3.89,1.61c.58,0,1.05.47,1.05,1.05h0Zm2.92-10.54v35.49H19.57v-35.49h70.82Z" />
							</svg>



						
						</span>
					</div>
					<input
						type="number"
						class="form-control montant"
						placeholder="Montant en Dhs" id="cash012" aria-label="Username"
						readonly
						aria-describedby="basic-addon1"
					>
				</div>
				
				<div class="from-control-1-parent input-group">
					<div class="input-group-prepend">
						<span class="input-group-text input-group-text-svg" id="basic-addon1" style="width: 60px;">
							<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#8f8996"  viewBox="7.81 18.83 84.38 62.29"   >
								<g>
									<path d="m87.5 35.828h-1.3281l3.4531-8.3438c1.3125-3.1875-0.20312-6.8438-3.375-8.1719-1.5469-0.64062-3.25-0.64062-4.7812 0-1.5469 0.64062-2.75 1.8438-3.3906 3.375l-5.4375 13.125h-60.141c-2.5781 0-4.6875 2.1094-4.6875 4.6875v35.938c0 2.5781 2.1094 4.6875 4.6875 4.6875h75c2.5781 0 4.6875-2.1094 4.6875-4.6875v-35.938c0-2.5781-2.1094-4.6875-4.6875-4.6875zm-4.8438-13.609c0.76562-0.32812 1.625-0.3125 2.3906 0 1.5938 0.65625 2.3438 2.4844 1.6875 4.0781l-0.59375 1.4375-5.7656-2.3906 0.59375-1.4375c0.3125-0.76562 0.92188-1.375 1.6875-1.6875zm-3.4844 6.0156 5.7656 2.3906-2.5469 6.1406v0.03125l-10.594 25.578-5.7812-2.3906 9.1094-21.969v-0.03125zm-9.4844 36.672-3.6562 3.1562-0.34375-4.8125 3.9844 1.6562zm19.375 11.547c0 0.85938-0.70312 1.5625-1.5625 1.5625h-75c-0.85938 0-1.5625-0.70312-1.5625-1.5625v-35.938c0-0.85938 0.70312-1.5625 1.5625-1.5625h58.844l-8.8281 21.281c-0.09375 0.21875-0.125 0.45312-0.10938 0.67188v0.046875l0.73438 10.453c0.046875 0.59375 0.40625 1.1094 0.95312 1.3281 0.1875 0.078125 0.39062 0.125 0.59375 0.125 0.375 0 0.73438-0.125 1.0312-0.375l7.9219-6.8594s0.03125-0.046875 0.046875-0.0625c0.15625-0.14062 0.28125-0.3125 0.375-0.51562l10.797-26.062h2.625c0.85938 0 1.5625 0.70312 1.5625 1.5625v35.938z"/>
									<path d="m21.797 58.141h-2.9688c-0.78125 0-1.4062-0.625-1.4062-1.4062 0-0.85938-0.70312-1.5625-1.5625-1.5625s-1.5625 0.70312-1.5625 1.5625c0 2.4688 1.9844 4.4844 4.4531 4.5156v0.67188c0 0.85938 0.70312 1.5625 1.5625 1.5625s1.5625-0.70312 1.5625-1.5625v-0.67188c2.4688-0.046875 4.4531-2.0469 4.4531-4.5156v-0.75c0-2.5-2.0312-4.5312-4.5312-4.5312h-2.9688c-0.78125 0-1.4062-0.625-1.4062-1.4062v-0.73438c0-0.78125 0.625-1.4062 1.4062-1.4062h2.9688c0.78125 0 1.4062 0.625 1.4062 1.4062 0 0.85938 0.70312 1.5625 1.5625 1.5625s1.5625-0.70312 1.5625-1.5625c0-2.4688-1.9844-4.4844-4.4531-4.5312v-0.67188c0-0.85938-0.70312-1.5625-1.5625-1.5625s-1.5625 0.70312-1.5625 1.5625v0.67188c-2.4688 0.046875-4.4531 2.0469-4.4531 4.5312v0.73438c0 2.5 2.0312 4.5312 4.5312 4.5312h2.9688c0.78125 0 1.4062 0.625 1.4062 1.4062v0.75c0 0.78125-0.625 1.4062-1.4062 1.4062z"/>
									<path d="m59.781 53.016h-28.531c-0.85938 0-1.5625 0.70312-1.5625 1.5625s0.70312 1.5625 1.5625 1.5625h28.531c0.85938 0 1.5625-0.70312 1.5625-1.5625s-0.70312-1.5625-1.5625-1.5625z"/>
									<path d="m31.25 48.328h31.781c0.85938 0 1.5625-0.70312 1.5625-1.5625s-0.70312-1.5625-1.5625-1.5625h-31.781c-0.85938 0-1.5625 0.70312-1.5625 1.5625s0.70312 1.5625 1.5625 1.5625z"/>
									<path d="m57.812 60.828h-26.562c-0.85938 0-1.5625 0.70312-1.5625 1.5625s0.70312 1.5625 1.5625 1.5625h26.562c0.85938 0 1.5625-0.70312 1.5625-1.5625s-0.70312-1.5625-1.5625-1.5625z"/>
									<path d="m55.609 68.641h-39.984c-0.85938 0-1.5625 0.70312-1.5625 1.5625s0.70312 1.5625 1.5625 1.5625h39.984c0.85938 0 1.5625-0.70312 1.5625-1.5625s-0.70312-1.5625-1.5625-1.5625z"/>
								</g>
							</svg>

						</span>
					</div>
					<input
						type="number"
						class="form-control montant"
						placeholder="Montant en Dhs" id="check012" aria-label="Username"
						readonly
						aria-describedby="basic-addon1"
					>
				</div>
				
			</div>
			<!-- end here -->

			<div class="checkout-details col-md-6 mx-lg-auto">
				<h6><?php echo bkntc__('Payment details')?></h6>
				<div class="checkout-details--items">
					<?php foreach ( $parameters['info']->getPrices() AS $price ):?>
						<div>
							<span><?php echo htmlspecialchars($price->name)?></span>
							<span><?php echo Helper::price( $price->price )?></span>
						</div>
					<?php endforeach;?>
				</div>
				<div class="checkout-details--info">
					<div>
						<span><?php echo bkntc__('Total')?></span>
						<span><?php echo Helper::price( $parameters['info']->getTotalAmount() )?></span>
					</div>
					<div class="checkout-details--info-paid">
						<span><?php echo bkntc__('Paid')?></span>
						<span><?php echo Helper::price( $parameters['info']->getRealPaidAmount() )?></span>
					</div>
					<div class="checkout-details--info-due">
						<span><?php echo bkntc__('Due')?></span>
						<span><?php echo Helper::price( $parameters['info']->getDueAmount() )?></span>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<div class="fs-modal-footer">
	<?php
		if( $parameters['info']->getDueAmount() > 0 )
		{
			?>
			<button type="button" class="btn btn-lg btn-success complete-payment"><?php echo bkntc__('COMPLETE PAYMENT')?></button>
			<?php
		}
	?>

	<button type="button" class="btn btn-lg btn-primary edit-btn" data-load-modal="payments.edit_payment" data-parameter-payment="<?php echo (int)$parameters['info']->getId()?>" data-parameter-mn2="<?php echo $_mn?>"><?php echo bkntc__('EDIT')?></button>
	<button type="button" class="btn btn-lg btn-default" data-dismiss="modal"><?php echo bkntc__('CANCEL')?></button>
</div>
