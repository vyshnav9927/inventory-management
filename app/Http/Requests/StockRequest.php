<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'warehouse_id' => 'required|integer|min:1|exists:warehouses,id',
            'product_id' => 'required|integer|min:1|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
            'type' => [
                'required',
                'integer',
                'in:0,1',
                function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $current = (int)DB::table('stock_movements')->select(DB::raw('SUM(CASE WHEN type = 1 THEN quantity ELSE -quantity END) as stock_levels'))
                            ->where('warehouse_id', request('warehouse_id'))
                            ->where('product_id', request('product_id'))
                            ->groupBy('warehouse_id', 'product_id')
                            ->value('stock_levels') ?? 0;
                        if ($current == 0) {
                            $fail('Stock Already Empty! Cannot Move Out.');
                        }
                    }
                }
            ]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
