<div class="row">

    <div class="content-wrapper" style="min-height: 660px;">
    <!-- Content Header (Page header) -->
        <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12" id="accordion">
                <div class="card card-primary card-outline">
                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                               Como Consigo a API para uso externo e quais dados preciso?
                            </h4>
                        </div>
                    </a>
                    <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            1. é bem simples, após cadastrar o dispositivo e atrelar á algum cadastro de usuário

                            vá em "Menu, Dispositivos", na lista de dispositivos, clique em "Abrir Cadastro". <br>
                            Copie a API de Uso Externo e o UUID do usuário no submenu usuários do dispositivo. <br>
                            Por questões de segurança principalmente para facilitar ao usuário as requisições são enviadas via GET
                            o sistema analisa a integridade da API com o UUID do usuário se ambos baterem o acesso é liberado <br>
com esses dados em mãos, está apto a enviar mensagens e arquivos para o whatsapp ou mesmo integrar a sistemas de terceiros

                        </div>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                2. Como consigo enviar uma mensagem para algum celular?
                            </h4>
                        </div>
                    </a>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            Envie um GET ou direto da URL do navegador com os seguintes parâmetros:
                            <br>
                            "<b>URL/</b>webhooks?key=<b>CHAVE DE API EXTERNO</b>&uuid=<b>UUID DO USUÁRIO</b>&tipo=<b>message</b>&numero=
                            <b>NÚMERO EM FORMATO EXEMPLO(5584907262607)</b>&mensagem=<b>MENSAGEM A SER ENVIADA</b>"
                            <p>
                                <br>
                            Exemplo:
                            <br>
                            http://127.0.0.1/wppweb/webhooks?key=MnxhYWQwNjMwNzNiMjM0NG42323iYzdmZjRiNjdjZnwkMmIkMTAkOUI2bE5fczFCZGZDNjNmekFSRThTdV9sSmhPT1g2YzNmaHJGYmxQMnk2RUFRS3RXUFhBSlM=&uuid=548f3e2a-45444-41c7-4222-25d64645a3&tipo=message&numero=5584907262607&mensagem=E alá esse homi é brabo mermo vum 😏

                            <br>
                            <br>
                            Observe que a formatação do numero tem que ser a mesma do whatsapp da pessoa a ser enviada.. se tem ou não o 9 na frente...
                        </div>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                3. Como envio Audio ou Fotos
                            </h4>
                        </div>
                    </a>
                    <div id="collapseThree" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            Envie um GET ou direto da URL do navegador com os seguintes parâmetros:
                            <br>
                            "<b>URL/</b>webhooks?key=<b>CHAVE DE API EXTERNO</b>&uuid=<b>UUID DO USUÁRIO</b>&tipo=<b>file</b>&numero=
                            <b>NÚMERO EM FORMATO EXEMPLO(5584907262607)</b>&fileURL=<b>URL DO ARQUIVO A SER ENVIADO</b>&filename=<b>NOME DO ARQUIVO (OPCIONAL)</b>"
                            <p>
                                <br>
                                Exemplo:
                                <br>
                                http://127.0.0.1/wppweb/webhooks?key=MnxhYWQwNjMwNzNiMjM0NG42323iYzdmZjRiNjdjZnwkMmIkMTAkOUI2bE5fczFCZGZDNjNmekFSRThTdV9sSmhPT1g2YzNmaHJGYmxQMnk2RUFRS3RXUFhBSlM=&uuid=548f3e2a-45444-41c7-4222-25d64645a3&tipo=file&numero=5584907262607&fileURL=https://st2.depositphotos.com/4164031/6914/i/450/depositphotos_69145633-stock-photo-flag-of-brazil.jpg&filename=ual 😏

                                <br>
                                <br>
                                Observe que a formatação do numero tem que ser a mesma do whatsapp da pessoa a ser enviada.. se tem ou não o 9 na frente...
                        </div>
                    </div>
                </div>
                <div class="card card-warning card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapseFive">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                               4. Como envio um link
                            </h4>
                        </div>
                    </a>
                    <div id="collapseFive" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            Envie um GET ou direto da URL do navegador com os seguintes parâmetros:
                            <br>
                            "<b>URL/</b>webhooks?key=<b>CHAVE DE API EXTERNO</b>&uuid=<b>UUID DO USUÁRIO</b>&tipo=<b>link</b>&numero=
                            <b>NÚMERO EM FORMATO EXEMPLO(5584907262607)</b>&url=<b>URL DO LINK</b>&caption=<b>CAPTION DO LINK (OPCIONAL)</b>"
                            <p>
                                <br>
                                Exemplo:
                                <br>
                                http://127.0.0.1/wppweb/webhooks?key=MnxhYWQwNjMwNzNiMjM0NG42323iYzdmZjRiNjdjZnwkMmIkMTAkOUI2bE5fczFCZGZDNjNmekFSRThTdV9sSmhPT1g2YzNmaHJGYmxQMnk2RUFRS3RXUFhBSlM=&uuid=548f3e2a-45444-41c7-4222-25d64645a3&tipo=link&numero=5584907262607&url=https://www.youtube.com/watch?v=RLYj5rbw8Qk&caption=ual 😏

                                <br>
                                <br>
                                Observe que a formatação do numero tem que ser a mesma do whatsapp da pessoa a ser enviada.. se tem ou não o 9 na frente...
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3 text-center">
                <p class="lead">
                    <a href="https://github.com/aspiretony/">Caso tenha idéias sugestões ou precisa de ajuda</a>,
                    Fale comigo no GITHUB :)<br>
                </p>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
</div>
