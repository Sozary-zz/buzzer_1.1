$('#nope').hide()
$('#buzzed').hide()
$('#alreadybuzzed').hide()
$('#res').hide()



var table = document.querySelector('#studResult')
var resLoop
var buzzed = false



$('#pseudo').keypress(function(e) {
  if (e.keyCode == 13)
    validatePseudo()
})
document.body.onkeyup = function(e) {
  if (e.keyCode == 32)
    buzz()
}

let stop = () => {
  $.ajax({
    url: "?action=resetSession&name=" + $('#name').text(),
    success: function(result) {
      if (result == "0x1") {
        location.reload();
      }
    }
  })

}
let endSession = () => {
  $.ajax({
    url: "?action=endSession&name=" + $('#name').text(),
    success: function(result) {
      window.location = "http://209.97.134.204/buzzer%201.1/?action=welcome"

    }
  })
}

let start = () => {
  $.ajax({
    url: "?action=startBuzzer&name=" + $('#name').text(),
    success: function(result) {
      location.reload();

    }
  })
}

let buzz = () => {
  if (!buzzed) {
    if ($('#pseudo').val() == "") {
      $('#nope').fadeIn()
      return
    }
    $('#nope').fadeOut()
    buzzed = true

    $.ajax({
      url: "?action=buzz&player=" + document.querySelector('.pseudo').innerText + '&user=' + $('#name').text(),
      success: function(result) {
        console.log(result);
        if (result == "0x1") {
          $('.buzz').fadeOut()
          $('#letsbuzz').fadeOut()
          setTimeout(() => {
            $('#buzzed').fadeIn()
          }, 400)
        } else {
          $('.buzz').fadeOut()
          $('#letsbuzz').fadeOut()
          setTimeout(() => {
            $('#alreadybuzzed').fadeIn()
          }, 400)
        }
        buzzed = false
      }
    })
  }
}
let updateTable = () => {
  $.ajax({
    url: "?action=gatherData&name=" + $('#name').text(),
    success: function(result) {
      if (result != "0x0") {
        let data = JSON.parse(result)

        for (let i = table.children.length; i < data.length; i++) {
          let d = data[i].split(',')
          let tr = document.createElement("tr")
          let th = document.createElement("th")
          let td = document.createElement("td")
          if (i == 0)
            tr.classList.add('table-success')
          else if (i == 1)
            tr.classList.add('table-danger')
          else if (i == 2)
            tr.classList.add('table-warning')
          else if (i % 2 == 0)
            tr.classList.add('table-active')
          th.setAttribute('scope', 'row')
          th.appendChild(document.createTextNode(d[0]))
          td.appendChild(document.createTextNode(i + 1))
          tr.appendChild(th)
          tr.appendChild(td)
          table.appendChild(tr)
        }
      }

    }
  })
}
let show = () => {
  resLoop = setInterval(updateTable, 1000);
  $('#res').fadeIn()
}
let validatePseudo = () => {
  if ($('#pseudo').val() == "") {
    $('#nope').fadeIn()
    return
  }
  $('#nope').fadeOut()
  $.ajax({
    url: "?action=validatePseudo&name=" + $('#name').text() + "&pseudo=" + $('#pseudo').val(),
    success: function(result) {
      if (result == "0x1") {
        $('.pseudo').text($('#pseudo').val())
        $('#idInfo').fadeOut()
      }
    }
  })
}