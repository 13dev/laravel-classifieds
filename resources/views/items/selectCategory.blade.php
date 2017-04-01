@extends('layouts.app')

@section('titulo','Adicionar Anuncio')

@section('content')
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="row">
    <div id="warnings"></div>

    <div id="loading">
        <div class="loading-category">
            <i class="fa fa-refresh fa-spin fa-4x fa-fw"></i>
            <span class="sr-only">Loading...</span><br>
            <h4 class="text">A carregar...</h4>
        </div>
    </div>
    <div id="code"></div>
    <div id="divbotao" style="display:none;">
        <div class="form-group">
            <button id="botao" class="btn btn-success">Adicionar</button>
        </div>
    </div>

</div>

@endsection

@section('extra-style')
<style>
    .select-category {
        max-width:200px; 
        margin:5px;
        display: inline-block;
    }

    #loading {
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -50px;
        opacity: 0.7;
    }
    .loading-category .text {
        margin-left: -10px;
    }

</style>
@endsection

@section('extra-script')
<script>

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
    function redirect(url){
        return $(location).attr('href', '{{ url("' + url + '") }}');
    } 
    $lastChild = 0;
    $returnAjax = null;


    var count = 0;
    function getChild(id) {
        console.log('Obtendo filhos..');
        var token, url;
        token = $('input[name=_token]').val();
        url = "{{ url('category/getChilds') }}";
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': token},
            data: {childs: id},
            type: 'POST',
            datatype: 'JSON',
            beforeSend: function () {
                $(".loading-category").show();
                $("#code :input").attr("disabled", true);
            },
            success: function (response) {
                $(".loading-category").hide();
                $("#code :input").attr("disabled", false);
                var responseResponse = response.response;
                var haveChilds = response.haveChilds;
                var responseCode = response.code;

                if (!responseResponse) {
                    message('Ups ocurreu um erro inesperado, porfavor tente novamente', 'Ups!', 'danger',false);
                    $returnAjax = false;
                    return false;
                }
                $lastChild = id;
                if (haveChilds === true) {
                    $("#divbotao").hide();
                    count++;
                    console.log('Tem filhos..');
                    // Desativar botão de seguir..
                    // descentId é o id do select descendente
                    var selectId = "cat" + count;

                    var select = $("<select/>", {"id": selectId, "class": "form-control select-category"});

                    $(select).attr('size', 11);

                    $.each(responseCode, function (key, value) {
                        var option = $('<option/>', {"value": value.id, "text": value.title});
                        $(select).append(option);
                    });

                    $('#code').append(select);

                    $(select).on('change', function () {
                        // Remove all select after this select
                        $(this).nextAll('select').remove();
                        getChild($(this).val());
                    });
                    $returnAjax = 1;
                } else {
                    $("#divbotao").show();
                    console.log('Não Tem filhos..');
                    $returnAjax = 0;
                }
            }
            ,
            error: function (xhr, status, error) {
                message('Falha inesperada. Por favor, tente novamente, pedimos desculpas', 'Erro!', 'danger');
                $("#code :input").attr("disabled", true);
                $("#botao").attr("disabled", true);
                $(".loading-category").show();
                url = "{{ url('/') }}";
                $(location).attr("href", url);
                console.log('Error: ' + error + 'status: ' + status);
                return false;
            }
        });
    }

    $(document).ready(function () {
        getChild(0);
        $("#botao").click(function () {
            if ($lastChild === 0) {
                message('Por favor selecione uma categoria!', 'Ups!', 'warning');
            } else {
                switch ($returnAjax) {
                    case 0:
                        message('Aguarde, será redirecionado daqui a instantes...', 'Sucesso!', 'warning', false);
                        $("#code :input").attr("disabled", true);
                        $("#botao").attr("disabled", true);
                        $(".loading-category").show();
                        url = "{{ url('/a/add/item/') }}";
                        url = url + "/" + $lastChild;
                        $(location).attr("href", url);
                        break;
                    case 1:
                        message('Por favor selecione uma categoria final!', 'Ups!', 'warning');
                        break;
                    case false:
                        message('Ups ocurreu um erro inesperado, por favor tente novamente', 'Ups!', 'danger', false);
                        break;
                }
            }
        });
    });
</script>

@endsection