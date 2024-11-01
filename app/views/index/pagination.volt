{% set start = (limit * (page.current - 1)) + 1 %}
{% set end = (limit * (page.current-1)) + limit %}

{% if end > page.total_items %}
  {% set end = page.total_items %}
{% endif %}



{% if page.last > 1 %}
    <nav aria-label="Page navigation">
        <ul class="pagination">
        {% if page.current != 1 %}
            <li class="page-item"><a class="page-link mx-1 border-0 shadow-sm " href="?page=1">&laquo;</a></li>
        {% endif %} 

        {% for i in (page.current-1)..(page.current+2) %}
            {% if i >=1 and i <= page.last %}
            <li class="page-item {% if i == page.current %}active {% endif %}"><a class="page-link mx-1 border-0 shadow-sm "  href="?page={{ i }}">{{ i }}</a></li>
            {% endif %}
        {% endfor %}

        {% if page.current != page.last %}
            <li class="page-item"><a class="page-link mx-1 border-0 shadow-sm " href="?page={{ page.last }}">&raquo;</a></li>
        {% endif %}
        </ul> 
    </nav>
{% endif %}
