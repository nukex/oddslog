<section class="mt-5 mx-auto col-md-5">

    {% if keyValid %}
    
            {% if alert is defined %}
            <div class="mb-3 rounded-lg border border-2 border-{{alert.color}} text-{{alert.color}} px-3 py-3" role="alert">
                <p class="font-bold">{{alert.status|capitalize}}</p>
                <p class="text-lg">{{alert.text}}</p>
    
        
            </div>
            {% endif %}
    
    
    
            <div class="card card-signup border-0 rounded">
        
        
                <div class="card-header">
                    <div class="fs-5 m-2">
                        🔑 Change Password
                    </div>
        
                </div>
        
                <div class="card-body">
        
                
        
        
                    <form id="changeForm" method="POST" onsubmit="return false;">
        
                        <div class="form-floating mb-3">
                        
                            <input id="password" type="password" name="password" class="form-control rounded-3"  placeholder="password"  required autofocus >
                            <label for="password">New password</label>
        
                    
                        </div>
    
                        <div class="form-floating mb-3">
                        
                            <input id="confirm-password" type="password" name="confirm-password" class="form-control rounded-3"  placeholder="confirm-password"  required autofocus >
                            <label for="confirm-password">Confirm password</label>
        
                    
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
                            <button type="button" class="btn btn-success" onclick="changePassword()" >
                                
                                Change password</button>
                            
                        </div>
        
           
                        
        
                    </form>
                </div>
        
            </div>
        
            <script>
               function changePassword() {
                if(J$('#changeForm').reportValidity()) {
                                
                                if(J$('#password').value != J$('#confirm-password').value) {
                                
                                        showToast('error', "Confirming Password <p>Passwords do not match")
                                        return false;
                                }
    
                                if(J$('#password').value.length < 6) {
                                    showToast('error', "Password length <p>Your password must be at least 6 characters")
                                      
                                        return false;
                                }
    
                                J$('#changeForm').submit()
 
                            }
               }
            </script>
    
    
            {% else %}
    
            <!-- Error -->
    
            <div class="mb-3 rounded-lg border border-2 border-danger text-danger px-3 py-3" role="alert">
                <p class="font-bold">Error</p>
                
                <p class="text-lg my-3">The link has expired or is invalid.</p>
    
                <p><a class="btn btn-success" href="/user/reset-password">Reset password</a> </p>
            </div>
    
            {% endif %}
    
        
        </section>
    
    
    