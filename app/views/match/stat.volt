
{% if !(lastStats['A'] is empty) AND (lastStats['A'][1] is defined) AND ( lastStats['A'][1]> 0 OR lastStats['A'][0] > 0) %}
    <div class="mb-2">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="small">Attacks</div>
        </div>

        <div class="progress progress-sm">
            <div class="progress-bar bg-primary" role="progressbar" 
            style="width: {{ statPercent(0,lastStats['A'] ) }}%"  data-bs-toggle="tooltip" title="{{ statPercent(0,lastStats['A'] ) }}%">{{lastStats['A'][0]}}</div>
            <div class="progress-bar " role="progressbar" style="width: 0.5%"></div>
            <div class="progress-bar bg-success " role="progressbar" 
            style="width: {{ statPercent(1,lastStats['A'] ) }}%"  data-bs-toggle="tooltip" title="{{ statPercent(1,lastStats['A'] ) }}%">{{lastStats['A'][1]}}</div>
        </div>
    </div>
{% endif %}

{% if !(lastStats['D'] is empty)  AND (lastStats['D'][1] is defined) AND ( lastStats['D'][1]> 0 OR lastStats['D'][0] > 0) %}
<div class="mb-2">
    <div class="d-flex flex-wrap justify-content-center">
        <div class="small">Dangerous attacks</div>
    </div>
    <div class="progress progress-sm">
        <div class="progress-bar bg-primary" role="progressbar" 
        style="width: {{ statPercent(0,lastStats['D'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(0,lastStats['D'] ) }}%">{{lastStats['D'][0]}}</div>
        <div class="progress-bar " role="progressbar" style="width: 0.5%;"></div>
        <div class="progress-bar bg-success " role="progressbar" 
        style="width: {{ statPercent(1,lastStats['D'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(1,lastStats['D'] ) }}%">{{lastStats['D'][1]}}</div>
    </div>
</div>
{% endif %}

{% if !(lastStats['P'] is empty) AND (lastStats['P'][1] is defined) AND ( lastStats['P'][1]> 0 OR lastStats['P'][0] > 0) %}
<div class="mb-2">
    <div class="d-flex flex-wrap justify-content-center">
        <div class="small">Possession %</div>
    </div>
    <div class="progress progress-sm">
        <div class="progress-bar bg-primary" role="progressbar" 
         style="width: {{ statPercent(0,lastStats['P'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(0,lastStats['P'] ) }}%">{{lastStats['P'][0]}}</div>
        <div class="progress-bar " role="progressbar" style="width: 0.5%;"></div>
        <div class="progress-bar bg-success " role="progressbar" 
         style="width: {{ statPercent(1,lastStats['P'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(1,lastStats['P'] ) }}%">{{lastStats['P'][1]}}</div>
    </div>
</div>
{% endif %}

{% if !(lastStats['SO'] is empty) AND (lastStats['SO'][1] is defined) AND ( lastStats['SO'][1]> 0 OR lastStats['SO'][0] > 0)  %}
<div class="mb-2">
    <div class="d-flex flex-wrap justify-content-center">
        <div class="small">Shots on target</div>
    </div>
    <div class="progress progress-sm">
        <div class="progress-bar bg-primary" role="progressbar" 
        style="width: {{ statPercent(0,lastStats['SO'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(0,lastStats['SO'] ) }}%">{{lastStats['SO'][0]}}</div>
        <div class="progress-bar " role="progressbar" style="width: 0.5%;"></div>
        <div class="progress-bar bg-success " role="progressbar" 
        style="width: {{ statPercent(1,lastStats['SO'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(1,lastStats['SO'] ) }}%">{{lastStats['SO'][1]}}</div>
    </div>
</div>
{% endif %}


