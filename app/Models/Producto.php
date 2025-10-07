<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'cocinero_id',
        'categoria_id',
        'nombre',
        'descripcion',
        'precio',
        'tiempo_preparacion_min',
        'imagenes',
        'ingredientes',
        'alergenos',
        'porciones',
        'disponible',
        'stock_disponible',
        'es_vegetariano',
        'es_vegano',
        'es_sin_gluten',
        'vistas',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'imagenes' => 'array',
        'ingredientes' => 'array',
        'alergenos' => 'array',
        'disponible' => 'boolean',
        'es_vegetariano' => 'boolean',
        'es_vegano' => 'boolean',
        'es_sin_gluten' => 'boolean',
        'tiempo_preparacion_min' => 'integer',
        'porciones' => 'integer',
        'stock_disponible' => 'integer',
        'vistas' => 'integer',
    ];

    /**
     * Relación: Un producto pertenece a una categoría
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Relación: Un producto pertenece a un cocinero (usuario)
     */
    public function cocinero(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cocinero_id');
    }

    /**
     * Scope: solo productos disponibles
     */
    public function scopeDisponible($query)
    {
        return $query->where('disponible', true);
    }

    /**
     * Scope: filtrar por categoría
     */
    public function scopeDeCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    /**
     * Scope: productos vegetarianos
     */
    public function scopeVegetariano($query)
    {
        return $query->where('es_vegetariano', true);
    }

    /**
     * Scope: productos veganos
     */
    public function scopeVegano($query)
    {
        return $query->where('es_vegano', true);
    }

    /**
     * Scope: productos sin gluten
     */
    public function scopeSinGluten($query)
    {
        return $query->where('es_sin_gluten', true);
    }

    /**
     * Accessor: precio formateado con símbolo
     */
    public function getPrecioFormateadoAttribute(): string
    {
        return 'Bs. ' . number_format($this->precio, 2);
    }

    /**
     * Accessor: primera imagen o placeholder
     */
    public function getPrimeraImagenAttribute(): ?string
    {
        if (empty($this->imagenes)) {
            return null;
        }

        return is_array($this->imagenes) ? ($this->imagenes[0] ?? null) : null;
    }

    /**
     * Incrementar vistas
     */
    public function incrementarVistas(): void
    {
        $this->increment('vistas');
    }
}
