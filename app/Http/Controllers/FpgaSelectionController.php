<?php

namespace App\Http\Controllers;

use App\Models\FpgaComponent;
use Illuminate\Http\Request;

class FpgaSelectionController extends Controller
{
    public function select(Request $request)
    {
        // Получение входных данных
        $requirements = $request->validate([
            'frequency' => 'required|numeric|min:0',
            'lut_count' => 'required|numeric|min:0',
            'power' => 'required|numeric|min:0',
            'io_count' => 'required|numeric|min:0',
            'priority' => 'required|in:frequency,lut_count,power,cost,balanced'
        ]);

        // Фильтрация компонентов
        $components = FpgaComponent::where('frequency', '>=', $requirements['frequency'])
            ->where('lut_count', '>=', $requirements['lut_count'])
            ->where('power', '<=', $requirements['power'])
            ->where('io_count', '>=', $requirements['io_count'])
            ->get();

        if ($components->isEmpty()) {
            return view('results', ['components' => [], 'message' => 'Нет подходящих ИСПЛ']);
        }

        // Нормализация параметров
        $minMax = [
            'frequency' => ['min' => $components->min('frequency'), 'max' => $components->max('frequency')],
            'lut_count' => ['min' => $components->min('lut_count'), 'max' => $components->max('lut_count')],
            'power' => ['min' => $components->min('power'), 'max' => $components->max('power')],
            'cost' => ['min' => $components->min('cost'), 'max' => $components->max('cost')]
        ];

        $normalized = $components->map(function ($component) use ($minMax) {
            $component->norm_frequency = ($minMax['frequency']['max'] - $minMax['frequency']['min']) > 0
                ? ($component->frequency - $minMax['frequency']['min']) / ($minMax['frequency']['max'] - $minMax['frequency']['min'])
                : 1;
            $component->norm_lut_count = ($minMax['lut_count']['max'] - $minMax['lut_count']['min']) > 0
                ? ($component->lut_count - $minMax['lut_count']['min']) / ($minMax['lut_count']['max'] - $minMax['lut_count']['min'])
                : 1;
            $component->norm_power = ($minMax['power']['max'] - $minMax['power']['min']) > 0
                ? 1 - (($component->power - $minMax['power']['min']) / ($minMax['power']['max'] - $minMax['power']['min']))
                : 1;
            $component->norm_cost = ($minMax['cost']['max'] - $minMax['cost']['min']) > 0
                ? 1 - (($component->cost - $minMax['cost']['min']) / ($minMax['cost']['max'] - $minMax['cost']['min']))
                : 1;
            return $component;
        });

        // Определение весов на основе приоритета
        $weights = [
            'frequency' => ['frequency' => 0.5, 'lut_count' => 0.167, 'power' => 0.167, 'cost' => 0.167],
            'lut_count' => ['frequency' => 0.167, 'lut_count' => 0.5, 'power' => 0.167, 'cost' => 0.167],
            'power' => ['frequency' => 0.167, 'lut_count' => 0.167, 'power' => 0.5, 'cost' => 0.167],
            'cost' => ['frequency' => 0.167, 'lut_count' => 0.167, 'power' => 0.167, 'cost' => 0.5],
            'balanced' => ['frequency' => 0.25, 'lut_count' => 0.25, 'power' => 0.25, 'cost' => 0.25]
        ];
        $selectedWeights = $weights[$requirements['priority']];

        // Ранжирование
        $ranked = $normalized->map(function ($component) use ($selectedWeights) {
            $component->score = $selectedWeights['frequency'] * $component->norm_frequency +
                $selectedWeights['lut_count'] * $component->norm_lut_count +
                $selectedWeights['power'] * $component->norm_power +
                $selectedWeights['cost'] * $component->norm_cost;
            return $component;
        })->sortByDesc('score')->take(5);

        // Передача результатов в шаблон
        return view('results', ['components' => $ranked, 'message' => null]);
    }
}
