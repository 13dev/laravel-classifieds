@extends('layouts.app')

@section('titulo','Mensagens')
@section('extra-style','
<link href="assets/css/messages.css" rel="stylesheet">
    ')

@section('content')
    <div class="row">
        <div id="warnings">
        </div>
        <div class="col-md-4 all-persons">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <div class="person-header">
                <input class="form-control" id="search-conversations" placeholder="Procurar conversas..." type="text">
                </input>
            </div>
            <div id="loadingpersons">
                <div class="loading-chat">
                    <i class="fa fa-refresh fa-spin fa-4x fa-fw">
                    </i>
                    <span class="sr-only">
                        Loading...
                    </span>
                    <br>
                        <h4 class="text">
                            A carregar...
                        </h4>
                    </br>
                </div>
            </div>
            <div class="list-group pessoas">
            </div>
        </div>
        <div class="col-md-8 all-chat">
            <div class="chat-header">
                Para:
            </div>
            <div class="chat">
                <div id="loading">
                    <div class="loading-chat">
                        <i class="fa fa-refresh fa-spin fa-4x fa-fw">
                        </i>
                        <span class="sr-only">
                            Loading...
                        </span>
                        <br>
                            <h4 class="text">
                                A carregar...
                            </h4>
                        </br>
                    </div>
                </div>
                <div class="messages">
                    <div id="messages">
                        <img alt="Escolhe uma conversa!" class="start-image" src="{{ url('/assets/img/conversation.png') }}" width="300">
                            <h3 style="opacity:0.4;text-align:center;">
                                Escolhe uma conversa :)
                            </h3>
                        </img>
                    </div>
                    <div class="inputs">
                        <div class="input-group">
                            <input class="form-control" id="input-mensagem" placeholder="Search for..." type="text">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" id="enviar-mensagem" type="button">
                                        Enviar!
                                    </button>
                                </span>
                            </input>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height: 50px;">
    </div>
</link>
@endsection


