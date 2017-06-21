String.prototype.replaceAll = function( match , replace ) {
  return this.split( match ).join( replace );
};

//Formatação de campo valorado em R$
Number.prototype.formatMoney = function (c, d, t) {
    var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "," : d,
            t = t == undefined ? "." : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

//Máscara para campos com valores R$
function mascara_brl(value)
{
    //Máscara do campo (R$)
    value = value.replace(/\D/g, '');
    value = value.replace(/(\d{1,2})$/, ',$1');
    value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    return value;
}

$(function(){
  $('[data-toggle="tooltip"]').tooltip();

  //Aplicação da máscara no campo de valor do aporte
  $('.aporte_set').on('keyup', '.aporte_valor', function(){
    $(this).val(mascara_brl($(this).val()));
  });

  //Botão incluir campo para aporte
  aporte_set_html = $(".aporte_set").html();
  count = 1;
  $("#btn_incluir_aporte").click(function(){
    old_id = count;
    old_id_string = "#" + old_id;
    new_id = count + 1;
    new_id_string = "#" + new_id;
    old_name = "name=\"aporte[" + count;
    new_name = "name=\"aporte[" + new_id;

    aporte_set_html = aporte_set_html.replace(old_id_string, new_id_string);
    aporte_set_html = aporte_set_html.replaceAll(old_name, new_name);
    $(".aporte_set").append(aporte_set_html);
    count += 1;
  });

  //Botão enviar formulário
  $("#btn_enviar_form").click(function(){
    form_data = $('#form_calculadora').serialize();
    $.ajax({
      url: 'functions/functions.php',
      type: 'POST',
      dataType: 'json',
      data: form_data,
      success: function(data){
        $('.calculo_detalhado').text('');
        $("#rendimento_total").text('R$ ' + data.soma_rendimento_por_periodo);
        $.each(data.aportes, function (index, aporte) {
            var h3 = '<div class="row"><div class="col-md-1"> ' +
                      '<h3>#' + index + '</h3> ' +
                      '</div>' +
                      '<div class="col-md-4">' +
                        '<h3>' + aporte.valor +
                                 ' x ' + aporte.porcentagem +
                                 '% / 30 x ' + aporte.dias_a_pagar +
                                 ' dias =  ' +
                        '</h3>' +
                      '</div>' +
                      '<div class="col-md-2">' +
                        '<h3>' + aporte.rendimento_por_periodo + '</h3>' +
                        '</div></div>';
            $('.calculo_detalhado').append(h3);
        });
      }
    });
  });

});
