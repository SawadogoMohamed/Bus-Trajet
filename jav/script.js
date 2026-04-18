Notification.requestPermission(function(){
    if(Notification.permission== "granted")
    {

    }
    else
    {
        console.log("la permission a été refusée ou non définie !")
    }
})


//la notification
let notification = new Notification("Notification de rendez-vous", {
body :"Cliquer ici pour voir le rendez-vous",

})


notification.onclick = function()
{
    window.open('fiche_projets.index' , '_blank');
}

$(document).ready(function(){
    $("18-07-2023").on("keyup",function(){

        var value =$(this).val().toLowerCase();
        $("#myTable tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1);
        });
    });
});
