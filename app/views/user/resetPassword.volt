<section class="mt-5 mx-auto col-md-5">

    <div class="card card-signup border-0 rounded">


        <div class="card-header">
            <div class="fs-5 m-2">
                🔐 Reset Password
            </div>

        </div>

        <div class="card-body">

        
            <form id="resetForm" onsubmit="return false">

                <div class="form-floating mb-3">
                
                    <input id="email" type="email" name="email" class="form-control rounded-3"  placeholder="Email" aria-labelledby="email-label" required autofocus >
                    <label for="email2">Your Email</label>

        
                </div>


                <div class="row g-3 align-items-center my-1" >

                    <div class="col-lg-8">
                     

                        <div class="input-group" >

                            <div class="form-floating">
                   

                            <input type="text" id="captcha" name="captcha" class="form-control rounded-3" placeholder="captcha"  required >
                            <label for="captcha" >Captcha</label>
                                
                            </div>


                            <span class="input-group-text" style="zoom:.9">
                                <img id="captcha-img" class="rounded c-pointer w-75 m-auto" 
                                loading="lazy" src="/captcha-image?{{time()}}" 
                                onClick="this.src='/captcha-image?' +  Math.random() " />
                            </span>
                            
                        </div>
                    </div>
                </div>


                
                <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}"/>

                <div class="d-grid gap-2 col-6 mx-auto my-4">
                    <button type="button" id="btn-reset" class="btn btn-success" onclick="resetPassword()" >
                        <span id="loading" class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                        Reset</button>
                    
                </div>

            </form>

        </div>

    </div>

    <script>
        function resetPassword() {
            var resetBody = { 
                email:$('#email').val(), 
                captcha: $('#captcha').val()
            }


            if(J$('#resetForm').reportValidity()) {
                
                $('#loading').removeClass('d-none')
                $("#btn-reset").attr("disabled", true);

                fetch('/user/reset-password' , {
                    method: 'POST',
                    headers: {'Content-type': 'application/x-www-form-urlencoded'},
                    body: JSON.stringify(resetBody)

                }).then(function (response) {
                    if (response.ok) {
                    return response.json();
                    }
                    return Promise.reject(response);
                }).then(function (res) {

                    showToast(res.status, res.message)

                    $('#captcha-img').src = '/captcha-image?' + Math.random()
                    $('#loading').addClass('d-none')

                    if (res.status == 'success') {
                        $('.card-body').html('✉️ We have sent you a link to reset your password. Check your inbox!')
                    }

                    if (res.status == 'error') {
                        $("#btn-reset").attr("disabled", false);
                    }

                
                }).catch(function (error) {
                    showToast(error.status, error.statusText)
                });
            }
        }  if (res.status == 'success') {
                        showToast(res.status, res.message)
                    }
    </script>

  </section>