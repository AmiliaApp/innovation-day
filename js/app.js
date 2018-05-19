$(document).ready(function() {
  if (window.navigator.standalone) $('body').addClass('standalone');

  // Globals: page, projects & person

  if (page == 'vote') {
    var $form = $('form');
    $form.find('a.submit-again').on('click', function(e) {
      e.preventDefault();
      $form.find('a.btn-success,p.text-success,a.submit-again,p.filled-form').hide();
      $form.find('.form-group').show();
      $form.find('button[type=submit]').show();
      $form.find('select:first').focus();
    });
  }

  if (page == 'results') {

    var default_colors = ['#3366CC','#DC3912','#FF9900','#109618','#990099','#3B3EAC','#0099C6','#DD4477','#66AA00','#B82E2E','#316395','#994499','#22AA99','#AAAA11','#6633CC','#E67300','#8B0707','#329262','#5574A6','#3B3EAC'];

    $('canvas.votes').each(function() {
      var column = $(this).data('vote');

      var data = JSON.parse(JSON.stringify(projects));
      data.sort(function(a, b) {
        return a[column] < b[column] ? 1 : (a[column] > b[column] ? -1 : 0);
      });

      var colors = [];
      for (var i = 0; i < data.length; i++) colors.push(default_colors[i%default_colors.length]);

      new Chart(this, {
        type: 'horizontalBar',
        data: {
          labels: data.map(function(p) {return p.name;}),
          datasets: [
            {
              label: "Population (millions)",
              backgroundColor: colors,
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