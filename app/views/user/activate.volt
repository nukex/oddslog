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
                        🟢 Account Activation
                    </div>
        
                </div>
        
                <div class="card-body">
        
                
                    Your account has been activated!

          
                    <div class="my-4">
                        
                        <a class="btn btn-success" href="/">Home</a> 
                        <a class="btn bg-primary" href="/user/dashboard">Dashboard</a>

                    </div>

             
        
                </div>
        
            </div>
        
    
            {% else %}
    
            <!-- Error -->
    
            <div class="mb-3 rounded-lg border border-2 border-danger text-danger px-3 py-3" role="alert">
                <p class="font-bold">Error</p>
                
                <p class="text-lg my-3">The link has expired or is invalid.</p>
    
                <p><a class="btn btn-success" href="/">Home</a> </p>
            </div>
    
            {% endif %}
    
        
        </section>
    
    
    