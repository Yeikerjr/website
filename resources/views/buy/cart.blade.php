@extends('layouts.app')

@section('page-title', "Cart")

@section('custom_js_head')

<script src="https://js.stripe.com/v3/"></script>

@endsection('custom_js_head')

@section('custom_css')

<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<link rel="stylesheet" href="{{ asset('css/buy.css') }}">

<link rel="stylesheet" href="{{ asset('css/cart2.css') }}">

@endsection('custom_css')

@section('content')

<div class="container-fluid noP" style="margin-top: 4rem;">

	<div class="section section-grey section-border-bottom" style="padding: 20px 0; margin-bottom: 2rem;">
		<div class="container">
			<div class="col-md-12 noP row">
				<div class="col-md-12 noP">
					<h1 class="heading2">Cart</h1>
				</div>
			</div>
		</div>
	</div>

	<div class="section section-border-bottom">
		<div class="container">
			<div class="row">
				<div class="col-md-12 noP">
					<div class="steps-sec">
						<ul class="step-menu">
							<li id="step-1" class="activeP">
								<span class="no">Step 1</span>
								<p>Review Cart & Provide Details</p>
							</li>
							<li id="step-2">
								<span class="no">Step 2</span>
								<p>Select payment method & confirm order</p>
							</li>
							<li id="step-3">
								<span class="no">Step 3</span>
								<p>Order complete!</p>
							</li>

						</ul>
					</div>
				</div>
			
				<div class="col-md-12 row cart-step" id="cartsec-2" style="display: none;">
					<div id="loginSec" class="col-md-12 row" style="display: none;">
					<div class="col-md-5" style="padding:0px 50px 100px 10px;">
					<div class="main-heading text-center">
					 <strong>Sign In</strong>
					</div>
					<div class="form">
					<div class="form-row">
					<label>Email</label>
					<input type="text" name="email" id="loginEmail" placeholder="info@yourcompany.com" class="form-control">
					</div>
					<div class="form-row">
					<label>Password</label>
					<input type="password" name="pass" id="loginPass" placeholder="password" class="form-control">
					</div>
					<div class="text-center">
					<input type="submit" name="login" id="loginBtn" value="Sign In" class="btn btn-primary">
					</div>
					</div>
					</div>
					<div class="col-md-7" style="border-left:1px solid #ccc; padding:0px 45px;">
					<div class="main-heading text-center">
					<strong>Create New Account</strong>
					</div>
					<div class="form">
					<div class="form-row">
					<div class="col-md-6" style="padding-left:0px;">
					<label>First Name</label>
					<input type="text" name="f_name" id="regFName" placeholder="First Name" class="form-control" required="">
					</div>
					<div class="col-md-6">
					<label>Last Name</label>
					<input type="text" name="l_name" id="regLName" placeholder="Last Name" class="form-control" required="">
					</div>
					</div>
					<div class="form-row">
					<label>Email</label>
					<input type="text" name="email" id="regEmail" placeholder="info@yourcompany.com" class="form-control" required="">
					</div>
					<div class="form-row">
					<label>Password</label>
					<input type="password" name="pass" id="regPass" placeholder="password" class="form-control" required="">
					</div>
					<div class="form-row">
					<label class="text-capitalize pointer">
					By registering, you agree to the <a href="#">Privacy Policy</a> &amp; <a href="#">Terms of services</a>.
					</label>
					</div>
					<div class="text-center">
					<input type="submit" name="register" id="regBtn" value="Register Now" class="btn btn-primary">
					</div>
					</div>
					</div>
					</div>
					<div id="paymentSec" class="col-md-12 noP row">
					<div class="col-md-7 noP" style="padding-right:80px;">

					<form id="form-payment" action="{{ route('payWithPayPal') }}" method="post">
						
						@php $paypalFee = ( 5.4 * $precioTotal ) / 100 + 0.30 @endphp
						@php $stripeFee = ( 2.9 * $precioTotal ) / 100 + 0.30 @endphp
						@php $paypalTotal = $precioTotal + $paypalFee; @endphp
						@php $stripeTotal = $precioTotal + $stripeFee; @endphp

					<table class="table table-bordered cart-table">
					<tbody><tr>
					<th>
					Select Payment Method
					</th>
					</tr>
					<tr id="payOpAccount">
					<td>
					<label class="payment-option">
					<input type="radio" value="account" name="method" id="accountBalanceCheck" disabled="disabled" style="display: none;"> Account Balance - <span class="text-success">$0</span>
					</label>
					<span id="showAddMsg" class="text-muted"></span>
					</td>
					</tr>
					<tr id="payOpPaypal">
					<td>
					<label class="payment-option">
					<input type="radio" value="paypal" name="method" id="radioPayPal" checked> <img height="30" src="{{ asset('img/paypal2.png') }}">
					</label>
					</td>
					</tr>
					<tr id="payOpPayoneer">
					<td>
					<label class="payment-option">
					<input type="radio" value="stripe" class="add_money_using_payoneer" name="method" id="radioStripe"> <a hrer="javascript:void(0)" class="add_money_using_payoneer"><img height="40" src="{{ asset('img/stripe.png') }}"></a>
					</label>
					</td>
					</tr>
					</tbody></table>
					<p style="padding-top:150px;">
					<span class="btn btn-primary backtoOne" style="color: #FFF;">« Back To Step 1</span>
					</p>
					</div>
					<div class="col-md-5 noP">
					<table class="table table-bordered cart-table">
					<tbody><tr>
					<th colspan="2">
					Order Summery
					</th>
					</tr>
					<tr>
					<td width="70%">
					Guest Post - (<span class="cart-items">1</span>) websites
					</td>
					<td align="center">
					$<span class="gp_price">5</span>
					</td>
					</tr>
					<tr>
					<td>
					Indexing Service (<span class="indexed-items">0</span>)
					</td>
					<td align="center" class="indexedpPrice">
					$0 </td>
					</tr>
					<tr>
					<td>
					Content Price
					</td>
					<td align="center" class="contentTopPrice">
					$0
					</td>
					</tr>
					<tr class="bg-light">
					<td>
					<strong>Sub Total:</strong>
					</td>
					<td align="center" style="font-weight:700;" class="totalPrice">${{ $precioTotal }}</td>
					</tr>
					<tr id="pendingpay">
					<td>
					Pending to pay
					</td>
					<td align="center" class="pendingtopay">${{ $precioTotal }}</td>
					</tr>
					<tr id="paypalfeeRow">
					<td id="fee">
					Paypal Fee
					</td>
					 <td align="center" class="paymentFee" id="paymentFee">
						 ${{ $paypalFee }}
					</td>
					</tr>
					<tr id="handlingfeeRow" style="display: none;">
					<td>
					Handling Fee
					</td>
					<td align="center" class="handlingFee">
					$0
					</td>
					</tr>
					<tr class="bg-light">
					<td style="line-height:28px;">
					<strong id="changeTextBalnce">Total</strong>
					</td>
					<td align="center" class="org-color">
					<strong style="font-size:20px;" class="finalTotal">${{ $precioTotal + $paypalFee }}</strong>
					</td>
					</tr>
					</tbody></table>
						@php $total = $precioTotal + $paypalFee; @endphp
						@php $strTotal = (string)$total; $pre = str_replace('.', '', $strTotal); @endphp
						<input type="hidden" id="amount" name="amount" value="{{ $pre }}">
					
					<div class="col-md-12 noP">
					<button type="submit" class="btn btn-success cart-btn text-center" id="placeOrder">Complete My Order</button><br>
				</form>

				
					<p>By placing order you agree with <a href="{{ route('privacy') }}" target="_blank" style="color: #0068a3;">privacy policy</a> &amp; <a href="{{ route('refound-policy') }}" target="_blank" style="color: #0068a3;">refund policy</a></p>
					</div>
					</div>
					</div>
					</div>


				<div class=" row cart-step cartsec" style="display: flex;">
				
					<div class="col-md-9 ">

						@foreach($websites as $website)
						
						<div class="col-md-12 " style="padding: 10px; background: #ECF1F3; margin-bottom: 6rem;">
							<div class="col-md-12  cart-contents">
								<div class="col-md-12  text-right" style="padding: 0px 5px 5px 5px; font-size: 14px;">
									<span class="pull-left">
										Item
										<strong class="item_no">{{ sizeof($websites) }}</strong>
									</span>
									<span class="remCart text-danger" style="font-size: 14px; font-weight: 400; cursor: pointer; color: #dc3545">Remove</span>
								</div>
								<table class="table cart-table cart-head">
									<tbody>
										
										<tr>
											<td width="60%">
												<div class="col-md-12  row">
													<span class="col-md-12  cart-page" style="position: relative;">
														<a href="#" class="item-title">{{ $website->name }}</a>
													</span>
													<span class="site-tagline">
														<strong>{{ $website->domain_authority }}</strong>
														Domain Authority / 
														<strong>{{ $website->page_authority }}</strong>
														Page Authority
													</span>
													<span style="position: absolute; top: 5px; right: 0px">
														<input type="checkbox" name="check" id="check" class="make_indexed">
														<label for="check" style="color: #F44336">Make google Indexed</label>
													</span>
												</div>
											</td>
											<td width="40%">
												<div class="col-md-12  row text-right">
													<div class="col metric">
														<span class="value">US ${{ $website->price }}</span>
														<span class="name">Guest post price</span>
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-12  cart-table-contents">
								<table class="table table-bordered cart-table">
									<tr>
										<td>
											<ul class="categories-select categories-select-sm row">
												<li>
													<span id="post1" class="name post-content hc active">
														<i class="fa fa-check"></i>
														Provide Post Content
														<em>(300 Words Atleast)</em>
													</span>
												</li>
												<li>
													<span id="post2" class="name post-content hc">
														<i class="fa fa-check"></i>
														Let the Author Write Post Content
														($10)
													</span>
												</li>
												<li>
													<span id="post3" class="name post-content hc">
														<i class="fa fa-check"></i>
														Let our Experts write post content
														for you
														($10)
													</span>
												</li>
											</ul>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-row cstatus">
												<div class="col-md-12">
													<div class="mce-tinymce mce-container mce-panel">
														<div class="mce-container-body mce-stack-layout">
															<div class="mce-top-part mce-container mce-stack-layout-item mce-first">
																<div class="mce-container-body">
																	<div class="mce-container mce-menubar mce-toolbar mce-first">
																	</div>
																	<div class="mce-edit-area mce-container mce-panel mce-stack-layout-item mce-last">
																		<textarea name="message" id="message" style="width: 100%; height: 350px; display: block;"></textarea>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>
						@endforeach
					</div>
					<div class="col-md-3" style="padding-left: 10px; position: relative;">
						<div class="scrollBox">
							<div class="checkoutBox">
								<span class="btn-span-checkout cart-btn" id="btnGoCheckout">
									Go to checkout
								</span>
								<table class="table checkTable">
									<tbody>
										<tr>
											<td width="60%">
												Websites (
												<span class="cart-items">{{ sizeof($websites) }}</span>
												)
											</td>
											<td class="text-right">
												$
												<span class="gp_price">
													{{ $precioTotal }}
												</span>
											</td>
										</tr>
										<tr>
											<td width="60%">
												Indexing Service (
												<span class="indexed-items">0</span>
												)
											</td>
											<td class="text-right">
												$
												<span class="indexed_price">0</span>
											</td>
										</tr>
										<tr>
											<td>Post content</td>
											<td class="text-right contentTopPrice">
												$0
											</td>
										</tr>
										<tr style="font-size: 18px;">
											<td>Total</td>
											<td class="text-right">
												$
												<span id="totalPrice">{{ $precioTotal }}</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<span class="text-danger">
								<br>
								<strong style="color: #dc3545">NOTE:</strong>
								No adult, Sexual, Gambling, Casino or any type of illegal links.
							</span>
							Need Help?
							<a href="{{ route('contact.index') }}">Contact us</a>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

