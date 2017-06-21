<div class="container">
  <h2><span class="glyphicon glyphicon-bitcoin"></span> Calculadora de Rendimentos</h2>
  <hr>
  <form role="form" id="form_calculadora">
    <fieldset>
      <legend>Período</legend>
      <div class="row">
        <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
          <label><span class="glyphicon glyphicon-calendar"></span> Data inicial</label>
          <input type="date" class="form-control" name="data_inicial" />
        </div>
        <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
          <label><span class="glyphicon glyphicon-calendar"></span> Data final</label>
          <input type="date" class="form-control" name="data_final" />
        </div>
      </div>
    </fieldset>

    <fieldset>
      <legend>Aportes</legend>
      <table id="aportes" class="table table-stripped">
        <thead>
          <tr>
            <th>#</th>
            <th data-toggle="tooltip" data-placement="left" title="Se carência for igual a zero preencha com a data do último pagamento, senão preencha com a data do aporte.">
              <span class="glyphicon glyphicon-calendar"></span> Data</th>
            <th><span class="glyphicon glyphicon-usd"></span>  Valor</th>
            <th><span class="glyphicon glyphicon-minus"></span> Carência</th>
            <th>% Porcentagem</th>
          </tr>
        </thead>
        <tbody class="aporte_set">
          <tr>
            <td>#1</td>
            <td>
              <input type="date" class="form-control" name="aporte[1][data]" />
            </td>
            <td>
              <input type="text" class="form-control aporte_valor" name="aporte[1][valor]" />
            </td>
            <td>
              <input type="number" class="form-control" name="aporte[1][carencia]"  />
            </td>
            <td>
              <input type="number" class="form-control" name="aporte[1][porcentagem]"  />
            </td>
          </tr>
        </tbody>
      </table>
    </fieldset>

    <div class="row">
      <div class="form-group col-md-6">
        <div class="btn btn-primary" id="btn_incluir_aporte">
          <span class="glyphicon glyphicon-plus"></span> Incluir aporte</div>
      </div>
        <div class="form-group col-md-6 text-right">
          <div class="btn btn-success" id="btn_enviar_form">Calcular aporte</div>
        </div>
    </div>

  </form>

  <h2 class="text-center" id="rendimento_total"></h2>
  <h4 class="text-center">Rendimento = Valor do investimento x Porcentagem / 30 x Dias de rendimento</h4>
  <div class="calculo_detalhado"></div>
</div>
