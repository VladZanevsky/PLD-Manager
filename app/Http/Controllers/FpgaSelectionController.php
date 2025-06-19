<?php

namespace App\Http\Controllers;

use App\Models\FpgaComponent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FpgaSelectionController extends Controller
{
    public function compare(Request $request)
    {
        $selectedIds = $request->input('selected', []);
        if (empty($selectedIds)) {
            return redirect()->route('fpga.select')->with('error', 'Выберите компоненты для сравнения');
        }
        $components = FpgaComponent::whereIn('id', $selectedIds)->with('standards')->get();
        session()->put('comparison_components', $components);
        return view('compare', ['components' => $components]);
    }

    public function select(Request $request)
    {
        $requirements = $request->validate([
            'frequency' => 'nullable|numeric|min:0',
            'lut_count' => 'nullable|numeric|min:0',
            'power' => 'nullable|numeric|min:0',
            'io_count' => 'nullable|numeric|min:0',
            'priority' => 'nullable|in:frequency,lut_count,power,cost,io_count,balanced',
            'prefer_domestic' => 'nullable|boolean',
            'standard_ids' => 'nullable|array',
            'standard_ids.*' => 'exists:standards,id',
            'weight_frequency' => 'nullable|numeric|min:0|max:100',
            'weight_lut_count' => 'nullable|numeric|min:0|max:100',
            'weight_power' => 'nullable|numeric|min:0|max:100',
            'weight_cost' => 'nullable|numeric|min:0|max:100',
            'weight_io_count' => 'nullable|numeric|min:0|max:100',
        ]);

        $components = FpgaComponent::query()
            ->with('manufacturer')
            ->when($requirements['frequency'] !== null, function ($query) use ($requirements) {
                $query->where('frequency', '>=', $requirements['frequency']);
            })
            ->when($requirements['lut_count'] !== null, function ($query) use ($requirements) {
                $query->where('lut_count', '>=', $requirements['lut_count']);
            })
            ->when($requirements['power'] !== null, function ($query) use ($requirements) {
                $query->where('power', '<=', $requirements['power']);
            })
            ->when($requirements['io_count'] !== null, function ($query) use ($requirements) {
                $query->where('io_count', '>=', $requirements['io_count']);
            })
            ->when(!empty($requirements['standard_ids']), function ($query) use ($requirements) {
                foreach ($requirements['standard_ids'] as $standardId) {
                    $query->whereHas('standards', function ($q) use ($standardId) {
                        $q->where('standards.id', $standardId);
                    });
                }
            })
            ->get();

        if ($components->isEmpty()) {
            return view('result', ['components' => [], 'message' => __('messages.fpga_component.no_components_found')]);
        }

        // Нормализация параметров
        $minMax = [
            'frequency' => ['min' => $components->min('frequency'), 'max' => $components->max('frequency')],
            'lut_count' => ['min' => $components->min('lut_count'), 'max' => $components->max('lut_count')],
            'power' => ['min' => $components->min('power'), 'max' => $components->max('power')],
            'cost' => ['min' => $components->min('cost'), 'max' => $components->max('cost')],
            'io_count' => ['min' => $components->min('io_count'), 'max' => $components->max('io_count')],
        ];

        $normalized = $components->map(function ($component) use ($minMax) {
            $component->norm_frequency = ($minMax['frequency']['max'] - $minMax['frequency']['min']) > 0
                ? ($component->frequency - $minMax['frequency']['min']) / ($minMax['frequency']['max'] - $minMax['frequency']['min'])
                : 0.5;
            $component->norm_lut_count = ($minMax['lut_count']['max'] - $minMax['lut_count']['min']) > 0
                ? ($component->lut_count - $minMax['lut_count']['min']) / ($minMax['lut_count']['max'] - $minMax['lut_count']['min'])
                : 0.5;
            $component->norm_power = ($minMax['power']['max'] - $minMax['power']['min']) > 0
                ? 1 - (($component->power - $minMax['power']['min']) / ($minMax['power']['max'] - $minMax['power']['min']))
                : 0.5;
            $component->norm_cost = ($minMax['cost']['max'] - $minMax['cost']['min']) > 0
                ? 1 - (($component->cost - $minMax['cost']['min']) / ($minMax['cost']['max'] - $minMax['cost']['min']))
                : 0.5;
            $component->norm_io_count = ($minMax['io_count']['max'] - $minMax['io_count']['min']) > 0
                ? ($component->io_count - $minMax['io_count']['min']) / ($minMax['io_count']['max'] - $minMax['io_count']['min'])
                : 0.5;
            return $component;
        });

        // Если пользователь отправил свои веса, используем их
        if (
            isset($requirements['weight_frequency']) &&
            isset($requirements['weight_lut_count']) &&
            isset($requirements['weight_power']) &&
            isset($requirements['weight_cost']) &&
            isset($requirements['weight_io_count'])
        ) {
            $rawWeights = [
                'frequency' => $requirements['weight_frequency'],
                'lut_count' => $requirements['weight_lut_count'],
                'power' => $requirements['weight_power'],
                'cost' => $requirements['weight_cost'],
                'io_count' => $requirements['weight_io_count'],
            ];
            $sum = array_sum($rawWeights);
            $selectedWeights = $sum > 0
                ? array_map(fn($weight) => $weight / $sum, $rawWeights)
                : ['frequency' => 0.2, 'lut_count' => 0.2, 'power' => 0.2, 'cost' => 0.2, 'io_count' => 0.2];
        } else {

            $weights = [
                'frequency' => ['frequency' => 0.3, 'lut_count' => 0.175, 'power' => 0.175, 'cost' => 0.175, 'io_count' => 0.175],
                'lut_count' => ['frequency' => 0.175, 'lut_count' => 0.3, 'power' => 0.175, 'cost' => 0.175, 'io_count' => 0.175],
                'power' => ['frequency' => 0.175, 'lut_count' => 0.175, 'power' => 0.3, 'cost' => 0.175, 'io_count' => 0.175],
                'cost' => ['frequency' => 0.175, 'lut_count' => 0.175, 'power' => 0.175, 'cost' => 0.3, 'io_count' => 0.175],
                'io_count' => ['frequency' => 0.175, 'lut_count' => 0.175, 'power' => 0.175, 'cost' => 0.175, 'io_count' => 0.3],
                'balanced' => ['frequency' => 0.2, 'lut_count' => 0.2, 'power' => 0.2, 'cost' => 0.2, 'io_count' => 0.2]
            ];
            $selectedWeights = $weights[$requirements['priority'] ?? 'frequency'];
        }
        // Ранжирование
        $ranked = $normalized->map(function ($component) use ($selectedWeights, $requirements) {
            $component->score = $selectedWeights['frequency'] * $component->norm_frequency +
                $selectedWeights['lut_count'] * $component->norm_lut_count +
                $selectedWeights['power'] * $component->norm_power +
                $selectedWeights['cost'] * $component->norm_cost +
                $selectedWeights['io_count'] * $component->norm_io_count;

            if (isset($requirements['prefer_domestic']) &&
                $requirements['prefer_domestic'] &&
                $component->manufacturer &&
                in_array(mb_strtolower(trim($component->manufacturer->country)), ['беларусь', 'россия']))
            {
                $component->score *= 1.2;
            }

            return $component;
        })->sortByDesc('score')->take(5);

        $maxScore = $components->max('score');

        return view('result', [
            'components' => $ranked,
            'maxScore' => $maxScore,
            'message' => null,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $components = session('comparison_components', collect([]));

        $chartImages = $request->input('chart_images', []);

        $pdf = Pdf::loadView('pdf.comparison', compact('components', 'chartImages'));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('compare_fpga.pdf');
    }
}
