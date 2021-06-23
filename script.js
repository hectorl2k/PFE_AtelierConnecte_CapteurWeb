

var last_popUp;






const buttons = document.querySelectorAll('button');         // Ouvrir pop Up

for(let i=1;i<buttons.length;i++)
{
    let button =buttons[i];

    button.addEventListener('click',()=> {







        if (button.className.split(' ').find(element => element == 'PopUp') == 'PopUp')      // Verifie class PopUp
        {

            let btn = (button.id).replace("btn", "PopUp");    // On ne prends pas en compte les boutons acquittement
            //console.log("Ouverture PopUp : " + btn);
            let popUp = document.getElementById(btn);
            last_popUp = popUp;
            popUp.style.display = "block";


        } else if (button.className.split(' ').find(element => element == 'Impression') == 'Impression'){

            let Nom_Equipement = document.getElementById('Nom_Equipement').value;
            let print_period_start = document.getElementById('print_period_start').value;
            let print_period_stop = document.getElementById('print_period_stop').value;
            let Max_rows_print = document.getElementById('Max_rows_print').value;
            let Print_mode = document.getElementById('Print_mode').value;


            $.ajax({
                type:"POST" ,
                url:"Function_Ajax.php",
                data:{
                    action:"Impression",
                    Nom_Equipement,
                    print_period_start,
                    print_period_stop,
                    Max_rows_print,
                    Print_mode
                },
                dataType: "json",
                success: function (response){

                    document.getElementById('All_page_print').innerHTML =response.data;
                    print();

                }
            });









        }
        });
}

const spans =document.querySelectorAll('span');             // Fermer pop Up en cliquant sut la croix
for(let i=0;i<spans.length;i++)
{
    let span =spans[i];
    span.addEventListener('click',()=>{
        last_popUp.style.display="none";

    });
}


window.onclick = function(event) {                  // Fermer Pop up si pas dans la fenetre

    if (event.target == last_popUp ) {
        last_popUp.style.display = "none";

    }
}


function acquitter_data(name)
{

    var stop =0;
    var i=1;

    tab=document.getElementById("Tableau_erreur").rows;

    while( i<tab.length || stop ==1) {

        if (tab[i].accessKey == name) {
            var deljs = tab[i].rowIndex
            var deltxt= tab.length-deljs-1;



        }
    i++;
    }


    $.ajax({
        type:"POST" ,
        url:"Function_Ajax.php",
        data:{
            action:"FunctionDelRow",
            ArrayDelRow:deltxt
        },
        dataType: "json",
        success: function (response){
            document.getElementById("Tableau_erreur").deleteRow(deljs);
        }
    });


}


var popup_print=document.getElementById("PopUp_Print-Setup");


document.getElementById('Bouton_Open_PopUp_Print').addEventListener('click',()=> {
    popup_print.style.display="block";
    last_popUp=popup_print;
});

document.getElementById('Erreur_Impression').addEventListener('click',()=> {
    console.log("dede");
    popup_print.style.display="block";
    last_popUp=popup_print;
});

document.getElementById('Annuler_impression').addEventListener('click',()=> {
    last_popUp.style.display="none";
});



document.addEventListener('keydown', (touche)=>{if(typeof last_popUp != 'undefined' && last_popUp.style.display=='block' &&touche.key == 'Escape')
{last_popUp.style='none';}});



