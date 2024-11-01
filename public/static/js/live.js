 var origTitle, animatedTitle, timer;

 function animateTitle(newTitle) {
     var currentState = false;
     animatedTitle = "Goal ! " + origTitle;
     timer = setInterval(startAnimation, 1500);

     function startAnimation() {
         document.title = currentState ? origTitle : animatedTitle;
         $("link[rel='shortcut icon']").attr('href', currentState ? '/favicon.ico' : '/static/img/favicon-goal.png')
         currentState = !currentState;
     }
 }


 function restoreTitle() {
     if (timer) {
         clearInterval(timer);
         document.title = origTitle;
         $("link[rel='shortcut icon']").attr('href', '/favicon.ico')
     }
 }



 if (document.getElementById("liveMatches")) {
     setInterval(function() {
         $('#main').load('/live?ajax=1');
         console.log('live update')
     }, 60000);
 }

 if (document.getElementById("match")) {
     setInterval(function() {
         console.log('live update')
         if ($('#matchStatus').data('status') == 1) {
             $.post("", {}).done(function(data) {

                 if (!data.error && data.time != 'FT') {
                     $('#odds').html(data.content);
                     $('.homeScore').text(data.score[0]);
                     $('.awayScore').text(data.score[1]);
                     $('#matchStatus').text(data.time);

                     if (data.scored[0]) {
                         $('.homeScore').addClass('blink text-danger')
                         animateTitle();
                     }

                     if (data.scored[1]) {
                         $('.awayScore').addClass('blink text-danger')
                         animateTitle();
                     }

                     if (!data.scored[0] && !data.scored[1]) {
                         $('.homeScore, .awayScore').removeClass('blink text-danger')
                         restoreTitle()
                     }

                     $('.live-indicator').html('<svg id="countdown" height="22" width="22"><circle cx="12" cy="12" r="7" stroke="#dc3545" stroke-width="3" fill="#eee"></circle>')
                 } else {
                     $('.homeScore, .awayScore').removeClass('blink text-danger')
                     restoreTitle()
                     $('.live-indicator').remove();
                 }

             })
         }

     }, 60000);
 }

 $(function() {
     origTitle = document.title;
 });