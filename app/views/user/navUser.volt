{% if User is defined %} 



        <div class="dropdown">
            <button class="btn bg-900 dropdown-toggle font-weight-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span>
                    <svg viewBox="0 -8 72 72" style="width: 18px;vertical-align: sub;" xmlns="http://www.w3.org/2000/svg" >
                            <path fill="#fff" class="cls-1"
                                d="M12.54,52.05H59.46a2.11,2.11,0,0,0,1.6-.7A1.73,1.73,0,0,0,61.49,50,25.8,25.8,0,0,0,47.9,30.45a16.8,16.8,0,0,1-23.8,0A25.8,25.8,0,0,0,10.51,50a1.75,1.75,0,0,0,.43,1.38A2.11,2.11,0,0,0,12.54,52.05Z">
                            </path>
                            <path fill="#fff" class="cls-1"
                                d="M25.43,28.6c.27.29.56.56.85.82a14.52,14.52,0,0,0,19.43,0,11.1,11.1,0,0,0,.86-.82c.27-.29.54-.58.79-.89a14.6,14.6,0,1,0-22.72,0C24.89,28,25.16,28.31,25.43,28.6Z">
                            </path>
              
                    </svg>

                </span>
                <span class="d-none d-sm-inline">{{User.username}}</span> 
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

        <button data-id="signin" class="open-modal btn bg-900 fw-semibold me-2 me-md-0">
            <span class="align-top">Login</span>
        </button>

   

{% endif %} 