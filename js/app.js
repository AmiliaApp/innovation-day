$(document).ready(function() {
  if (window.navigator.standalone) $('body').addClass('standalone');

  // Globals: page, projects & person

  if (page == 'vote') {
    var $form = $('form');
    $form.find('input,select').one('change', function(e) {
      $form.find('a.btn-success').hide();
      $form.find('p.text-success').hide();
      $form.find('button[type=submit]').removeClass('btn-default').addClass('btn-lg btn-primary');
    });
  }

  if (page == 'results') {

    $('canvas.votes').each(function() {
      var column = $(this).data('vote');

      var data = JSON.parse(JSON.stringify(projects));
      data.sort(function(a,b) {
        return (a[column] < b[column]) ? 1 : ((b[column] > a[column]) ? -1 : 0);
      }); 

      new Chart(this, {
        type: 'horizontalBar',
        data: {
          labels: data.map(function(p) {return p.name;}),
          datasets: [
            {
              label: "Population (millions)",
              backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
              data: data.map(function(p) {return p[column];})
            }
          ]
        },
        options: {
          legend: {display: false},
          title: {display: false},
          scales: {
            xAxes:[{
              ticks: {
                min: 0,
                callback: function(value, index, values) {
                  if (Math.floor(value) === value) {
                    return value;
                  }
                }
              }
            }],
            yAxes: [{
              gridLines: {display: false}
            }]
          }
        }
      });
    });

  }

});