


function graph()
{
    Chart.defaults.global.title.display=true;
    Chart.defaults.global.title.text="Base de Données";

    width = 1300;
    height = 700;

    console.log(window.innerWidth);
    if(window.innerWidth)
    {
        var left = (window.innerWidth-width)/2;
        var top = (window.innerHeight-height)/2;
    }
    else
    {
        var left = (document.body.clientWidth-width)/2;
        var top = (document.body.clientHeight-height)/2;
    }


    //window.open('Graphe.php','myChart', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + width + ', height=' + height + ', top=' + top + ', left=' + left);
    window.open('Graphe.php','myChart', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, fullscreen=yes');

    
}

function affichegraph()
{



    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: ShowGraph
        ,

        options: {
            title:{text:"Données de RG09"},
            scales: { xAxes: [{scaleLabel: {display:true,labelString: 'Temps'}}]},
            tooltips: {mode: 'index'},
            legend: {display: true, position: 'top', labels: {fontColor: 'black', fontSize: 12}}
        }

    });
   
}

