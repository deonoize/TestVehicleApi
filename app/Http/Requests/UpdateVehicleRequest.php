<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array {
        return [
            'model'  => 'required|string|max:255',
            'number' => 'required|string|max:255|unique:vehicles,number,'.$this->vehicle->id,
        ];
    }
}
