<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalarieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Seuls les RH et admin peuvent créer des salariés
        return $this->user() && ($this->user()->isRH() || $this->user()->isAdmin());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'service_id' => 'required|exists:services,id',
            'poste' => 'required|string|max:255',
            'date_embauche' => 'required|date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'Veuillez fournir une adresse email valide',
            'email.unique' => 'Cette adresse email est déjà utilisée',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
            'service_id.required' => 'Veuillez sélectionner un service',
            'service_id.exists' => 'Le service sélectionné n\'existe pas',
            'poste.required' => 'Le poste est obligatoire',
            'date_embauche.required' => 'La date d\'embauche est obligatoire',
            'date_embauche.date' => 'Veuillez fournir une date valide',
        ];
    }
} 