$(document).ready(function () {
    
    $(".error").hide();
    $("#tabella_acquisti").hide();
    
    $('#filtra').click(function(e){
        // impedisco il submit
        e.preventDefault(); 
        var _cd = $( "#cd option:selected" ).attr('value');
        var _cliente = $( "#cliente option:selected" ).attr('value');        


        var par = {
            cd : _cd,
            cliente : _cliente
        };
     
        $.ajax({
            url: 'amministratore/filtra_acquisti',
            data : par,
            dataType: 'json',
            success: function (data, state) {
                if(data['errori'].length === 0){
                    // nessun errore
                    $(".error").hide();
                    if(data['acquisti'].length === 0){               
                        // mostro il messaggio per nessun elemento
                        $("#nessuno").show();
                       
                        // nascondo la tabella
                        $("#tabella_acquisti").hide();

                    }else{
                        // nascondo il messaggio per nessun elemento
                        $("#nessuno").hide();
                        $("#tabella_acquisti").show();
                        //cancello tutti gli elementi dalla tabella
                        $("#tabella_acquisti tbody").empty();
                       
                        // aggingo le righe
                        var i = 0;
                        for(var key in data['acquisti']){
                            var esame = data['acquisti'][key];
                            $("#tabella_acquisti tbody").append(
                                "<tr id=\"row_" + i + "\" >\n\
                                       <td>a</td>\n\
                                       <td>a</td>\n\
                                       <td>a</td>\n\\n\
                                        </tr>");
                            if(i%2 == 0){
                                $("#row_" + i).addClass("alt-row");
                            }
                            
                            var colonne = $("#row_"+ i +" td");
                            $(colonne[0]).text(esame['cliente']);
                            $(colonne[1]).text(esame['cd']);
                            $(colonne[2]).text(esame['costo'] + " €");

                            i++;            
                        }
                    }
                } else{
                    $(".error").show();
                    $(".error ul").empty();
                    for(var k in data['errori']){
                        $(".error ul").append("<li>"+ data['errori'][k] + "<\li>");
                    }
                }
               
            },
            error: function (data, state, error) {
                alert (error);
                
            }
        
        });
        
    })
});
