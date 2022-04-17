
$(document).on("click", "#code", function(){
    var api = document.getElementById("api").value;
    var token = document.getElementById("token").value
    var chave = document.getElementById("chave").value
    var ipoudominio = document.getElementById("ipoudominio").value
    var porta = document.getElementById("porta").value
    var id = document.getElementById("id").value
    $("#status").html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>...');
    $.ajax({
        url: "rest/gerarqr.php",
        type: "POST",
        datatype:"json",
        data:  {api:api,token:token,chave:chave,ipoudominio:ipoudominio,porta:porta,id:id},
        success: function(data) {
            console.log(data)
            $("#status").html("Aguarde...");
            if(data != "QRCODE"){
                window.setTimeout(atualizaqr, 5000);
            }
        }
    });
});

function atualizaqr() {
    var api = document.getElementById("api").value;
    var token = document.getElementById("token").value
    var chave = document.getElementById("chave").value
    var ipoudominio = document.getElementById("ipoudominio").value
    var porta = document.getElementById("porta").value
    var id = document.getElementById("id").value
    $.ajax({
        url: "rest/atualizarqr.php",
        type: "POST",
        datatype:"json",
        data:  {api:api,token:token,chave:chave,ipoudominio:ipoudominio,porta:porta,id:id},
        success: function(data) {
            console.log(data);
            $("#status").html("Aguarde...");
            if(data == 'CLOSED'){
                var img = document.querySelector("#qrcode");
                img.setAttribute('src', "");
                var sts = document.querySelector("#status");
                $(sts).html("");
                $("#btnQr").removeClass("hidde");

            }if(data == 'CONNECTED'){
                var sts = document.querySelector("#status");
                var img = document.querySelector("#qrcode");
                img.setAttribute('src', "");
                $(sts).html("VOCE ESTA CONECTADO");
                setTimeout(function(){
                    document.location.reload(false);
                },3000);


            }if(data == ''){
                var img = document.querySelector("#qrcode");
                img.setAttribute('src', "");
                var sts = document.querySelector("#status");
                $(sts).html("Calma aew que tá processando.");

            }
            else{
                var img = document.querySelector("#qrcode");
                img.setAttribute('src', data);
                var status = document.querySelector("#status");
                $(status).html("ESCANEIE O QRCODE ");
                //window.setTimeout(atualizaqr, 5000);
                if(data == 'CLOSED'){
                    var sts = document.querySelector("#status");
                    $(sts).html("ERRO: Gere o QRCode novamante AGUARDE...");
                    setTimeout(function(){
                        document.location.reload(true);
                    },3000);

                }
            }
        }
    });
    setTimeout(function(){
        atualizaqr()
    },5000);
}