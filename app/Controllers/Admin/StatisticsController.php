<?php

namespace OfficeMe\Controllers\Admin;

use
OfficeMe\Model\FinancialModel,
OfficeMe\Model\CustomersModel,
OfficeMe\Model\DataTablesModel,
Illuminate\Pagination\LengthAwarePaginator,
Illuminate\Http\Request,
Carbon\Carbon;

class StatisticsController
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */

    public function __construct()
    {

    }

    public static function percentAtoB($A, $B)
    {

        if (!$A) {
            $A = 0;
        }

        if (!$B) {
            $B = 0;
        }

        if ($B == 0 && $A > 0) {

            return (object) ['percent' => 100, 'diff_percent' => 100, 'direction' => '+'];

        } else if ($B == 0 && $A <= 0) {
            return (object) ['percent' => 0, 'diff_percent' => 0, 'direction' => '-'];
        }

        $percent = ($A / $B) * 100;
        $percent = $percent > 100 ? 100 : $percent;

        // Calcula a diferença entre A e B
        $diferenca = $A - $B;

        $diff_percent = abs(($diferenca / $B) * 100);
        $diff_percent = $diff_percent > 100 ? 100 : $diff_percent;

        // Determina se a diferença é positiva ou negativa
        $direction = ($diferenca >= 0) ? '+' : '-';

        return (object) ['percent' => round($percent), 'diff_percent' => round($diff_percent), 'direction' => $direction];

    }

    public static function chartOneDashBoard($type = 'deposit')
    {
        $queryResult = FinancialModel::selectRaw('MONTH(created_at) as month, SUM(value) as total')
            ->where('type', $type)
            ->where('created_at', '>=', Carbon::now()->subMonths(11)) // Seleciona os últimos 12 meses
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        // Inicializa um array para armazenar os resultados
        $result = [];

        // Preenche o array com os resultados da consulta
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT); // Adiciona um zero à esquerda, se necessário
            $result[$month] = $queryResult->has($i) ? $queryResult[$i] : 0;
        }

        return $result;

    }

    public static function dashboard_one()
    {

        try {

            if(!is_admin()){
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }

            $chartGraph_deposit = StatisticsController::chartOneDashBoard();
            $chartGraph_withdraw = StatisticsController::chartOneDashBoard('withdraw');

            $m = (int) date('n');
            $y = (int) date('Y');

            $m_before = $m - 1;
            $y_before = $y;

            if ($m == 1) {
                $m_before = 12;
                $y_before -= 1;
            }

            // get news customers
            $news_customers = CustomersModel::getNewsByMY($m, $y);
            $news_customers_before = CustomersModel::getNewsByMY($m_before, $y_before);

            $news_customers_num = $news_customers ? count($news_customers) : 0;
            $news_customers_before_num = $news_customers ? count($news_customers_before) : 0;


            // get customers Renovateds
            $renovateds_customers = CustomersModel::getRenovatedByMY($m, $y);
            $renovateds_customers_before = CustomersModel::getRenovatedByMY($m_before, $y_before);

            $renovateds_customers_num = $renovateds_customers ? count($renovateds_customers) : 0;
            $renovateds_customers_before_num = $renovateds_customers_before ? count($renovateds_customers_before) : 0;

            // get financials
            $financials = FinancialModel::getByMY($m, $y);
            $financials_before = FinancialModel::getByMY($m_before, $y_before);


            $financials_num = 0;
            $financials_before_num = 0;

            if ($financials) {
                foreach ($financials as $k => $v) {
                    $financials_num = $financials_num + $v->value;
                }
            }

            if ($financials_before) {
                foreach ($financials_before as $k => $v) {
                    $financials_before_num = $financials_before_num + $v->value;
                }
            }

            // percents 
            $news_customers_percent = StatisticsController::percentAtoB($news_customers_num, $news_customers_before_num);
            $renovateds_customers_percent = StatisticsController::percentAtoB($renovateds_customers_num, $renovateds_customers_before_num);
            $financial_percent = StatisticsController::percentAtoB($financials_num, $financials_before_num);

            response()->json([
                'success' => true,
                'data' => [
                    'charts' => [
                        'money' => [
                            'deposit'  => array_values($chartGraph_deposit),
                            'withdraw' => array_values($chartGraph_withdraw),
                        ]
                    ],
                    'news_customers' => [
                        'n' => $news_customers_num,
                        'percent' => $news_customers_percent->percent,
                        'diff' => $news_customers_percent->diff_percent,
                        'direction' => $news_customers_percent->direction
                    ],
                    'renovateds_customers' => [
                        'n' => $renovateds_customers_num,
                        'percent' => $renovateds_customers_percent->percent,
                        'diff' => $renovateds_customers_percent->diff_percent,
                        'direction' => $renovateds_customers_percent->direction
                    ],
                    'financials' => [
                        'n' => $financials_num,
                        'percent' => $financial_percent->percent,
                        'diff' => $financial_percent->diff_percent,
                        'direction' => $financial_percent->direction
                    ]

                ]
            ]);

        } catch (\Exception $e) {

            response()->json([
                'title' => 'Error',
                'success' => false,
                'message' => $e->getMessage()
            ]);

        }


    }

    public function get(int $fid)
    {
        try {

            if(!is_admin()){
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }


            if (!$fid) {
                response()->json([
                    'title' => 'Error',
                    'success' => false,
                    'message' => 'Informe o id da movimentação'
                ]);
            }

            if (!is_numeric($fid)) {
                response()->json([
                    'title' => 'Error',
                    'success' => false,
                    'message' => 'Informe o id da movimentação'
                ]);
            }

            $fin = FinancialModel::getById($fid);

            if ($fin) {
                response()->json([
                    'success' => true,
                    'data' => (object) [
                        'id' => $fin->id,
                        'value' => $fin->value,
                        'description' => $fin->description,
                        'type' => $fin->type,
                        'plan_id' => $fin->plan_id,
                        'created_at' => explode(' ', $fin->created_at)[0]
                    ]
                ]);
            } else {
                response()->json([
                    'title' => 'Error',
                    'success' => false,
                    'message' => 'Movimentação não localizada'
                ]);
            }

        } catch (\Exception $e) {
            response()->json([
                'title' => 'Error',
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
     

}