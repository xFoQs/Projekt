$( document ).ready(function() {

    $('.card[id]').click(function() {
        $('<div/>', {
            text: 'Dodano do kolekcji!',
            class: 'notification is-size-6'
        })
        .appendTo($('#jqmw'))
        .fadeOut( 3000, function() {
            $(this).remove();
        });
    })

    // $('.tabs li').on('click', function() {
  
    //   $('.tabs li').removeClass('is-active');
    //   $(this).addClass('is-active');
      
    // });
    $('#inputClick').click(function() {
      $('#wypo').click();
    })
});


$(document).ready(function () {
  
    let arr = []
    for(let i in ksiazki) {
        arr.push(ksiazki[i].id)
    }

  createCookie("height", arr, "1");

function createCookie(name, value, days) {
  var expires;
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toGMTString();
  }
  else {
    expires = "";
  }
  document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}


});