{% if !(lastStats['S'] is empty) AND (lastStats['S'][1] is defined) AND ( lastStats['S'][1]> 0 OR lastStats['S'][0] > 0) %}
    <div class="mb-2">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="small">Shots off target</div>
        </div>
        <div class="progress progress-sm">
            <div class="progress-bar bg-primary" role="progressbar" 
            style="width: {{ statPercent(0,lastStats['S'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(0,lastStats['S'] ) }}%">{{lastStats['S'][0]}}</div>
            <div class="progress-bar " role="progressbar" style="width: 0.5%;"></div>
            <div class="progress-bar bg-success " role="progressbar" 
            style="width: {{ statPercent(1,lastStats['S'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(1,lastStats['S'] ) }}%">{{lastStats['S'][1]}}</div>
        </div>
    </div>
{% endif %}

{% if !(lastStats['C'] is empty) AND (lastStats['C'][1] is defined) AND ( lastStats['C'][1]> 0 OR lastStats['C'][0] > 0) %}
    <div class="mb-2">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="small">Corners</div>
        </div>
        <div class="progress progress-sm">
            <div class="progress-bar bg-primary" role="progressbar" 
            style="width: {{ statPercent(0,lastStats['C'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(0,lastStats['C'] ) }}%">{{lastStats['C'][0]}}</div>
            <div class="progress-bar " role="progressbar" style="width: 0.5%;"></div>
            <div class="progress-bar bg-success " role="progressbar" 
            style="width: {{ statPercent(1,lastStats['C'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(1,lastStats['C'] ) }}%">{{lastStats['C'][1]}}</div>
        </div>
    </div>
{% endif %}

{% if (lastStats['Y'] !='') AND (lastStats['Y'][1] is defined) AND ( lastStats['Y'][1]> 0 OR lastStats['Y'][0] > 0) %}

    <div class="mb-2">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="small">Yellow cards</div>
        </div>
        <div class="progress progress-sm">
            <div class="progress-bar bg-primary" role="progressbar" 
            style="width: {{ statPercent(0,lastStats['Y'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(0,lastStats['Y'] ) }}%">{{lastStats['Y'][0]}}</div>
            <div class="progress-bar " role="progressbar" style="width: 0.5%;"></div>
            <div class="progress-bar bg-success " role="progressbar" 
            style="width: {{ statPercent(1,lastStats['Y'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(1,lastStats['Y'] ) }}%">{{lastStats['Y'][1]}}</div>
        </div>
    </div>
{% endif %}

{% if !(lastStats['R'] is empty) AND (lastStats['R'][1] is defined) AND (lastStats['R'][1]> 0 OR lastStats['R'][0] > 0) %}
    <div class="mb-2">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="small">Red cards</div>
        </div>
        <div class="progress progress-sm">
            <div class="progress-bar bg-primary" role="progressbar" 
            style="width: {{ statPercent(0,lastStats['R'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(0,lastStats['R'] ) }}%">{{lastStats['R'][0]}}</div>
            <div class="progress-bar " role="progressbar" style="width: 0.5%;"></div>
            <div class="progress-bar bg-success " role="progressbar" 
            style="width: {{ statPercent(1,lastStats['R'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(1,lastStats['R'] ) }}%">{{lastStats['R'][1]}}</div>
        </div>
    </div>
{% endif %}

{% if !(lastStats['PE'] is empty) AND (lastStats['PE'][1] is defined) AND (lastStats['PE'][1]> 0 OR lastStats['PE'][0] > 0) %}
    <div class="mb-2">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="small">Penalties</div>
        </div>
        <div class="progress progress-sm">
            <div class="progress-bar bg-primary" role="progressbar" 
            style="width: {{ statPercent(0,lastStats['PE'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(0,lastStats['PE'] ) }}%">{{lastStats['PE'][0]}}</div>
            <div class="progress-bar " role="progressbar" style="width: 0.5%;"></div>
            <div class="progress-bar bg-success " role="progressbar" 
            style="width: {{ statPercent(1,lastStats['PE'] ) }}%" data-bs-toggle="tooltip" title="{{ statPercent(1,lastStats['PE'] ) }}%">{{lastStats['PE'][1]}}</div>
        </div>
    </div>
{% endif %}
