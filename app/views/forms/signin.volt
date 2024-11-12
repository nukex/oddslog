<div class="row justify-content-center">

	<div class="col-xl-11">

		<ul class="nav nav-pills justify-content-center border-bottom py-3" id="login-tab" role="tablist">

			<li class="nav-item me-3" role="presentation" onclick="J$('#captcha-signin').src = '/captcha-image?' + Math.random() ">
				<button class="nav-link active" id="login-signin-tab" data-bs-toggle="pill" 
				data-bs-target="#login-signin" type="button" role="tab" 
				aria-controls="login-signin" aria-selected="true" >Sign In</button>
			</li>

			<li class="nav-item me-3" role="presentation" onclick="J$('#captcha-signup').src = '/captcha-image?' + Math.random() ">
				<button class="nav-link" id="login-signup-tab" data-bs-toggle="pill" 
				data-bs-target="#login-signup" type="button" role="tab" aria-controls="login-signup" 
				aria-selected="false"  >Sign Up</button>
			</li>

		</ul>


		<div class="tab-content" id="pills-tabContent">

			<div class="tab-pane fade show active" id="login-signin" role="tabpanel" aria-labelledby="login-signin-tab" tabindex="0">


				<div class="card card-signin  border-0 rounded">

					<div class="card-body">

						<form id="form-signin" method="POST"  onsubmit="Sign('signin') ; return false">

							<div class="form-floating mb-3">
								
								<input type="text" id="email" name="email" class="form-control" placeholder="Email" required autofocus>
								<label for="inputEmail">Email</label>

							</div>

							<div class="form-floating mb-3">
								<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
								<label for="inputPassword">Password</label>
							</div>


							<div class="row g-3 align-items-center my-1 mb-3" >

                                <div class="col-lg-8">
                                 

                                    <div class="input-group" >

										<div class="form-floating">
                               

										<input type="text" id="captcha" name="captcha" class="form-control rounded-3" placeholder="captcha"  required >
										<label for="captcha" >Captcha</label>
											
										</div>


                                        <span class="input-group-text" style="zoom:.9">
                                            <img id="captcha-signin" class="rounded c-pointer w-75 m-auto"  src="/captcha-image?{{time()}}" onClick="this.src='/captcha-image?' +  Math.random() " />
                                        </span>
                                        
                                    </div>
                                </div>
                            </div>

							<small class="form-group d-md-flex">
								<div class="w-50 text-start">

									<input type="checkbox" id="remember_me" name="remember_me">
									<label for="remember_me" class="checkbox-primary mb-0">Remember Me</label>
									
								</div>

											<div class="w-50 text-end">
												<a href="/user/reset-password" class="">Forgot Password</a>
											</div>
							</small>

						
							<div class="d-grid gap-2 col-6 mx-auto mt-5">
								<button class="btn btn-success" id="btn-signin" type="button" onclick="Sign('signin')">
									<span id="loading-signin" class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
									Login</button>
							</div>

							<input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}"/>


						</form>
					</div>

				</div>

			</div>


			<div class="tab-pane fade" id="login-signup" role="tabpanel" aria-labelledby="login-signup-tab" tabindex="0">
					
				<div class="card card-signup border-0 rounded">

					<div class="card-body">

						<form id="form-signup" method="POST"  onsubmit="Sign('signup') ; return false">

							<div class="form-floating mb-3">
							
								<input type="text" id="email2" type="email" name="email" class="form-control rounded-3"  placeholder="Email" aria-labelledby="email-label" required autofocus >
								<label for="email2">Email</label>

						
							</div>


							<div class="form-floating mb-3">
							
								<input type="password" id="inputPassword2" name="password" class="form-control rounded-3" minlength="6" placeholder="Password"  aria-labelledby="passwordHelpBlock" required >
								<label for="inputPassword2" >Password</label>

								<div id="passwordHelpBlock" class="form-text fs-7">
									Must be 6-20 characters long
								</div>

							</div>

    
                            <div class="row g-3 align-items-center my-1" >

                                <div class="col-lg-8">
                                 

                                    <div class="input-group" >

										<div class="form-floating">
                               

										<input type="text" id="captcha-input-signup" name="captcha" class="form-control rounded-3" placeholder="captcha"  required >
										<label for="captcha" >Captcha</label>
											
										</div>


                                        <span class="input-group-text" style="zoom:.9">
                                            <img id="captcha-signup" class="rounded c-pointer w-75 m-auto" src="/captcha-image?{{time()}}" onClick="this.src='/captcha-image?' +  Math.random() " />
                                        </span>
                                        
                                    </div>
                                </div>
                            </div>


							
							<input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}"/>

							<div class="d-grid gap-2 col-6 mx-auto my-4">
								
								<button type="button" id="btn-signup" class="btn btn-success" onclick="Sign('signup')" >
									<span id="loading-signup" class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>	
									Join
								</button>
								
							</div>

							<div class="text-body-secondary fs-7">By clicking Join, you agree to the 
								<a href="/posts/terms" target="_blank" class="link-underline-info">Terms of use</a>.
							</div>

							

						</form>
					</div>

				</div>
			</div>


		</div>

	</div>

</div>

