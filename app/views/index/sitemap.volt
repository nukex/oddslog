<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

{% for match in matchs %}
    <?php $country =  explode ('. ', $match->tournament)?>
    <?php $slug="match/{$match->id}/".Slug($country[0].' '. $match->team1.' '.$match->team2)?>
    <url>
        <changefreq>weekly</changefreq>
        <loc>https://oddslogs.com/{{ slug }}</loc>
    </url>
{% endfor %}
</urlset>