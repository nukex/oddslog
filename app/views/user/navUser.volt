{% if User is defined %} 



        <div class="dropdown">
         
            <button class="btn bg-900 dropdown-toggle font-weight-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                 {{User.username}} 
            </button>

            <ul class="dropdown-menu shadow">

                {% if (User.status == 0) %}
                <li><a class="dropdown-item disabled text-warning" href="">Not activated</a></li>
                <li><hr class="dropdown-divider"></li>
                {% endif %}
              

               
                
                {% if (isAdmin) %}
                    <li><a class="dropdown-item" href="/a/">🪄 Admin</a></li>
                {% endif %}

                <li><a class="dropdown-item" href="/user/dashboard">Dashboard</a></li>
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
            
            </ul>
        </div> 
    
        
        {% else %} 

        <button id="signin" class="btn bg-900 fw-semibold">
            <span class="align-top">Login</span>
        </button>

   

{% endif %} 