@endsection('content')

@section('custom_js')

<script>
	const $post1 = document.getElementById('post1'),
			$post2 = document.getElementById('post2'),
			$post3 = document.getElementById('post3');

	const $step1 = document.getElementById('step-1'),
			$step2 = document.getElementById('step-2'),
			$step3 = document.getElementById('step-3');

	let $totalPrice = document.getElementById('totalPrice'),
		$message = document.getElementById('message');

	const $backtoOne = document.querySelector('.backtoOne');
	
	let precio = {{ (integer)$precioTotal + 10 }}

	const $cartsec = document.querySelectorAll('.cartsec')
	const $cartsec2 = document.getElementById('cartsec-2')

	const $cartBtn = document.getElementById('btnGoCheckout');

	let $finalTotal = document.querySelector('.finalTotal');
	//const $formPayPal = document.getElementById('form-PayPal');

	const $radioStripe = document.getElementById('radioStripe');
	const $radioPayPal = document.getElementById('radioPayPal');

	let $amount = document.getElementById('amount');
	//${{ $paypalFee }}
	let $fee = document.getElementById('fee');
	let $paymentFee = document.getElementById('paymentFee');

	let $formPayment = document.getElementById('form-payment');

	$radioStripe.addEventListener('click', () => {
		$formPayment.removeAttribute('action')
		$formPayment.setAttribute('action', `{{ route('payWithStripe') }}`)

		$fee.textContent = 'Stripe Fee';
		$paymentFee.textContent = '$' + {{ $stripeFee }}

		$finalTotal.textContent = '$' + {{ $precioTotal + $stripeFee }}
		let total = {{ $precioTotal + $stripeFee }}
		let strTotal = total.toString();
		let pre = strTotal.replace('.', '')
		$amount.value = pre;
		console.log('stripe')
	})

	$radioPayPal.addEventListener('click', () => {
		$formPayment.removeAttribute('action')
		$formPayment.setAttribute('action', `{{ route('payWithPayPal') }}`)

		$fee.textContent = 'PayPal Fee';
		$paymentFee.textContent = '$' + {{ $paypalFee }}

		$finalTotal.textContent = '$' + {{ $precioTotal + $paypalFee }}
		let total = {{ $precioTotal + $paypalFee }}
		let strTotal = total.toString();
		let pre = strTotal.replace('.', '')
		$amount.value = pre;
		console.log('paypal')
	})

	$post1.addEventListener('click', () => {
		$post1.classList.add('active');
		$post2.classList.remove('active');
		$post3.classList.remove('active');
		$totalPrice.textContent = {{ $precioTotal }};
		$message.style.display = 'block';
	});

	$post2.addEventListener('click', () => {
		$post2.classList.add('active');
		$post1.classList.remove('active');
		$post3.classList.remove('active');

		if (parseInt($totalPrice.textContent) > precio) {
			$totalPrice.textContent = $totalPrice.textContent;
		} else {
			$totalPrice.textContent = {{ (integer)$precioTotal + 10 }}
		}

		$message.style.display = 'none';

	});

	$post3.addEventListener('click', () => {
		$post3.classList.add('active');
		$post1.classList.remove('active');
		$post2.classList.remove('active');
		if (parseInt($totalPrice.textContent) > precio) {

			$totalPrice.textContent = $totalPrice.textContent;

			//$totalPrice.textContent = $totalPrice.textContent;
		} else {
			$totalPrice.textContent = {{ (integer)$precioTotal + 10 }}	
		}
		
		$message.style.display = 'none';
	});

	$cartBtn.addEventListener('click', () => {
		$cartsec.forEach(el => {
			el.style.display = 'none';
		});

		$cartsec2.style.display = 'flex';
		$step1.classList.remove('activeP');
		$step2.classList.add('activeP');
	});

	$backtoOne.addEventListener('click', () => {
		$cartsec2.style.display = 'none';

		$cartsec.forEach(el => {
			el.style.display = 'flex';
		});
		$step1.classList.add('activeP');
		$step2.classList.remove('activeP');
	});
	
</script>

<script src="{{ asset('js/stripe.js') }}"></script>

@endsection('custom_js')