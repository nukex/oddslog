<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        {% for url in urls %}
        <sitemap>
           <loc>{{ url }}</loc>
           <lastmod><?php echo date('c')?></lastmod>
        </sitemap>
        {% endfor %}
</sitemapindex>