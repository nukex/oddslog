<div class="card my-3   rounded " >
    <div class="card-header">In-Play odds</div>
    <div class="card__body table-responsive">

        <table class="table table__inplay table-hover"  data-bs-theme="dark">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Time</th>
                    <th scope="col">Score</th>

                    <th scope="col" data-bs-toggle="tooltip" title="Win Home">1</th>
                    <th scope="col" data-bs-toggle="tooltip" title="Draw">X</th>
                    <th scope="col" data-bs-toggle="tooltip" title="Win Away">2</th>

                    <th scope="col" data-bs-toggle="tooltip" title="Home Team To Win or Draw">1X</th>
                    <th scope="col" data-bs-toggle="tooltip" title="Home Team To Win or Away Team To Win">12</th>
                    <th scope="col" data-bs-toggle="tooltip" title="Away Team To Win or Draw">X2</th>

                    <th scope="col">HCap1</th>
                    <th scope="col">HC1</th>
                    <th scope="col">HCap2</th>
                    <th scope="col">HC2</th>

                    <th scope="col" data-bs-toggle="tooltip" title="Total Goals">Total</th>
                    <th scope="col" data-bs-toggle="tooltip" title="Total Over">O</th>
                    <th scope="col" data-bs-toggle="tooltip" title="Total Under">U</th>
                    {% if !(stats is empty) %}
                    <th scope="col"></th>
                    {% endif %}
                </tr>
            </thead>

            <tbody class="overflow-auto text-select">
                {% set parentScore = 0 %} 
                {% set parentmatchTime = '' %} 
                {% for key,vodd in odds%} 
                    {% if parentmatchTime != vodd.matchTime %} 
                        {% set scored = vodd.scoreHome + vodd.scoreAway %}
                <tr class="{% if scored !==parentScore %}border-goal{% endif %}">

                    <th scope="row" {% if scored !==parentScore %} class="bg-success" {% endif %}>{{ vodd.matchTime }}'</th>


                    <td {% if scored !==parentScore %} class="text-success fw-bold" {% endif %}>{{ vodd.scoreHome }}-{{ vodd.scoreAway }}</td>
                    <td>{{ vodd.w1 }}</td>
                    <td>{{ vodd.x }}</td>
                    <td>{{ vodd.w2 }}</td>
                    <td>{{ vodd.odd1X }}</td>
                    <td>{{ vodd.odd12 }}</td>
                    <td>{{ vodd.oddX2 }}</td>
                    <td>
                        {% if vodd.hcap1 is defined %} 
                            {% if vodd.hcap1 >0 %}+ {% endif %} 
                            {{ vodd.hcap1 }} 
                        {% endif %}
                    </td>

                    <td>{{ vodd.hcap1Odd }}</td>
                    
                    <td>
                        {% if vodd.hcap2Odd is defined %}{% if vodd.hcap2 >0 %}+ {% endif %} 
                            {{ vodd.hcap2 }}
                        {% endif %}
                    </td>

                    <td>{% if vodd.hcap2Odd is defined %}
                            {{ vodd.hcap2Odd }}
                        {% endif %}
                    </td>

                    <td>{{ vodd.total }}</td>
                    <td>{{ vodd.overTotal }}</td>
                    <td>{{ vodd.underTotal }}</td>

                    {% if !(stats is empty) AND (stats is defined) %}
                    <td>
                        <div class="stats" title=" " data-stat='{{stats[vodd.matchTime]|json_encode}}'>
                            <span class="icon-chart"></span>
                        </div>
                    </td>
                    {% endif %}

                </tr>
                {% set parentmatchTime = vodd.matchTime %} {% set parentScore = scored %} {% endif %} {% endfor %}
            </tbody>
        </table>


    </div>


</div>