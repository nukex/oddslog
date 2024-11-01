<div class="" id="liveMatches">

    

    
     <div class="d-flex justify-content-between flex-wrap flex-md-row flex-column">
                <div class="text-center">
                    <a href="/" class="btn bg-900">{{total['Matchs']}} All </a>
                    <a href="/live" class="btn bg-900  ml-2"><b>{{total['Live']}}</b> Live  

                    <span class="blink"> <svg id="countdown" height="22" width="22"> <circle cx="12" cy="12" r="7" stroke="#dc3545" stroke-width="3" fill="#2a2838"></circle></svg></span></a>
                </div>

             

                {# <div class="view-date order-0  mt-3 mt-md-0 text-center">
                    <?php if (strtotime($date['select'])>=1627851600):?>
                            <a href="/date/<?php echo date('Y-m-d',(strtotime($date['select'])-3600*24))?>" class="date__change date__change--back btn bg-900"></a>
                        <?php endif?>
                   <span class="btn bg-900">{{date['view']}}</span> 

                    <?php if ($date['select']!=date('Y-m-d')):?>
                        <a href="/date/<?php echo date('Y-m-d',(strtotime($date['select'])+3600*24))?>" class="date__change date__change--next btn  bg-900   "></a>
                     <?php endif?>
                </div> #}

            </div>

    <div class="card my-4  rounded " data-bs-theme="dark">

    {% for rating, listMatches in matchs.matchs %}
        {% for tournament, group in listMatches %}
        <?php  $tournament = explode('|',$tournament ) ?>
            <div class="card-header d-flex justify-content-start">
                <span class="flags flags-category flags--sm flags--{{tournament[0]}}"></span>
                <div class="league">{{tournament[1]}}</div> 
            </div>

                {% for match in group %}
                
                <a href="/football{{ url(match['url']) }}" class="match__event">
                    <span class="matchStart text-muted d-none d-md-block">{{ match['beginTime'] }}</span>
                    <span class="match__TeamName teamHome">{{ match['team1'] }}</span>
                    
                    {% if match['rating'] >=1 %}
						<img src="https://cdn.1xstavka.ru/genfiles/logo_teams/{{match['info']['team1ID']}}.png" alt="{{ match['team1'] }} logo" onerror="this.src='https://tse2.mm.bing.net/th?q={{ match['team1'] }}%20FC%20logo&w=40&h=40'" loading="lazy" style="height:25px;width: 25px;">
					{% else  %}
						<img class="Image TeamIcon " loading="lazy" alt="{{ match['team1'] }} logo" width="25" height="25" src="https://tse2.mm.bing.net/th?q={{ match['team1'] }}%20FC%20logo&w=40&h=40">
					{% endif %}
                

                    <div class="match__status">
                        <span class="score">{{ match['scoreHome'] }} - {{ match['scoreAway'] }}</span>
                        <span class="status text-{{ match['matchStatus']['alert'] }}">{{ match['matchStatus']['text'] }}</span>
                    </div>

                    {% if match['rating'] >=1 %}
						<img src="https://cdn.1xstavka.ru/genfiles/logo_teams/{{match['info']['team2ID']}}.png" alt="{{ match['team2'] }} logo" loading="lazy" onerror="this.src='https://tse2.mm.bing.net/th?q={{ match['team2'] }}%20FC%20logo&w=40&h=40'" style="height:25px;width: 25px;">
					{% else  %}
						<img class="Image TeamIcon " alt="{{ match['team2'] }} logo" loading="lazy" width="25" height="25" src="https://tse2.mm.bing.net/th?q={{ match['team2'] }}%20FC%20logo&w=40&h=40">  
					{% endif %}

                    <span class="match__TeamName teamAway">{{ match['team2'] }}</span>
                  
              
                        <div class="d-none d-md-block odds">
                        
                            <div class="progress border" style="height: 21px; opacity: .8">

                                {% if !(match['firstW1'] is empty)  %}
                                <div title="{{ match['firstW1'] }}" class="progress-bar bg-primary" role="progressbar" style="width: {{ (1/match['firstW1']*100) }}%">{{ match['firstW1'] }}</div>
                                {% endif %}
    
                                <div class="progress-bar " role="progressbar" style="width: 1%;"></div>
                                
                                {% if !(match['firstX'] is empty)  %}
                                <div title="{{ match['firstX'] }}" class=" progress-bar bg-warning " role="progressbar" style="width: {{ (1/match['firstX']*100) }}%">{{ match['firstX'] }}</div>
                                {% endif %}
    
                                <div class="progress-bar " role="progressbar" style="width: 1%;"></div>
    
                                {% if !(match['firstW2'] is empty)  %}
                                <div title="{{ match['firstW2'] }}" class="progress-bar bg-success " role="progressbar" style="width: {{ (1/match['firstW2']*100) }}%">{{ match['firstW2'] }}</div>
                                {% endif %}
                            </div>
                        
                        </div>
                

                    {% if !(match['stats'] is empty) AND (match['stats'] !='null') %}
                            <div class="d-none d-md-block stats"  data-stat='{{ match['stats']}}'> 
                                    <span class="icon-chart"></span> 
                            </div>
                     {% else  %} <span class="icon-chart" style="opacity: 0.1"></span> 
                    {% endif %} 
                    


                </a>
                {% endfor %}
        {% endfor %}
    {% endfor %}
    </div>
</div>

