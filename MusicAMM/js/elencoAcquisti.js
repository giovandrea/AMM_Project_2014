                        
                        // mostro il messaggio per nessun elemento
                        $("#nessuno").show();
                       
                        // nascondo la tabella
                        $("#tabella_ordini").hide();

                    }else{
                        // nascondo il messaggio per nessun elemento
                        $("#nessuno").hide();
                        $("#tabella_ordini").show();
                        //cancello tutti gli elementi dalla tabella
                        $("#tabella_ordini tbody").empty();
                       
                        // aggingo le righe
                        var i = 0;
                        for(var key in data['ordini']){
                            var esame = data['ordini'][key];
                            $("#tabella_ordini tbody").append(
                                "<tr id=\"row_" + i + "\" >\n\
                                       <td>a</td>\n\
                                       <td>a</td>\n\
                                       <td>a</td>\n\\n\
                                        </tr>");
                            if(i%2 == 0){
                                $("#row_" + i).addClass("alt-row");
                            }
                            
                            var colonne = $("#row_"+ i +" td");
                            $(colonne[0]).text(esame['utente']);
                            $(colonne[1]).text(esame['CD']);
                            $(colonne[5]).text(esame['costo'] + " €");

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