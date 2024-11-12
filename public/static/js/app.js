
(function() {

})();


var href
var popover

var $d = $(document)
const J$  = document.querySelector.bind(document)

function statPopover(data) {
    var popover
    var title = { 'M': 'Minute', 'A': 'Attacks', 'D': 'Dangerous attacks', 'P': 'Possession %', 'SO': 'Shots on target', 'S': 'Shots off target', 'C': 'Corners', 'Y': 'Yellow cards', 'R': 'Red cards', 'PE': 'Penalties' };

    $.each(data, function(k, val) {

        if (val != '' && val !== null && k != '' && k != 'M') {
            let vals = val.split('|')
            if (vals[0] != 0 || vals[1] != 0) {
                var percent0 = calcPercent(vals[0], vals)
                var percent1 = calcPercent(vals[1], vals)
                var templ = $.trim($('#stat-popover').html());
                templ = templ.replace(/##title##/ig, title[k]);
                templ = templ.replace(/##val0##/ig, vals[0]);
                templ = templ.replace(/##val1##/ig, vals[1]);
                templ = templ.replace(/##percent0##/ig, percent0);
                templ = templ.replace(/##percent1##/ig, percent1);
                popover += templ
            }
        }
    })
    return popover
}

function calcPercent(val, vals) {
    let sum = parseInt(vals[0]) + parseInt(vals[1])
    return parseInt(val) / sum * 100
}

$(document).ready(function($) {
    $("[data-bs-toggle=tooltip]").tooltip();
    $('.prefooter .container').html($('.match-snippet').html())
    $('.match-snippet').remove()


    $(window).scroll(function () {

            500 < $(this).scrollTop()
            ? $(".back-to-top").fadeIn()
            : $(".back-to-top").fadeOut();
        })
});



$(document).on("mouseenter  click", ".stats", function(e) {
    var data = $(this).data('stat')
    popover = statPopover(data).replace('undefined', data.M + "' ")

    $('.popover').css('left', (e.pageX - 240) + 'px');
    $('.popover').css('top', (e.pageY - 30) + 'px');
    $('.popover').fadeIn("fast");

    $('.popover').html(popover).width("200px")

});

$(document).on("mouseleave", ".stats", function(e) {
    $('.popover').hide();
});





$(document).on("change", "#datepicker", function() {
    document.location.href = '/date/' + $(this).val()
});



$(document).on("click", "body", function(e) {
    $("#autocomplate").hide();
});


$(document).on("keyup", "#search", function(e) {
    if (e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 39 && e.keyCode != 37) {

        if ($(this).val().length > 1) {

            $.post("/search/", { query: $(this).val() })
                .done(function(json) {
                    if (json != null && json.length > 0) {
                        $("#autocomplate").empty().show();
                        $.each(json, function(k, val) {

                            $("#autocomplate").append('<a href="' + val['slug'] + '" id="com-' + k + '" class="list-group-item ">' +
                                '<div class="row align-items-center ">' +
                                '<div class="col-1 p-0">' +
                                '<span class="flags flags-category flags--sm flags--' + val['country'] + '"></span>' +
                                '</div>' +
                                '<div class="col-11 ">' +
                                '<span class="title">' + val['team1'] + ' - ' + val['team2'] + '</span><br> <span class="small text-muted">' + val['date'] + '</span> <span class="small text-muted badge bg-danger">' + val['info'] + '</span>' +
                                '</div>' +
                                '</div></a>');


                            if (k > 18) return false;
                        });
                        select = -1;
                    }
                });
        } else $("#autocomplate").hide();
    }

    $("#autocomplate a").removeClass('active');
    if (e.keyCode == 40 || e.keyCode == 38) {
        if (select < $("#autocomplate a").length - 1 && e.keyCode == 40)
            select++;
        if (select > 0 && e.keyCode == 38)
            select--;

        $("#com-" + select).addClass('active');
        $('#search').val($("#com-" + select + ' .title').text().trim());
        href = $("#autocomplate").find('a.active').attr('href')
    }

    if (e.keyCode == 13 && href != '') {
        document.location.href = href
    }
});



$(document).on("click", "#comments-tab", function(e) {

});



$(document).on("click", "#signin", function () {
    $("#MainModal .modal-body").load("/form/signin"),
    $("#MainModal #modal-title").text("Login"),
    $("#MainModal").modal("show");
})

  $("#MainModal").on("hidden.bs.modal", function () {})



  

  async function Sign(type){

    if ( document.querySelector("#form-" + type).reportValidity() ) {

      $('#loading-'+ type).removeClass('d-none')
      $("#btn-"+ type).attr("disabled", true);

  
      fetch("/user/" + type, {
        method: "POST",
        headers: {"Content-type": "application/x-www-form-urlencoded"},
        body: JSON.stringify(serializeForm(J$("#form-" + type)))

      }).then(function (response) {
        if (response.ok) {
          return response.json();
        }
        return Promise.reject(response);

      }).then(function (res) {
   
        showToast(res.status, res.message)
  
        if (res.status == "success" && res.action == "reload") {

          

          setTimeout(() => {
            window.location.reload()
          }, 3000)
        }

        $('#loading-'+ type).addClass('d-none')
        if (res.status == 'error') {
           $("#btn-"+ type).attr("disabled", false);
        }

  
      }).catch(function (error) {
    
        showToast( error.status, error.statusText )
      })

    } else {
        showToast('warn', 'Required fields Please fill in all fields!', 5)
    }
    
  }


function showToast(s, t) {


    let icons = {"ok":"🟢", "success":"🟢", "error":"🔴" , "warn": "🟡" } 
    
    $(".toast").toast("dispose").removeClass("bg-danger-subtle"),
    $(".toast-header strong").text(s),
    $(".toast .icon").html(icons[s])
    $(".toast-body").html(t)


    var f = new bootstrap.Toast($(".toast"), {
        autohide: !0,
        animation: !0,
        delay: 1e3 * 6,
    });

    f.show();
}


  var serializeForm = function (form) {
    var obj = {};
    var formData = new FormData(form);
    for (var key of formData.keys()) {
      obj[key] = formData.get(key);
    }
    return obj;
  };