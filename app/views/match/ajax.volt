<div class="row">

    <div class="col">
        {{ partial('match/odds') }}
    </div>

    {% if !(lastStats is empty) %}
    <div class="col-md-4 col-12">
        <div class="card my-3  rounded">
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

        <div class="card my-3  rounded" data-bs-theme="dark">
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
