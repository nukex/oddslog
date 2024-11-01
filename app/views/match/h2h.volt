{% set matchesH2H = h2h.data|json_decode %}

{% set winHomeTeam    = h2hWinCalc(match.team1, matchesH2H.home) %}
{% set ppgHomeTeam    = h2hPPGCalc(match.team1, matchesH2H.home) %}
{% set scoredHomeTeam = h2hScored(match.team1, matchesH2H.home) %}
{% set bttsHomeTeam   = h2hBTTS(match.team1, matchesH2H.home) %}




<div class="row">

    <!-- home team -->
    <div class="col-md-6 col-12">


        <div class="card my-3  rounded ">
    
            <div class="card-header ">
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="d-md-inline text-truncate">
                        <div class="league">{{match.team1}} - Last matches</div>   
                    </div>
                    <div class="d-md-inline text-truncate">
                        <div data-bs-toggle="tooltip" title="PPG - Points Per Game" class="badge bg-{{ppgHomeTeam['status']}} fw-normal  fs-7 p-1 px-2">{{ppgHomeTeam['ppg']}}</div>   
                    </div>
                    
                </div>

            </div>

            {% for h2hHome in matchesH2H.home %}

    
               {% set status    = h2hStatus(match.team1, h2hHome.home, h2hHome.away, h2hHome.score.FT) %}

            <div class="match__event">
                <span class="matchStart text-muted"><?php echo date('d M', $h2hHome->date)?></span>
                <span class="match__TeamName teamHome">{{ h2hHome.home }}</span>


                <img src="https://tse2.mm.bing.net/th?q={{ h2hHome.home }}%20FC%20logo&w=40&h=40" loading="lazy" style="height:20px;width: 20px;">



                <div class="match__status">
                    <span class="score">{{ h2hHome.score.FT[0] }} - {{ h2hHome.score.FT[1] }}</span>

                </div>

                <img src="https://tse2.mm.bing.net/th?q={{ h2hHome.away }}%20FC%20logo&w=40&h=40" loading="lazy" style="height:20px;width: 20px;">

                <span class="match__TeamName teamAway">{{ h2hHome.away }}</span>

                <span class="badge bg-{{status['badge']}} small fw-normal ">{{status['val']}}</span>
            </div>
            {% endfor %}
        </div>


  
        <div class="card my-3  rounded ">
            <div class="card-header d-flex justify-content-start">
                <div class="league">{{match.team1}} - Form</div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-sm table-borderless text-center">
                        <thead class="small">
                        <tr>
                     
                            <th scope="col">Stats</th>
                            <th scope="col">Overall</th>
                            <th scope="col">Home</th>
                            <th scope="col">Away</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                         
                            <td>Win %</td>
                            <td><span class="badge bg-{{winHomeTeam['status']}} small fw-normal ">{{winHomeTeam['avg']}} %</span></td>
                            <td>{{winHomeTeam['home']}} %</td>
                            <td>{{winHomeTeam['away']}} %</td>
                        </tr>
                        <tr>
                         
                            <td data-bs-toggle="tooltip" title="PPG - Points Per Game. Average points picked up per match across the competition. Higher numbers indicate a stronger team.">PPG <sup>?</sup></td>
                            <td><span class="badge bg-{{ppgHomeTeam['status']}} small fw-normal ">{{ppgHomeTeam['ppg']}}</span></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                      
                            <td data-bs-toggle="tooltip" title="Average of goals scored per game.">Scored <sup>?</sup></td>
                            <td>{{scoredHomeTeam['avg']}}</td>
                            <td>{{scoredHomeTeam['avgHome']}}</td>
                            <td>{{scoredHomeTeam['avgAway']}}</td>
                        </tr>
                        <tr>
                      
                            <td data-bs-toggle="tooltip" title="Both Teams To Score">BTTS <sup>?</sup></td>
                            <td>{{bttsHomeTeam['avg']}} %</td>
                            <td>{{bttsHomeTeam['avgHome']}} %</td>
                            <td>{{bttsHomeTeam['avgAway']}} %</td>
                        </tr>
                        </tbody>

                    </table>
                    </div>
          


            </div>

        </div>

    </div>


    {% set winHomeTeam    = h2hWinCalc(match.team2, matchesH2H.away) %}
    {% set ppgHomeTeam    = h2hPPGCalc(match.team2, matchesH2H.away) %}
    {% set scoredHomeTeam = h2hScored(match.team2, matchesH2H.away) %}
    {% set bttsHomeTeam   = h2hBTTS(match.team2, matchesH2H.away) %}

    <!-- away team -->
    <div class="col-md-6 col-12">


        <div class="card my-3  rounded ">
          
             <div class="card-header ">
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="d-md-inline text-truncate">
                        <div class="league">{{match.team2}} - Last matches</div>
                    </div>
                    <div class="d-md-inline text-truncate">
                        <div data-bs-toggle="tooltip" title="PPG - Points Per Game" class="badge bg-{{ppgHomeTeam['status']}} fw-normal fs-7 p-1 px-2">{{ppgHomeTeam['ppg']}}</div>   
                    </div>
                    
                </div>

            </div>

            {% for h2hAway in matchesH2H.away %}

            {% set status  = h2hStatus(match.team2, h2hAway.home, h2hAway.away, h2hAway.score.FT) %}

            <div class="match__event">
                <span class="matchStart text-muted"><?php echo date('d M', $h2hAway->date)?></span>
                <span class="match__TeamName teamHome">{{ h2hAway.home }}</span>


                <img src="https://tse2.mm.bing.net/th?q={{ h2hAway.home }}%20FC%20logo&w=40&h=40" loading="lazy" style="height:20px;width: 20px;">



                <div class="match__status">
                    <span class="score">{{ h2hAway.score.FT[0] }} - {{ h2hAway.score.FT[1] }}</span>

                </div>

                <img src="https://tse2.mm.bing.net/th?q={{ h2hAway.away }}%20FC%20logo&w=40&h=40" loading="lazy" style="height:20px;width: 20px;">

                <span class="match__TeamName teamAway">{{ h2hAway.away }}</span>

                <span class="badge bg-{{status['badge']}} small fw-normal ">{{status['val']}}</span>
            </div>
            {% endfor %}

        </div>


        <div class="card my-3  rounded ">

            <div class="card-header ">
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="d-md-inline text-truncate">
                        <div class="league">{{match.team2}} - Form</div>   
                    </div>
               
                    
                </div>
            
            </div>


            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-sm table-borderless text-center ">
                        <thead class="small">
                        <tr>
                     
                            <th scope="col">Stats</th>
                            <th scope="col">Overall</th>
                            <th scope="col">Home</th>
                            <th scope="col">Away</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                         
                            <td>Win %</td>
                            <td><span class="badge bg-{{winHomeTeam['status']}} small fw-normal ">{{winHomeTeam['avg']}} %</span></td>
                            <td>{{winHomeTeam['home']}} %</td>
                            <td>{{winHomeTeam['away']}} %</td>
                        </tr>
                        <tr>
                         
                            <td>PPG</td>
                            <td><span class="badge bg-{{ppgHomeTeam['status']}} small fw-normal ">{{ppgHomeTeam['ppg']}}</span></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                      
                            <td>Scored</td>
                            <td>{{scoredHomeTeam['avg']}}</td>
                            <td>{{scoredHomeTeam['avgHome']}}</td>
                            <td>{{scoredHomeTeam['avgAway']}}</td>
                        </tr>
                        <tr>
                      
                            <td>BTTS</td>
                            <td>{{bttsHomeTeam['avg']}} %</td>
                            <td>{{bttsHomeTeam['avgHome']}} %</td>
                            <td>{{bttsHomeTeam['avgAway']}} %</td>
                        </tr>
                        </tbody>

                    </table>
                    </div>
            </div>

        </div>

    </div>


</div>