<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'description',
    ];
    
    /**
     * Définit la relation avec les utilisateurs.
     * Un service a plusieurs utilisateurs.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
