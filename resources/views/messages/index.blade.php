@extends('layouts.app')

@section('titulo','Mensagens')
@section('extra-style','<link rel="stylesheet" href="assets/css/messages.css">')

@section('content')
<div class="row">
    <div class="col-md-4 all-persons">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="person-header">
            <input type="text" id="search-conversations" class="form-control" placeholder="Procurar conversas...">
        </div>
        <div id="loadingpersons">
            <div class="loading-chat">
                <i class="fa fa-refresh fa-spin fa-4x fa-fw"></i>
                <span class="sr-only">Loading...</span><br>
                <h4 class="text">A carregar...</h4>
            </div>
        </div>
        <div class="list-group pessoas">

            {{-- Pessoas 
					<div class="list-group-item person"  data-person="username">
					<a href="/" class="a-none">
						<div class="media">
						<div class="pull-left">
                            <img alt="Bootstrap Media Preview" src="http://lorempixel.com/64/64/" class="media-object person-image" width="45" />
						</div>
							<div cl                                                            ass="media-body">
							<div class="content-media">
                                                            <span class="time pull-right">25/07/2016</                                                            span>
								<h5 class="media-heading">Nome:</h5> 
                                                            <tr>
                                                            <td><div><small class="ultima-m                                                                            ensagem pull-left">Ultima Mensagem aqui!</small></div></td>
                                                                                    <td><div class="toRig                                                                                                    ht"><span class="badge pull-r                                                                                                ight">14</span><                                                                                        /div></td>
                                                                                   </tr>

                                                                        </div>	
                                                                </                                                                        div>
                                                        </div>
                                                </a>
                                            </div>
			Pessoas --}}
			</div>
		</div>
		<div class="col-md-8 all-chat">
		<div class="chat-header">
			Para: 
		</div>
		<div class="chat">
			<div id="loading">
				<div class="loading-chat">
                                            <i class="fa fa-refresh fa-spin fa-4x fa-fw"></i>
                                            <span class="sr-only">Loading...</span><br>
                                            <h4 class="text">A carregar...</h4>
                                        </div>
                                    </div>

                                    <div id="messages">
                                        <div class="messages">
                                            <img class="start-image" src="{{ url('/assets/img/conversation.png') }}" width="300" alt="Escolhe uma conversa!">
                                            <h3 style="opacity:0.4;text-align:center;"> Escolhe uma conversa :) </h3>
                                        </div>		
                                    </div>

                                    <div class="inputs">
                                        <div class="input-group">
                                            <input type="text" id="input-mensagem" class="form-control" placeholder="Search for...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="enviar-mensagem">Go!</button>
                                            </span>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
            </div>
            @endsection


            @section('extra-script')
            <script>

                function omitKeys(obj, keys) {
                    var dup = {};
                    for (key in obj) {
                        if (keys.indexOf(key) == -1) {
                            dup[key] = obj[key];
                        }
                    }
                    return dup;
                }

                /**
                 * Obter todas as conversas do usuario!
                 */

                function obter_conversas(loading = 1) {
                    console.log('obtendo conversas...');
                    var token, url, data;

                    token = $('input[name=_token]').val();
                            url = "{{ url('/m/inbox') }}";
                    $.ajax({
                        url: url,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        datatype: 'JSON',
                        beforeSend: function () {
                            if (loading == 1) {
                                $("#loadingpersons").show();
                            }
                        },
                        success: function (response) {
                            var resposta = response['response'];
                            $('.pessoas').empty();

                            if (loading == 1) {
                                $("#loadingpersons").hide();
                            }

                            if (resposta == false) {
                                var error = response['error'];
                                console.log('Pedimos desculpa, ocorreu um erro, tente mais tarde informações: Erro -> ' + error);
                                $(location).attr('href', '{{ url("/") }}');
                                return false;

                            }

                            response = JSON.stringify(omitKeys(response, ['response', 'error']));
                            response = $.parseJSON(response);

                            //console.log(response);
                            $.each(response, function (key, value) {
                                //console.log(key + '  ' + value.thread);
                                var media = $("<div/>", {"class": "media"});
                                var div_image = $("<div/>", {"class": "pull-left"});
                                var image = $("<img/>", {"alt": "" + value.withUser.username + "", "class": "media-object person-image", "width": "45", "src": "http://lorempixel.com/64/64/"});
                                var media_body = $("<div/>", {"class": "media-body"});
                                var content_media = $("<div/>", {"class": "content-media"});
                                var tempo = $("<span/>", {"class": "time pull-right", "text": "" + value.thread.time + ""});
                                var name = $("<h5/>", {"class": "media-heading", "text": "" + value.withUser.username + ""});
                                var tr = $("<tr/>");
                                var td = $("<td/>");
                                var ultima_mensagem = $("<small/>", {"class": "ultima-mensagem pull-left", "text": "" + value.thread.message + ""})
                                var pessoa = $("<div/>", {
                                    "class": "list-group-item person",
                                    "data-person": "" + value.withUser.id + "",
                                    "data-conv": "" + value.thread.conversation_id + ""
                                }).append(media.append(div_image.append(image)).append(media_body.append(content_media.append(tempo).append(name).append(tr.append(td.append(ultima_mensagem))))));
                                $('.pessoas').append(pessoa);

                                //$('#pessoas').append('<option>'+ value.nombre_subramo +'</option>');
                                //[{"receiver_id":2,"name":"user","sender_id":1,"conv_id":2,"message":"mensagem de admin para user","created_at":"2016-08-07 15:35:22","is_seen":0},{"response":false}]
                                /** $.each(value, function (k, v) {
                                 $('.pessoas').append('<span>'+ value.name +'</option>');
                                 });	*/

                            });
                            //console.log(response);
                        }
                    }).done(function () {
                        ative_chat();
                    });

                }

                function enviar_mensagem(conv_id, mensagem) {
                    console.log('enviar mensagem...');
                    var token, url, data;

                    token = $('input[name=_token]').val();
                    url = "{{ url('/m/send/') }}";
                    $.ajax({
                        url: url,
                        headers: {'X-CSRF-TOKEN': token},
                        data: {conv_id: conv_id, mensagem: mensagem},
                        type: 'POST',
                        datatype: 'JSON',
                        beforeSend: function () {
                            if (loading == 1) {
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

                function obter_chat(conv_id, loading = 1) {
                    console.log('obtendo chat...');
                    var token, url, data;

                    token = $('input[name=_token]').val();
                            url = "{{ url('/m/show') }}";
                    $.ajax({
                        url: url,
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        data: {conv_id: conv_id, token: token},
                        datatype: 'JSON',
                        beforeSend: function () {
                            if (loading == 1) {
                                $("#loading").show();
                            }
                        },
                        success: function (response) {
                            var resposta = response['response'];
                            if (loading == 1) {
                                $("#loading").hide();
                            }

                            if (resposta == false) {
                                var error = response['error'];
                                console.log('Pedimos desculpa, ocorreu um erro, tente mais tarde informações: Erro -> ' + error);
                                $(location).attr('href', '{{ url("/") }}');
                            } else {
                                $('#messages').empty();

                                response = JSON.stringify(omitKeys(response, ['response', 'error']));
                                response = jQuery.parseJSON(response);
                                //console.log(response);
                                var messages = $("<div/>", {"class": "messages", "data-conv_id": "" + conv_id + ""});
                                $.each(response.messages, function (key, value) {


                                    /*	<div class="messages" data-person="">
                                     <div class="bubble-me" id="">Olá tudo bem ? eu sou o admin</div>
                                     <div class="bubble-you" id="">Olá tudo bem ? eu sou o admin</div>
                                     </div> 
                                     */
                                    var bubble_me = $("<div/>", {"class": "bubble-me", "id": "" + value.id + "", "text": "" + value.message + ""});
                                    var bubble_you = $("<div/>", {"class": "bubble-you", "id": "" + value.id + "", "text": "" + value.message + ""});

                                    if (value.me == true) {
                                        var result = bubble_me;
                                        //$(messages).append(bubble_me);
                                    } else {
                                        var result = bubble_you;
                                        //$(messages).append(bubble_you);
                                    }
                                    messages.append(result);

                                });
                                $('#messages').append(messages);
                                $('.messages').animate({scrollTop: $(document).height()}, 0);
                                //$('#messages').scrollTop($('#messages')[0].scrollHeight);

                            }

                        },
                        error: function (xhr, status, error) {
                            console.log('Error: ' + error + 'status: ' + status);
                        }
                    });
                }

                function ative_chat() {
                    $('.person').click(function (e) {
                        e.preventDefault();
                        //console.log('clicou');
                        $conv_id = $(this).attr("data-conv");
                        var person = $(this).attr("data-person");
                        $('.messages').addClass('active-messages');//where conv id ativar !!!!!!!

                        obter_chat($conv_id);

                    });
                }

                $(document).ready(function () {
                    obter_conversas();

                    $('#enviar-mensagem').click(function () {
                        var mensagem = $('#input-mensagem').val();
                        if (mensagem != "" && $conv_id != '') {
                            enviar_mensagem($conv_id, mensagem);
                            $('#input-mensagem').val("");
                            obter_chat($conv_id, 0);
                            obter_conversas(0);

                        }

                    });
                });
            </script>
            @endsection