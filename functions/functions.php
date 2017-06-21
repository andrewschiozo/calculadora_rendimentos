<?php
function debug($var){
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}

function brl_to_float($brl_value)
{
    $brl_value = str_replace(' ', '', $brl_value);
    $brl_value = str_replace('R$', '', $brl_value);
    $brl_value = str_replace('.', '', $brl_value);
    $brl_value = str_replace(',', '.', $brl_value);
    return $brl_value;
}

function calcular_rendimento_diario($investimento, $porcentagem)
{
    return (($investimento * ($porcentagem / 100)) / 30);
}

function calcular_fim_carencia(Datetime $data_aporte, $carencia)
{
  $data_fim_carencia = clone $data_aporte;

  if ($carencia != 0) {
      $carencia_calculo = $carencia - 1;
      $data_fim_carencia->add(new DateInterval("P{$carencia_calculo}D"));
  }

  return $data_fim_carencia;
}

function calcular_dias_pagamento(DateTime $data_ultimo_pagamento, Datetime $data_pagamento, Datetime $data_investimento, Datetime $data_fim_carencia) {

  $dias_a_pagar = 0;

  //Cálculo de dias
  if ($data_pagamento <= $data_fim_carencia) {
      $dias_a_pagar = 0;
  } elseif ($data_ultimo_pagamento <= $data_fim_carencia) {
      $dias_a_pagar = $data_pagamento->diff($data_fim_carencia)->days;
  } else {
      $dias_a_pagar = $data_pagamento->diff($data_ultimo_pagamento)->days;
  }

  return $dias_a_pagar;
}

$aportes = $_POST['aporte'];

$data_ultimo_pagamento = new DateTime($_POST['data_inicial'] . ' 00:00:00');
$data_pagamento = new DateTime($_POST['data_final'] . ' 00:00:00');

for($i = 1; $i <= count($aportes); $i++)
{
    $data = $aportes[$i]['data'] . ' 00:00:00';
    $valor = brl_to_float($aportes[$i]['valor']);
    $porcentagem = $aportes[$i]['porcentagem'];
    $carencia = $aportes[$i]['carencia'];
    $data_aporte = new DateTime($data);
    unset($aportes[$i]['data']);

    $aportes[$i]['rendimento_diario'] = calcular_rendimento_diario($valor, $porcentagem);
    $aportes[$i]['data_aporte'] = $data_aporte;
    $aportes[$i]['data_fim_carencia'] = calcular_fim_carencia($data_aporte, $carencia);
    $data_fim_carencia = $aportes[$i]['data_fim_carencia'];
    $aportes[$i]['dias_a_pagar'] = calcular_dias_pagamento($data_ultimo_pagamento, $data_pagamento, $data_aporte, $data_fim_carencia);
    $aportes[$i]['rendimento_por_periodo'] = $aportes[$i]['rendimento_diario'] * $aportes[$i]['dias_a_pagar'];
}

$total = 0;
foreach($aportes as $aporte)
{
  $total += $aporte['rendimento_por_periodo'];
}

echo json_encode(array('soma_rendimento_por_periodo' => number_format($total, 2, ',', '.'),
                 'aportes' => $aportes));
