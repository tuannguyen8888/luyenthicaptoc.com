@extends('admin.layout.index')
@section('body')

		<div class="container-fluid tintuc">
			<div class="container">
				<div class="row">
					<div class="col-md-12 tieudetintuc">
				
						<h3> LIÊN HỆ VỚI CHÚNG TÔI</h3>
					</div>
				</div>

				<div class="contact-us">
					<div class="container">
						<div class="contact-form">
							<div class="row">
								<div class="col-sm-7">
									<form id="ajax-contact"  method="post" action="contact-form-mail.php" role="form">
										<div class="messages" id="form-messages"></div>
										<div class="controls">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="form_name">Họ tên *</label>
														<input id="form_name" type="text" name="name" class="form-control" placeholder="Nhập họ tên của bạn" required="required" data-error="Firstname is required.">
														<div class="help-block with-errors"></div>
													</div>
												</div>
												<div class="col-md-6">

												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="form_email">Email *</label>
														<input id="form_email" type="email" name="email" class="form-control" placeholder="Nhập email của bạn" required="required" data-error="Valid email is required.">
														<div class="help-block with-errors"></div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="form_phone">Số điện thoại*</label>
														<input id="form_phone" type="tel" name="phone"  class="form-control" placeholder="Nhập số điện thoại của bạn" required oninvalid="setCustomValidity('Plz enter your correct phone number ')"
															   onchange="try{setCustomValidity('')}catch(e){}">

													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label for="form_message">Nội dung *</label>
														<textarea id="form_message" name="message" class="form-control" placeholder="Nhập nội dung bạn muốn liên hệ với chúng tôi" rows="4" required="required" data-error="Please,leave us a message."></textarea>
														<div class="help-block with-errors"></div>
													</div>
												</div>
												<div class="col-md-12 pull-right">
													<input type="submit" class="btn btn-success pull-right" value="Gửi liên hệ">
												</div>
											</div>
										</div>

									</form>

								</div>
								<div class="col-sm-5">
									<div class="row col1">
										<div class="col-xs-3">
											<i class="glyphicon glyphicon-map-marker" style="font-size:16px;"></i>   Địa chỉ:
										</div>
										<div class="col-xs-9">
											{{CRUDBooster::getSetting('bottom_address')}}
										</div>
									</div>

									<div class="row col1">
										<div class="col-sm-3">
											<i class="glyphicon glyphicon-earphone"></i>   Điện thoại:
										</div>
										<div class="col-sm-9">
											{{CRUDBooster::getSetting('bottom_phone')}}
										</div>
									</div>
									<div class="row col1">
										<div class="col-sm-3">
											<i class="glyphicon glyphicon-phone-alt"></i>    Hotline:
										</div>
										<div class="col-sm-9">
											{{CRUDBooster::getSetting('bottom_hotline')}}
										</div>
									</div>
									<div class="row col1">
										<div class="col-sm-3">
											<i class="glyphicon glyphicon-envelope"></i>   Email:
										</div>
										<div class="col-sm-9">
											<a href="mailto:{{CRUDBooster::getSetting('bottom_email')}}">{{CRUDBooster::getSetting('bottom_email')}}</a>
										</div>
									</div><br>
									<div style="width: 100%"><iframe width="100%" height="250px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=h%E1%BB%93%20ch%C3%AD%20minh+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></div>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</div>
		


@stop