{% if matchStatus.text !='FT' %}
	{% if lastOdds.scoreHome > prevScore['Home'] %}
		{% set goolHome = true %}
	{% endif %}
	{% if lastOdds.scoreAway > prevScore['Away'] %}
		{% set goolAway = true %}
	{% endif %}
{% endif %}


<article class="" id="match" data-goal="{% if (goolHome is defined) OR (goolAway is defined) %}1{% else %}0{% endif %}">

	<div class="row">

		<div class="col">
			<div class="card my-3  rounded" data-bs-theme="dark">
				<div class="card-header">
					<div class="d-flex flex-wrap justify-content-between">
						<div class="d-md-inline text-truncate">
							<span class="flags flags-category flags--sm flags--{{countryFlag}}"></span>
							<h2 class="d-inline text-select">
								{{match.tournament|trim}}
								{% if matchInfo["place"][1] is defined %}
									-
									{{matchInfo["place"][1]}}
								{% endif %}
							</h2>
						</div>
						<div class="d-md-inline d-none d-md-inline ">
							<span class="view-date text-end text-select text-wrap ">{{date['timestart']}}
								UTC</span>
						</div>
					</div>
				</div>


				<div class="card-body match-info py-4 py-md-5  px-2 ">
					<div class="row justify-content-md-center">
						<div class="col-md-5 col-4 text-center team-home">

							{% if match.rating >=1 %}
								<img src="https://cdn.1xstavka.ru/genfiles/logo_teams/{{matchInfo['team1ID']}}.png" alt="{{match.team1}} logo" onerror="this.src='https://tse2.mm.bing.net/th?q={{match.team1}}%20FC%20logo&w=60&h=60'" style="height:60px">
							{% else  %}
								<img src="https://tse2.mm.bing.net/th?q={{match.team1}}%20FC%20logo&w=60&h=60" alt="{{match.team1}} logo" style="height:60px">
							{% endif %}

							<h4 class="py-1 text-select">{{match.team1}}</h4>

						</div>

						<div class="col-md-auto col-4 text-center">

							<div class="fw-bolder fs-3">
								<span class="homeScore {% if goolHome is defined %}blink text-danger{% endif %}">{{lastOdds.scoreHome}}</span>
								-
								<span class="awayScore {% if goolAway is defined %}blink text-danger{% endif %} ">{{lastOdds.scoreAway}}
								</span>
							</div>

							<div id="matchStatus" data-status="{% if matchStatus.text !='FT' %}1{% else %}0{% endif %}" class="mt-3 badge bg-{{matchStatus.alert}} mt-2">{{matchStatus.text}}</div>

							{% if matchStatus.text !='FT' %}
								<span class="blink mt-2 d-sm-block live-indicator">
									<svg id="countdown" height="22" width="22">
										<circle cx="12" cy="12" r="7" stroke="#dc3545" stroke-width="3" fill="#2a2838"></circle>
									</svg>
								</span>
							{% endif %}

					
						</div>

						<div class="col-md-5 col-4 text-center team-away">
							{% if match.rating >=1 %}
								<img src="https://cdn.1xstavka.ru/genfiles/logo_teams/{{matchInfo['team2ID']}}.png" alt="{{match.team2}} logo" onerror="this.src='https://tse2.mm.bing.net/th?q={{match.team1}}%20FC%20logo&w=60&h=60'" style="height:60px">
							{% else  %}
								<img src="https://tse2.mm.bing.net/th?q={{match.team2}}%20FC%20logo&w=60&h=60" alt="{{match.team2}} logo" style="height:60px">
							{% endif %}

							<h4 class="py-1 text-select">{{match.team2}}</h4>
						</div>

					</div>
				</div>

				{% include 'match/place.volt' %}

			</div>

		</div>


	</div>



<!-- tabs -->
	<ul class="nav nav-pills small" id="match-tab" role="tablist" data-bs-theme="dark">

		<li class="nav-item" role="presentation">
			<button class="nav-link active" id="odds-tab" data-bs-toggle="pill" data-bs-target="#odds" type="button" role="tab" aria-controls="odds" aria-selected="true">Odds & Stats</button>
		</li>

	{% if !(h2h.data is empty) %}
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="h2h-tab" data-bs-toggle="pill" data-bs-target="#h2h" type="button" role="tab" aria-controls="h2h" aria-selected="false">H2H</button>
		</li>
	{% endif %}

		<li class="nav-item" role="presentation">
			<button class="nav-link" id="comments-tab" data-bs-toggle="pill" data-bs-target="#comments" type="button" role="tab" aria-controls="comments" aria-selected="false">Comments</button>
		</li>
	</ul>


<!-- tab-content -->
	<div class="tab-content" id="match-tab-content">
		<div class="tab-pane fade show active" id="odds" role="tabpanel" aria-labelledby="odds-tab">
			<div class="row">

				<div class="col">

					{{ partial('match/odds') }}

				</div>


				{% if !(lastStats is empty) %}

					<div class="col-md-4 col-12">
						<div class="card my-3  rounded"  data-bs-theme="dark">
							<div class="card-header">
								<div class="d-flex flex-wrap justify-content-between">
									<div>Statistics</div>
									<!-- <div class="text-end"><span class="icon-stacked"></span></div> -->
								</div>
							</div>

							<div class="card-body match-stat px-3 ">
								{{ partial('match/stat') }}

							</div>


						</div>

						<div class="card my-3  rounded"  data-bs-theme="dark">
							<div class="card-header">
								<div class="d-flex flex-wrap justify-content-between">
									<div>Chart Attacks</div>

								</div>
							</div>

							<div class="card-body match-stat px-3 ">
								{{ partial('match/charts') }}

							</div>


						</div>
					</div>


				{% endif %}

			</div>
		</div>

		{% if !(h2h.data is empty) %}	
	<!-- h2h -->
		<div class="tab-pane fade" id="h2h" role="tabpanel" aria-labelledby="h2h-tab">
			{{ partial('match/h2h') }}
		</div>
		{% endif %}

	<!-- comments -->
		<div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">

				<div id="wpac-comment" class="w-50 my-3 border p-3 "></div>


		</div>
	</div>


	<div class=" my-3 small opacity-8 match-snippet">
		<h1 class="fs-6">{{match.team1}}
			-
			{{match.team2}}</h1>
		<div class="info-box mb-3">
			<span class="fw-500">Match Date</span>
			<span class="d-flex align-items-start">{{date['view']}}
				UTC</span>

			{% if matchInfo["place"][2] is defined %}
				<span class="fw-500">Venue</span>
				<span class="d-flex align-items-start">{{matchInfo["place"][2]}}</span>
			{% endif %}
		</div>


		<p class="text-muted small">{{meta['info']}}</p>

	</div>
</article>

