{% if matchInfo["place"] is defined %}
<div class="card-footer border-0 text-muted small-lg opacity-8">
    <div class="d-flex justify-content-between flex-wrap text-select">
        <div class="">
            {% if matchInfo["place"][9] is defined %}
            <span class="meteo">
                {{matchInfo["place"][9]}}
            </span>
            {% endif %}

            {% if matchInfo["place"][21] is defined %} 
            <span class="meteo">

                {% if matchInfo["place"][20] in [4,5,8,9,12,13]   %}
                    {% set  meteo = 'rain' %}
            
                {% elseif  matchInfo["place"][20] in [3,11,7,1,2]   %}
                    {% set  meteo = 'cloud' %}
                
                {% elseif  matchInfo["place"][20] in [15]   %}
                    {% set  meteo = 'sun' %}

                {% else  %}
                    {% set  meteo = 'cloud' %}
                {% endif %}

                <span class="icon-{{meteo}}"></span> {{matchInfo["place"][21]}} 
            
            </span>
            {% endif %}


            {% if matchInfo["place"][23] is defined %}
            <span class="meteo">
                <span class="icon-wind"></span> {{matchInfo["place"][23]}} m/s
            </span>
            {% endif %}

            {% if matchInfo["place"][25] is defined %}
            <span class="meteo  d-none d-md-inline">
                <span class="icon-thermometer"></span> {{matchInfo["place"][25]}} mmHg
            </span>
            {% endif %}

        {% if matchInfo["place"][27] is defined %}
            <span class="meteo d-none d-md-inline">  
                <span class="icon-droplet"></span> {{matchInfo["place"][27]}} % 
            </span>
        {% endif %}
        </div>

        {% if matchInfo["place"][2] is defined %}
        <div class="d-none d-md-inline">
            <span class="icon-stadium"></span> {{matchInfo["place"][2]}} 
        </div>
        {% endif %}

    </div>
   
</div>
{% endif %}