<?php

namespace App\Models;

use App\Casts\TitleCaseCast;
use App\Data\FilterData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;

final class Nivel extends Model
{
    use HasFactory;

    protected $table = 'niveis';

    protected $fillable = [
        'nivel',
    ];

    public static function index(FilterData $filter): LengthAwarePaginator
    {
        return self::query()
            ->when($filter->search, function (Builder $query) use ($filter) {
                $query->whereLike('nivel', "{$filter->search}%");
            })
            ->paginate($filter->pagination->per_page);
    }

    public function desenvolvedores(): HasMany
    {
        return $this->hasMany(Desenvolvedor::class, 'nivel_id');
    }

    protected function casts(): array
    {
        return [
            'nivel' => TitleCaseCast::class,
        ];
    }
}