@section('extra-script')
<script>
    $blink = true;
    function blinkBackground(conv_id = null){
            $delay = setTimeout(function () {
                if($blink){
                    $('.person[data-conv='+conv_id+']').addClass('active');
                }
            }, 2200);
            $delay1 = setTimeout(function () {
                if($blink){
                    $('.person[data-conv='+conv_id+']').removeClass('active');
                    blinkBackground(conv_id);
                }
            }, 4200);

            if(!$blink){
                clearTimeout($delay);
                clearTimeout($delay1);
            }
            
            
    }

    function message(message, title = "Sucesso!", tipo, div = '#warnings', desaparecer = true) {
        var message = '<div id="message" class="alert alert-' + tipo + '"><strong>' + title
                + '</strong> ' + message + '</div></div>';
        $(div).prepend(message);
        if (desaparecer) {
            setTimeout(function () {
                $('#message').fadeOut(1000, function () {
                    $('#message').remove();
                });
            }, 2200);
        }
    }
    function redirect(url) {
        return $(location).attr('href', '{{ url("' + url + '") }}');
    }
    $currentPerson = null;

    function getConversas(loading = 1) {
        console.log('obtendo conversas...');
        var token, url, unreadMessages;

        token = $('input[name=_token]').val();
        url = "{{ url('/m/inbox') }}";
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            datatype: 'JSON',
            beforeSend: function () {
                if (loading === 1) {
                    $("#loadingpersons").show();
                }
            },
            success: function (response) {
                var resposta = response.response;
                console.log(response);
                

                if (loading === 1) {
                    $("#loadingpersons").hide();
                }

                if (resposta === false) {
                    message('Pedimos desculpa, ocorreu um erro, tente mais tarde. algumas informações: <br>' + response.error, 'Ups!', 'danger', '#warnings', false)
                    return false;
                }
                $('.pessoas').empty();
                $.each(response.code, function (key, value) {
                    if(value.thread.unreadMessages > 0){
                        unreadMessages = true;
                    }else{
                        unreadMessages = false;
                    }

                    var media = $("<div/>", {"class": "media"});
                    var div_image = $("<div/>", {"class": "pull-left"});
                    var image = $("<img/>", {"alt": "" + value.withUser.username + "", "class": "media-object person-image", "src": "#"});
                    var media_body = $("<div/>", {"class": "media-body"});
                    var content_media = $("<div/>", {"class": "content-media"});

                    var tempo = $("<span/>", {"class": "time pull-right", "text": "" + value.thread.time + ""});
                    
                    if(unreadMessages){
                        if(value.thread.unreadMessages > 9)
                            var spanUnreadMessages = $("<span/>", {"class": "badge pull-right", "text": "+9", "style": "margin-top: 2px;"});
                        else
                            var spanUnreadMessages = $("<span/>", {"class": "badge pull-right", "text": "" + value.thread.unreadMessages+ "", "style": "margin-top: 2px;"});
                        var textUnreadMessages  = $("<span/>", {"class": "pull-right", "text": "Nova(s)","style": "margin-left: 5px;"});
                        
                    }else{
                        var spanUnreadMessages = null;
                        var textUnreadMessages  = null;
                    }
                    var tempo = $("<span/>", {"class": "time pull-right", "text": "" + value.thread.time + ""});
                    var name = $("<h5/>", {"class": "media-heading", "text": "" + value.withUser.username + ""});
                    var tr = $("<tr/>");
                    var td = $("<td/>");
                    var td1 = $("<td/>", {"style": "width: 100%;"});
                    var ultima_mensagem = $("<small/>", {"class": "ultima-mensagem pull-left", "text": "" + value.thread.message + ""})
                    var pessoa = $("<div/>", {
                        "class": "list-group-item person",
                        "data-person": "" + value.withUser.id + "",
                        "data-conv": "" + value.thread.conversation_id + ""
                    }).append(
                    media.append(
                        div_image.append(image)
                        ).append(
                        media_body.append(
                            content_media.append(tempo).append(name).append(
                                tr.append(
                                    td.append(ultima_mensagem)
                                ).append(
                                    td1.append(textUnreadMessages).append(spanUnreadMessages)
                                )
                            )
                        )
                    )
                );
                    if(unreadMessages){
                        blinkBackground(value.thread.conversation_id);
                        $blink = true;
                    }
                    $('.pessoas').append(pessoa);

                });
            }
        }).done(function () {
            clickPerson();
        });
    }

    function setMessage(conv_id, mensagem) {
        console.log('enviar mensagem...');
        var token, url;

        token = $('input[name=_token]').val();
        url = "{{ url('/m/send/') }}";
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': token},
            data: {conv_id: conv_id, mensagem: mensagem},
            type: 'POST',
            datatype: 'JSON',
            beforeSend: function () {
                if (loading === 1) {
                    $("#loadingpersons").show();
                }
            },
            success: function (response) {
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.log('Error: ' + error + 'status: ' + status);
            }
        });
    }

    function getChat(conv_id, loading = 1) {
        console.log('obtendo chat...');
        var token, url;

        token = $('input[name=_token]').val();
        url = "{{ url('/m/show') }}";
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            data: {conv_id: conv_id, token: token},
            datatype: 'JSON',
            beforeSend: function () {
                if (loading === 1) {
                    $("#loading").show();
                }
            },
            success: function (response) {
                console.log(response);
                var resposta = response.response;
                if (loading === 1) {
                    $("#loading").hide();
                }
                if (resposta === false) {
                    var error = response.error;
                    console.log('Pedimos desculpa, ocorreu um erro, tente mais tarde informações: Erro -> ' + error);
                    $(location).attr('href', '{{ url("/") }}');
                }
                $currentPerson = response.code.withUser.id;
                $('#messages').empty();
                var messages = $("<div/>", {"class": "messages", "data-conv_id": "" + conv_id + ""});

                $.each(response.code.messages, function (key, value) {
                    console.log(value.is_seen);
                    var bubble_me = $("<div/>", {"class": "bubble-me", "id": "" + value.id + "", "text": "" + value.message + ""});
                    var bubble_you = $("<div/>", {"class": "bubble-you", "id": "" + value.id + "", "text": "" + value.message + ""});
                    if (value.me === true) {
                        var result = bubble_me;
                    } else {
                        var result = bubble_you;
                    }
                    messages.append(result);
                });

                $('#messages').append(messages);
                $('.messages').animate({scrollTop: $(document).height()}, 0);

            },
            error: function (xhr, status, error) {
                console.log('Error: ' + error + 'status: ' + status);
            }
        });
    }

    function clickPerson() {
        if ($currentPerson !== null) {
            $('.person').removeClass('active');
            $('.person[data-person=' + $currentPerson + ']').addClass('active');

        }
        $('.person').click(function () {

            $('.person').removeClass('active');
            $(this).addClass('active');
            $convId = $(this).attr("data-conv");
            blinkBackground($convId);
            $blink = false;
            getConversas();
            getChat($convId);

        });
    }

    $(document).ready(function () {
        getConversas();

        $('#enviar-mensagem').click(function () {
            var mensagem = $('#input-mensagem').val();
            if (mensagem !== "" && $convId !== "") {
                setMessage($convId, mensagem);
                $('#input-mensagem').val("");
                getConversas();
                getConversas();
                getChat($convId);
                
            }
        });
        
    });
</script>
@endsection
